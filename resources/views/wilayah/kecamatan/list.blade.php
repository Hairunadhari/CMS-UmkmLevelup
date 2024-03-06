@extends('layouts.app') 
@section('title', 'List Kecamatan') 
@push('style') 
    
        <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    
@endpush
    @section('main') 
    <div class="main-content">
      <section class="section">
        <div class="section-header">
          <h1 style="width:85%">Management Kecamatan</h1><a class="btn btn-success" href="/form-input-kecamatan"><span
              class="text">+Tambah Kecamatan</span></a>
        </div>
        <div class="section-body">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                List Kecamatan
            </li>        
            </ol>
          </nav>
          <div class="card">
            <div class="card-body"><strong class="text-dark">List Kecamatan</strong>
              <hr />
              <div class="row">
                <div class="col-12">
                  <table class="table table-striped table-hovered" id="m">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Kecamatan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>
    <script type="text/javascript"></script>
    @endsection 
    @push('scripts') 
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="
    https: //cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https: //cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
    " rel="stylesheet">
    
    
      <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
      <script>
        $("#table").dataTable({}
    
        );
    
        $(document).ready(function () {
            var table = $('#m').DataTable({
    
                processing: true,
                ordering: false,
                searching: true,
                serverSide: true,
                stateSave: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                      }
    
                      ,
                  }
    
                  ,
                  {
                    data: 'nama_kecamatan',
                  }
    
                  ,
                  {
    
                    data: null,
                    render: function (data) {
                            var deleteUrl = '/delete-kecamatan/' + data.id_kecamatan;
                            var editUrl = '/form-edit-kecamatan/' + data.id_kecamatan;
                            return `
                            <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Apakah anda yakin akan menghapus data ini ?');">
                            <span><a class="btn btn-primary" href="${editUrl}"><i class="far fa-edit"></i></a></span>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <button class="btn btn-danger" type="submit"><i class="far fa-trash-alt"></i></button>
                            </form>
                        `;
                        },
                  }
    
                  ,
    
                ],
              }
    
            );
          }
    
        );
    
      </script>
@endpush
    