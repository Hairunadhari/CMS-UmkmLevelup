@extends('layouts.app')

@section('title', 'List Pesanan')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
      {{-- <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}"> --}}
    
    <link rel="stylesheet"
        href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
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
                <h1>List Product</h1>
                <div class="section-header-breadcrumb">
                    @if (auth()->user()->id_role == 3 or auth()->user()->id_role == 2 or auth()->user()->id_role == 1 )
                    <a href="{{url('add-product')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Product
                    </a>
                    @endif
                    {{-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Layout</a></div>
                    <div class="breadcrumb-item">Default Layout</div> --}}
                </div>
            </div>

            <div class="section-body">
                    <h2 class="section-title">List Product</h2>
                    <p class="section-lead">List dari product yang terdapat di gudang beserta stok dan harganya.</p>
                <div class="card">
                    <div class="card-header">
                        <h4>Product</h4>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('warning'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('info'))
                        <div class="alert alert-info alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            Please check the form below for errors
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-md" id="table">
                              <thead><tr>
                                <th>No</th>
                                {{-- <th>Gambar</th> --}}
                                <th>Nama</th>
                                <th>Tenant</th>
                                @if ((auth()->user()->id_role == 2 or auth()->user()->id_role == 1 ))
                                    <th>Admin</th>
                                @endif
                                <th>Jenis</th>
                                <th>Stock</th>
                                <th>Harga</th>
                                {{-- <th>Status</th> --}}
                                <th class="text-center">Action</th>
                              </tr></thead>
                              <tbody>
                                @php
                                    $no = 1;
                                @endphp
                              @forelse ($product as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->name}}</td>
                                    @if ((auth()->user()->id_role == 2 or auth()->user()->id_role == 1 ))
                                        <td>{{$item->nama_admin}}</td>
                                    @endif
                                    <td>{{$item->cat}}</td>
                                    <td>{{$item->stock}}</td>
                                    <td>Rp {{number_format($item->price,0,",",".")}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info addStock" style="padding: 0 5px" data-stock="{{$item->stock}}" data-id="{{$item->id}}" data-name="{{$item->nama}}"><i class="fa fa-plus"></i></button>&nbsp;
                                        <a type="button" href="{{url("/")}}/editProduct/{{$item->id}}" class="btn btn-warning" style="padding: 0 5px"><i class="fa fa-pencil"></i></a>&nbsp;
                                        {{-- <button type="button" class="btn btn-dark" style="padding: 0 5px"><i class="fa fa-search"></i></button>&nbsp; --}}
                                        <button type="button" data-href="{{url("/")}}/deleteProduct/{{$item->id}}" class="btn btn-danger hapusProduct" style="padding: 0 5px"><i class="fa fa-trash"></i></button>
                                    </td>
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

    <div class="modal fade" id="updateModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <form novalidate="" method="POST">
            
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Update Stock : &nbsp;<span class="float-right" id="nameProduct" style="font-weight: 500 !important; font-size:15px !important; line-height:24px"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 0 !important">
                    <label>Stock</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-tags"></i>
                            </div>
                        </div>
                        <input class="hide idProduct" type="hidden" name="id" value="">
                        <input type="number" class="form-control" id="stock" name="stock" min="0" required>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        $(document).on( "click", ".addStock", function() {
            let stock = $(this).attr("data-stock");
            let id = $(this).attr("data-id");
            let name = $(this).attr("data-name");
            $('#updateModalForm').find("#nameProduct").html(name)
            $('#updateModalForm').find(".idProduct").val(id)
            $('#updateModalForm').find("#stock").val(stock)
            $('#updateModalForm').modal('show'); 
        });

    $(document).on("click", "#triggerAjax", function(){
        name = $('#updateModalForm.modal.fade.show').find("#nameProduct").html()
        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
        $.ajax({
            url: "{{route('updateStock')}}",
            data: {
                id: $('#updateModalForm.modal.fade.show').find(".idProduct").val(),
                stock: $('#updateModalForm.modal.fade.show').find("#stock").val(),
            },
            type: "POST",
            dataType: "json",
            cache: false,
            success: function (res) { 
                console.log(res);
                // $("#content-dynamic").html(res.view);
                successToast(name);
                setTimeout(location.reload.bind(location), 1000);
                // $('#updateModalForm.modal.fade.show').find("#nameProduct").html('')
                // $('#updateModalForm.modal.fade.show').find(".idProduct").val('')
                // $('#updateModalForm.modal.fade.show').find(".trigForm").val(0)
                // $('#updateModalForm.modal.fade.show').find("#stock").val('');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    failToast(name);
                }
        })
    });

    function successToast(name) {
        iziToast.success({
            title: 'Berhasil diupdate!',
            message: 'stock product <b>' + name+'</b> sudah terupdate',
            position: 'topRight'
        });
    }

    function failToast(name) {
        iziToast.warning({
            title: 'gagal diupdate!',
            message: 'stock product <b>' + name+'</b> gagal terupdate',
            position: 'topRight'
        });
    }
    </script>

    <!-- JS Libraies -->
    <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-toastr.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#table").dataTable({});
        
        $(document).on('click', '.hapusProduct', function() {
            const url = $(this).attr('data-href')
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        cache: false,
                        success: function (res) { 
                            console.log(res);
                            swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Product has been deleted.',
                            'success'
                            )
                            setTimeout(location.reload.bind(location), 1500);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swalWithBootstrapButtons.fire(
                            'Cancelled by system',
                            'seems error code in this action :(',
                            'error'
                            )
                        }
                    })
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Product is safe :)',
                    'error'
                    )
                }  
            })
        })
    </script>
    <!-- Page Specific JS File -->
@endpush
