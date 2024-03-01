@extends('layouts.app')

@section('title', 'List Materi Chatting')

@push('style')
  <style>
      /* #data-table tbody tr td {
          vertical-align: middle;
      }
      #data-table thead tr th, .table th {
          vertical-align: middle !important;
          text-align: center;
      } */
  </style>
  <link rel="stylesheet"
  href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet"
  href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">Materi Chatting</h1>
      </div>
      <div class="section-body">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              List Materi Chatting
          </li>        
          </ol>
        </nav>
        <p class="section-leadx">Isi Chat dari setiap user yang mengikuti materi.</p>
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">List Materi </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-hovered" id="tb">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Materi</th>
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
    $(document).ready(function () {
        $('#tb').DataTable({
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
                  data: 'nama'
                },
                { 
                  data: null,
                    render: function (data) {
                        var detail = '/materi-chatting/'+data.id+'/materi/' + data.nama;
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