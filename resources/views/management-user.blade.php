@extends('layouts.app')

@section('title', 'List User')

@push('style')
{{-- <style>
      #data-table tbody tr td {
          vertical-align: middle;
      }
      #data-table thead tr th, .table th {
          vertical-align: middle !important;
          text-align: center;
      }
  </style> --}}
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:50%">List User</h1>
    
    </div>
    <div class="section-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
             List User
        </li>        
        </ol>
      </nav>
      <div class="card">
        <div class="card-body">
            <strong class="text-dark">List User </strong>
          <hr />
          <div class="row">
            <div class="col-12">
              <table class="table table-striped table-hovered" id="m">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>No Wa</th>
                    <th>Created at</th>
                    <th>Email Verified at</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  </section>
</div>

<script type="text/javascript">


</script>
@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
" rel="stylesheet">

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
  $("#table").dataTable({});
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
          },
        },
        {
          data: 'name'
        },
        {
          data: 'email',
        },
        {
          data: 'no_wa',
        },
        {
          data: 'created_at',
          render: function (data) {
            if (data == null) {
              a = `<span>-</span>`
            } else {
              a = `<span>${data}</span>`
              
            }
            return a;
          }
        },
        {
          data: 'email_verified_at',
          render: function (data) {
            if (data == null) {
              a = `<span>-</span>`
            } else {
              a = `<span>${data}</span>`
              
            }
            return a;
          }
        },
        {
          data: 'encryptId',
          render: function (data) {
              return `<form action="/verified-email/${data}" method="POST" onsubmit="return confirm('Apakah anda yakin akan Memverifikasi Email data ini?');">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <a href="/password/${data}" class="btn btn-sm btn-primary">Update Password</a>
                      <button class="btn btn-sm btn-dark" type="submit">Verif Email</button>
              </form>
          `;
          },
      },

      ],
    });
    

  
  });

</script>
<!-- Page Specific JS File -->

@if (Session::has('alert'))
<script>
  Swal.fire({
    title: "{{Session::get('alert')['title']}}",
    text: "{{Session::get('alert')['text']}}",
    icon: "{{Session::get('alert')['icon']}}",
  });

</script>
@endif

@endpush
