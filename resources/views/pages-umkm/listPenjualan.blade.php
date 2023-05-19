@extends('layouts.app')

@section('title', 'List Pesanan')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th {
        vertical-align: middle;
        text-align: center;
    }
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th {
        vertical-align: middle;
        text-align: center;
    }
    .dataTables_length select{
        outline-color: #6777ef
    }
    .dataTables_wrapper .dataTables_filter input{
        outline-color: #6777ef;
        outline-offset: unset;
    -webkit-appearance: auto;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        margin: 3px 3px !important;
        padding: 5px 10px !important;
        outline-color: #6777ef;
        outline-offset: unset;
        -webkit-appearance: auto;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
        background: linear-gradient(to bottom, #6777ef 0%, #6777ef 100%) !important;
        border: 1px solid #6777ef !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        background: linear-gradient(to bottom, #6777ef 0%, #6777ef 100%) !important;
        border: 1px solid #6777ef !important;
        color: white !important;
    }
    .swal2-cancel{
        margin-right: 10px;
    }
</style>
<link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet"
        href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('custom-css')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th {
        vertical-align: middle;
        text-align: center;
    }
    .dataTables_length select{
        outline-color: #6777ef
    }
    .dataTables_wrapper .dataTables_filter input{
        outline-color: #6777ef;
        outline-offset: unset;
    -webkit-appearance: auto;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        margin: 3px 3px !important;
        padding: 5px 10px !important;
        outline-color: #6777ef;
        outline-offset: unset;
        -webkit-appearance: auto;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
        background: linear-gradient(to bottom, #6777ef 0%, #6777ef 100%) !important;
        border: 1px solid #6777ef !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover{
        background: linear-gradient(to bottom, #6777ef 0%, #6777ef 100%) !important;
        border: 1px solid #6777ef !important;
        color: white !important;
    }
    .swal2-cancel{
        margin-right: 10px;
    }
</style>
@endsection

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>List Penjualan</h1>
            </div>

            <div class="section-body">
                    <h2 class="section-title">List Penjualan dari
                        <input class="" id="date" type="date" value="{{$date}}"> -
                        <input class="" id="date_second" type="date" value="{{$date_second}}">
                        <button type="button" onclick="filterData()" class="btn btn-outline-dark btn-sm"><i class="fa fa-filter"></i> Filter</button>
                    </h2>
                    <p class="section-lead">History log penjualan dari tenant.</p>
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h4 class="float-left">Penjualan</h4>
                        <span class="float-right" id="tableActions"><button class="btn btn-success" type="button" onclick="exportData()"><i class="fa fa-file-excel"></i> Export Excel</button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md" id="table">
                                <thead>
                                    <tr>
                                    <th>Product</th>
                                    <th>Tenant</th>
                                    <th>Tgl</th>
                                    <th>Penjualan</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                            <tbody>
                              @forelse ($listPenjualan as $item)
                                <tr>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->nama_tenant}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->created_at)->locale('id')->format('j F Y')}}</td>
                                    <td>{{$item->value}}</td>
                                    <td>Rp {{number_format($item->total_harga,0,",",".")}}</td>
                                </tr>
                                  
                              @empty
                              <tr>
                                <td colspan="8">No Data</td>
                              </tr>
                              @endforelse
                            </tbody></table>
                          </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        function filterData() {
            let value = $(document).find('#date').val();
            let value_second = $(document).find('#date_second').val();
            window.location.href = "{{url('/')}}/showPenjualan?date=" + value + "&date_second=" + value_second;
        }

        function exportData() {
            let value = $(document).find('#date').val();
            let value_second = $(document).find('#date_second').val();
            const url = "{{url('/')}}/exportPenjualan?date=" + value + "&date_second=" + value_second;
            window.open(url, '_blank');
        }
    </script>
@endpush
