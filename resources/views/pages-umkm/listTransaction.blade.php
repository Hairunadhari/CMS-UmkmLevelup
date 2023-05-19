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
</style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>List Transaction</h1>
                {{-- <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Layout</a></div>
                    <div class="breadcrumb-item">Default Layout</div>
                </div> --}}
            </div>

            <div class="section-body">
                    <h2 class="section-title">List Transaction</h2>
                    <p class="section-lead">History log pemesanan dari tenant ke gudang beserta statusnya.</p>
                <div class="card">
                    <div class="card-header">
                        <h4>Transaction</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                              <tbody><tr>
                                <th>No Trans.</th>
                                <th>Tenant</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                              </tr>
                              @forelse ($transaction as $item)
                                <tr>
                                    <td>{{$item->no_transaction}}</td>
                                    <td>{{$item->nama_user}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>Rp {{number_format($item->total_price,0,",",".")}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        @if ($item->status == "Selesai")
                                            <div class="badge badge-success">{{$item->status}}</div>
                                        @else
                                            <div class="badge badge-warning">{{$item->status}}</div>
                                        @endif
                                    </td>
                                    <td><a href="#" class="btn btn-dark">Detail</a></td>
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
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
