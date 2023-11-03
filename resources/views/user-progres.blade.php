@extends('layouts.app')

@section('title', 'List Progres User')

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
  <link rel="stylesheet"
  href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet"
  href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">List Progres User</h1>
      </div>
      <div class="section-body">
        <h2 class="section-title">Daftar Progres User </h2> 
        <p class="section-lead">Progres User yg sudah mengikuti materi.</p>
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">List Progres User </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-hovered" id="user-progres">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Materi</th>
                      <th>Progres</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody >
                   
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
        $('#user-progres').DataTable({
            processing: true,
            ordering: false,
            searching: true,
            serverSide: true,
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
                  data: 'nama', 
                  render: function(data) {
                    return '<label class="badge badge-sm badge-dark"><i class="fa fa-tag"></i> '+ data + '</label>'
                  }
                },
                {
                  data: 'progres',
                  render: function(data) {
                    return '<label class="badge badge-sm badge-info">'+ Math.floor(data) + '%</label>'
                  }
                },
                { 
                  data: null,
                    render: function (data) {
                        var detail = '/user-progres/'+data.id+'/materi/' + data.materi_id;
                        return `
                            <span><a class="btn btn-primary" href="${detail}"><i class="far fa-eye"></i></a></span>
                        `;
                    },
                },
               
            ],
        });
    });
</script>
<!-- Page Specific JS File -->
@endpush