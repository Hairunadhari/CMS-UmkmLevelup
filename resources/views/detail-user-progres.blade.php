@extends('layouts.app')

@section('title', 'List Kategori Materi')

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
        <h1 style="width:87%">Detail Progres User</h1>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">Detail Progres '{{$user->name}}' | Materi '{{$materi->nama}}'</strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-hovered" id="d-progres">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Sub Materi</th>
                      <th>Nama</th>
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
        $('#d-progres').DataTable({
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
                  data: 'progres',
                  render: function (data) {
                    return data + '%';
                  }
                },
            ],
        });
    });
</script>
<!-- Page Specific JS File -->
@endpush