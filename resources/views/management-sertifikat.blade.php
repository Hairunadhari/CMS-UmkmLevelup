@extends('layouts.app')

@section('title', 'Management Sertifikat')

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
      <h1 style="width:50%">Management Sertifikat</h1>
      <form action="/import-excel" method="post" enctype="multipart/form-data" class="d-flex">
        @csrf
        <input class="form-control" type="file" name="file" style="margin-right: 10px" accept=".xlsx, .xls" required>
        <button type="submit" class="btn btn-sm btn-success " style="width: 150px;"><i class="fa fa-download"></i>
          Import
          Excel</button>
      </form>
      <button id="generatezip" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center"
        style="width: 150px; margin-left: 10px; height: 42px;" class="mb-0"><i class="fas fa-file-archive"></i> Download
        ZIP</button>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">
          <strong class="text-dark">List Management Sertifikat </strong>
      <p>'Maksimal Download 20 data'</p>

          <hr />
          <div class="row">
            <div class="col-12">
                <table class="table table-striped table-hovered" id="m">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>No</th>
                      <th>Nama Fasilitator</th>
                      <th>Nama Usaha</th>
                      <th>Nama Pemilik</th>
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
      ajax: '{{ url()->current() }}',
      columns: [{
          data: 'id',
          render: function (data) {
            return `<input type="checkbox" class="user_checkbox" value="${data}">`
          }
        },
        {
          render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          },
        },
        {
          data: 'nama_fasilitator'
        },
        {
          data: 'nama_usaha',
        },
        {
          data: 'nama_pemilik',
        },
        {
          data: null,
          render: function (data,row) {
            if (data.status_pdf == 1) {
              var a =
                `<span><a class="btn btn-danger" href="/regenerate-pdf/${data.id}"><i class="fas fa-file-pdf"></i></a></span>`
            } else {
              var a = `<span><a class="btn btn-primary" target="_blank" href="/pdf/${data.nama_pemilik}-${data.id}.pdf"><i class="far fa-eye"></i></a></span>`
            }
            return a;
          },
        },

      ],
    });
    $(document).on('click','#generatezip',function(){
      var id = [];
      if(confirm("apakah anda ingin mendownload zip?"))
      {
        $('.user_checkbox:checked').each(function(){
          id.push($(this).val());
        });
        if (id.length > 0 && id.length < 21 ) {
          $.ajax({
            url:"/all-generate-pdf",
            method:"post",
            data:{id:id},
            success:function (data) {
              // console.log(data);
              window.location.href = data;
  table.draw(); 
              // $('.user_checkbox:checked').prop('checked', false);
            },
            error:function (data) {
              console.log(data);
            }
          });
        }else{
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Maksimal data yang dipilih 20 data",
          });
        }
      }
    });
  });


</script>
<!-- Page Specific JS File -->
@endpush
