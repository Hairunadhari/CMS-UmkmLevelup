@extends('layouts.app') 
@section('title', 'Kategori Artikel') 
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@section('main') 
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:85%">Management Artikel</h1>
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
      data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Kategori</button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
    </div>
    <div class="section-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            List Kategori
        </li>        
        </ol>
      </nav>
      <div class="card">
        <div class="card-body"><strong class="text-dark">List Kategori </strong>
          <hr />
          <div class="row">
            <div class="col-12">
              <table class="table table-striped table-hovered" id="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kategori</th>
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
<form action="/submit-kategori" id="tambahsubmateri" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="tambahData" aria-labelledby="tambahData" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahDataLabel">Form Tambah Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pb-0">
            <div class="mb-3">
              <label for="title" class="form-label">Kategori <span class="text-danger text-bold">*</span></label>
              <input type="text" class="form-control" id="title" name="kategori" aria-describedby="titleHelp" required>
            </div>
          </div>
          <div class="modal-footer pt-1 justify-content-center">
            <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </form>
 
@endsection 
@push('scripts') 
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

@if (Session::has('success'))
<script>
  Swal.fire({
    title: "Notifikasi!",
    text: "{{Session::get('success')}}",
    icon: "success",
  });

</script>
@endif
  <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
  <script>
    $(document).ready(function () {
        var table = $('#table').DataTable({
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
                data: 'kategori',
              }
              ,
              {

                data: null,
                render: function (data) {
                        var deleteUrl = '/delete-kategori/' + data.encryptId;
                        var editUrl = '/edit-kategori/' + data.encryptId;
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
