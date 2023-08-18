@extends('layouts.app')

@section('title', 'Dashboard Gudang')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    
    <link rel="stylesheet"
        href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
@endpush

@section('custom-css')
    <style>
        .bg-light{
            background: #f3f8fa !important;
        }
        .main-content, .navbar-bg{
            width: 5500px;
        }
        body.sidebar-mini .navbar{
            width: 5400px;
        }
        .close{
            right: 15px !important;
            top: 10px !important;
        }
    </style>
@endsection

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header" style="padding: 10px 20px; margin-bottom:15px;">
                <h4 style="margin-bottom: 0">Dashboard Gudang <label class="bg-warning text-white" style="padding: 0px 5px; border-radius:3px">{{$jmlh}}</label></h4>
            </div>

            <div class="section-body" id="content-dynamic">
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
            </div>
        </section>
    </div>

    

    <div class="modal fade" id="updateModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <form novalidate="" method="POST">
            
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Update Status : &nbsp;<span class="float-right" id="nameAntrian" style="font-weight: 500 !important; font-size:15px !important; line-height:24px"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 0 !important">
                    <label>Status</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                        <input class="hide idTrans" type="hidden" name="id" value="">
                        <input class="hide trigForm" type="hidden" name="trigform" value="0">
                        <select class="form-control" id="statusTransaction" name="statusVal" required>
                            <option value="">-- Pilih --</option>
                            <option value="Pesanan Baru">Pesanan Baru</option>
                            <option value="Packaging">Packaging</option>
                            <option value="On Delivery">On Delivery</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center">
              <button type="button" id="triggerAjax" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>

    <!-- JS Libraies -->
    <script>
    var pusher = new Pusher('c4939fa94ecbabee8d70', {
        cluster: 'ap1',
        encrypted: true
      });

      // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('notification-send');
    channel.bind('App\\Events\\NotificationEvent', function(data) {
        console.log(data.transaction);
        let trigger = $(".trigForm").val();
        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
        if (trigger == 1) {
            name = $('#updateModalForm.modal.fade.show').find("#nameAntrian").html()
            $.ajax({
                type: "POST",
                url: "{{route('updateStatusData')}}",
                data: {
                id: $('#updateModalForm.modal.fade.show').find(".idTrans").val(),
                statusVal: $('#updateModalForm.modal.fade.show').find("#statusTransaction").val(),
                },
                dataType: "json",
                cache: false,
                // encode: true,
                success: function (res) { 
                    console.log(res);
                    $("#content-dynamic").html(res.view);
                    successToast(name);
                   $('#updateModalForm.modal.fade.show').find("#nameAntrian").html('')
                   $('#updateModalForm.modal.fade.show').find(".idTrans").val('')
                   $('#updateModalForm.modal.fade.show').find(".trigForm").val(0)
                   $('#updateModalForm.modal.fade.show').find("select").val('').trigger('change');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    failToast(name);
                }
            });
            $('#updateModalForm').modal('hide');
        } else{
            $.ajax({
                type: "POST",
                url: "{{route('getDashboardGudang')}}",
                data: {},
                dataType: "json",
                cache: false,
                success: function (res) { 
                    orderNewToast(name);
                    $("#content-dynamic").html(res.view);
                    $(".main-content").find('.section-header').find('label').html(res.jmlh);
                    playAudio();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }
    });

    $(document).on("click", "#triggerAjax", function(){
        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
        $(".trigForm").val(1);
        $.ajax({
            url: "{{route('updateStatus')}}",
            type: "post",
            dataType: "json",
        }).done(function(){
            console.log('success');
        })
    });

    function successToast(name) {
        iziToast.success({
            title: 'Berhasil diupdate!',
            message: 'status <b>' + name+'</b> sudah terupdate',
            position: 'topRight'
        });
    }

    function orderNewToast(name) {
        iziToast.success({
            title: 'Pesanan Masuk!',
            message: 'terdapat pesanan baru',
            position: 'topRight'
        });
    }

    function failToast(name) {
        iziToast.warning({
            title: 'gagal diupdate!',
            message: 'status <b>' + name+'</b> gagal terupdate',
            position: 'topRight'
        });
    }
    
    function playAudio() {
        var x = new Audio('{{asset("sound/notification.mp3")}}');
        // Show loading animation.
        var playPromise = x.play();

        if (playPromise !== undefined) {
            playPromise.then(_ => {
                    x.play();
                })
                .catch(error => {
                });

        }
    }

    $(document).on( "click", ".modalUpdate", function() {
        let status = $(this).attr("data-status");
        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");
        $('#updateModalForm').find("#nameAntrian").html(name)
        $('#updateModalForm').find(".idTrans").val(id)
        $('#updateModalForm').find("select").val(status).trigger('change');
        $('#updateModalForm').modal('show'); 
    });

    $("#changeStatus").fireModal({
        title: 'Login',
        body: $("#modal-login-part"),
        footerClass: 'bg-whitesmoke',
        autoFocus: false,
        onFormSubmit: function(modal, e, form) {
            // Form Data
            let form_data = $(e.target).serialize();
            console.log(form_data)

            // DO AJAX HERE
            let fake_ajax = setTimeout(function() {
            form.stopProgress();
            modal.find('.modal-body').prepend('<div class="alert alert-info">Please check your browser console</div>')

            clearInterval(fake_ajax);
            }, 1500);

            e.preventDefault();
        },
        shown: function(modal, form) {
            console.log(form)
        },
        buttons: [
            {
            text: 'Update',
            submit: true,
            class: 'btn btn-primary btn-shadow',
            handler: function(modal) {

            }
            }
        ]
    });

    </script>
    <!-- JS Libraies -->
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-toastr.js') }}"></script>
    <!-- Page Specific JS File -->
@endpush
