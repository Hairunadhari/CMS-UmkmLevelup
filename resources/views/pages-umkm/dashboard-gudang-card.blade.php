<div class="row">
    <div class="col-md-11">
        <div class="row">
            @php
                $i = 1;
                $n = 1;
            @endphp
            @forelse ($transaction as $key => $item)
                @if ($key < 41)
                    @php $i++; @endphp
                @else
                    @break
                @endif
                @if ($key == 20)
                </div><div class="row">
                @endif
                <div class="col" style="max-width:300px">
                    <div class="portlet-box portlet-fullHeight mb-10 mt-10" style="height: calc(100% - 20px); border-radius: 3px; box-shadow: 0 4px 8px rgb(0 0 0 / 3%)">
                        <div class="portlet-header flex-row flex d-flex align-items-center" style="padding:1rem">
                            <div class="flex d-flex justify-content-center">
                                <h5 style="margin-bottom: 0">Antrean <span class="text-danger">{{$item->id}}</span></h5> 
                                {{-- <button type="button" data-status="{{$item->status}}" data-id="{{$item->id}}" class="float-right btn btn-dark btn-icon btn-icon-right btn-sm modalUpdate">
                                    <i class="fa fa-arrow-right"></i>
                                    Update
                                </button> --}}
                            </div>
                            <div class="portlet-tools">
                            </div>
                        </div>
                        <div class="portlet-body no-padding">
                            <div class="list">
                                <div class="list-item b-b bg-light">
                                    <div class="list-thumb shadow-sm avatar40 bg-danger text-white text-secondary-light rounded">
                                        {{$item->num_tenant}}
                                    </div>
                                    <div class="list-body">
                                        <span class="list-title mb-0">{{$item->nama_user}}</span>
                                        <span class="list-content pt-1 text-dark" style="font-size: 12px; font-weight:bold; letter-spacing: ">
                                            <i class="fa text-dark fa-clock mr-1"></i>
                                            {{\Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans()}}
                                        </span>
                                    </div>
                                </div><!--list item-->
                                <div class="list-item ">
                                    <div class="list-body">
                                        <h7 class="text-dark mb-5 font400"> <i class="fa fa-shopping-basket mr-2"></i> Pesanan : 
                                            {{-- <span class="float-right" style="font-weight: 300">Status : <span class="text-danger">{{$item->status}}</span></span>  --}}
                                            </h7>
                                        <div class="list mb-5" style="">
                                            <div class="list-item" style="padding-top: 0px">
                                                <div class="list-body text-center">
                                                    <span class="list-title text-dark mb-0"> {{$item->nama}}</span>
                                                    <span class="list-content pt-1 text-dark" style="font-size: 12px; font-weight:bold; letter-spacing: .8px"> 
                                                        <i class="fa fa-tags text-dark mr-1"></i>
                                                        {{$item->qty}} Pcs
                                                    </span>
                                                </div>
                                            </div><!--list item-->
                                        </div>
                                        @php
                                         switch ($item->status) {
                                            case 'Packaging':
                                                $color = "#5F8D4E"; $txtColor = "text-white";
                                                break;
                                            case 'Pesanan Baru':
                                                $color = "#F49D1A"; $txtColor = "text-white";
                                                break;
                                            case 'On Delivery':
                                                $color = "#7FE9DE"; $txtColor = "text-dark";
                                                break;
                                            default:
                                                $color = "grey"; $txtColor = "text-white";
                                                break;
                                         }
                                        @endphp
                                        <span class="text-left" style="font-weight: 300; margin-bottom:10px;">Status : <span class="{{$txtColor}}" style="padding: 2px 5px; background:{{$color}}; border-radius:3px; font-size:.8rem">{{$item->status}}</span></span> 
                                        <div class="pt-15 b-t text-right">
                                            <div class="row align-items-center">
                                                <div class="col-5 text-center b-r">
                                                    Harga : <span class="d-block pb-1 fs12"; style="font-weight: bold">Rp 100.000</span>
                                                </div>
                                                <div class="col-6 text-center" style="padding: 0">
                                                    <button type="button" data-status="{{$item->status}}" data-id="{{$item->id}}" data-name="Antrean <b><span class='text-danger'>{{$item->id}}</span></b>" class="float-right btn btn-dark btn-icon btn-icon-right btn-sm modalUpdate">
                                                        <i class="fa fa-arrow-right"></i>
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--list item-->
                            </div>
                        </div>
                    </div><!--portlet-->
                </div><!--col-->
            @empty
                
            @endforelse
        </div>
    </div>
    <div class="col-md-1 mt-10" style="padding: 0">
        <div class="container-fluid">
            <div class="portlet-box">
                <div class="portlet-header flex-row flex d-flex align-items-center">
                    <div class="flex d-flex flex-column">
                        <h3>Antrian Selanjutnya</h3> 
                        {{-- <span>Table example</span> --}}
                    </div>
                    <div class="portlet-tools">
                        {{-- <ul class="nav">
                            <li class="nav-item">
                                <a target="_blank" href="https://getbootstrap.com/docs/4.0/content/tables/" class="btn btn-sm btn-light"><i class="fa fa-exclamation fs10 mr-1"></i> Help</a>

                            </li>
                        </ul> --}}
                    </div>
                </div>
                <div class="portlet-body no-padding table-responsive">
                    <table class="table table-bordered table-md">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Pesanan</th>
                        <th>Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaction as $key => $item)
                            @if ($n > 41)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->nama_user}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->qty}}</td>
                                </td>
                            @else
                                @php
                                    $n++;
                                @endphp
                                @continue
                            @endif
                        @empty
                        <tr>
                            <td colspan="4">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
      </div>
    </div>
</div>