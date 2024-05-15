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
      <h1 style="width:87%">List User</h1>
      <div class="float-right">
        {{-- <a target="_blank" class="btn btn-sm btn-success" href="export-data-unverif"><i class="fa fa-download"></i>
          Export Excel</a> --}}
        <form action="/export-user" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="id_kabupaten" name="id_kab">
          <input type="hidden" id="id_kecamatan" name="id_kec">
          <input type="hidden" id="id_kelurahan" name="id_kel">
          <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Export
            Excel</button>
        </form>
      </div>
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
        <div class="card-header">
          <div class="d-flex mt-3">
            <div class="form-group">
              <select class="form-control select2" id="kabupatens">
                <option selected disabled value="">-- Pilih Kabupaten --</option>
                @foreach ($kabupaten as $kab)
                <option value="{{$kab->id_kabupaten}}">{{$kab->nama_kabupaten}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group ml-2 mr-2">
              <select class="form-control select2" id="kecamatans">
                <option selected disabled>-- Pilih Kecamatan --</option>
              </select>
            </div>
            <div class="form-group">
              <select class="form-control select2" id="kelurahans">
                <option selected disabled>-- Pilih Kelurahan --</option>
              </select>
            </div>
            <div class="form-group">
              <div class="btn btn-danger mt-1 " id="reset-filter" style="margin-left: 1rem;">Reset Filter</div>
            </div>
          </div>
        </div>
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
                    <th>Wilayah</th>
                    <th>Created</th>
                    <th>Email Verif</th>
                    {{-- <th>Isi Kuesioner</th> --}}
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="tUser">
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
      ordering: true,
      searching: true,
      serverSide: true,
      stateSave: true,
      responsive: true,
      ajax: {
        url: '{{ url()->current() }}',
        data: function (data) {
          data.id_kab = $('#id_kabupaten').val(),
            data.id_kec = $('#id_kecamatan').val(),
            data.id_kel = $('#id_kelurahan').val()
        }
      },
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
          data: null,
          render: function (data, row) {
            if (data.nama_kabupaten == null && data.nama_kecamatan == null && data.nama_kelurahan == null) {
              a = `<span>-</span>`
            } else {
              a= `<span>${data.nama_kabupaten}</span>, <br><span>${data.nama_kecamatan}</span>, <br ><span>${data.nama_kelurahan}</span>`
            }
            return a;
          }
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
        // {
        //   data: 'final_level',
        //   render: function (data) {
        //     if (data == null || data == 0) {
        //       a = `<span class="badge badge-danger">belum</span>`
        //     } else {
        //       a = `<span class="badge badge-success">sudah</span>`
        //     }
        //     return a;
        //   }
        // },
        {
          data: null,
          render: function (data) {
            if (data.email_verified_at == null) {
              a= `<form action="/verified-email/${data.encryptId}" method="POST" onsubmit="return confirm('Apakah anda yakin akan Memverifikasi Email data ini?');">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <a href="/password/${data.encryptId}" class="btn btn-sm btn-primary">Update Password</a>
                      <button class="btn btn-sm btn-dark" type="submit">Verif Email</button>
              </form>`
            }else{
              a= `<form action="/verified-email/${data.encryptId}" method="POST" onsubmit="return confirm('Apakah anda yakin akan Memverifikasi Email data ini?');">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <a href="/password/${data.encryptId}" class="btn btn-sm btn-primary">Update Password</a>
              </form>`

            }
              return a;
          },
      },

      ],
    });
    
    $('#kabupatens').on('change', function () {
      var kabupatens_id = this.value;
      console.log('idkab', kabupatens_id);

      $('#kecamatans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
      $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
      $('#tUser').html('');
      $('#id_kabupaten').val(kabupatens_id);
      $('#id_kecamatan').val('');
      $('#id_kelurahan').val('');


      $.ajax({
        url: "/get-kabupaten/" + kabupatens_id,
        method: 'get',

        success: function (res) {
          // console.log(res);
          $.each(res.kecamatan, function (key, value) {
            $('#kecamatans').append('<option value="' + value.id_kecamatan + '">' + value
              .nama_kecamatan + '</option>');

          });
          table.draw();

        }
      });
    });

    // filter kecamatan
    $('#kecamatans').on('change', function () {
      var kecamatans_id = this.value;

      // ambil value dropdown kabupaten
      id_kab = $('#kabupatens').val();
      $('#id_kecamatan').val(kecamatans_id);
      $('#id_kelurahan').val('');
      $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kelurahan --</option>');

      $.ajax({
        url: "/get-kecamatan/" + kecamatans_id + '/' + id_kab,
        method: 'get',

        success: function (res) {
          console.log(res);
          $.each(res.kelurahan, function (key, value) {
            $('#kelurahans').append('<option value="' + value.id_kelurahan + '">' + value
              .nama_kelurahan + '</option>');
          });
          table.draw();
        }
      });
    });

    // filter kelurahan
    $('#kelurahans').on('change', function () {
      var kelurahans_id = this.value;
      $('#id_kelurahan').val(kelurahans_id);
      table.draw();
    });

    $('#reset-filter').on('click', function () {
      $('#kabupatens').val('').trigger('change'); // Mengatur pilihan kembali ke yang pertama
      $('#kecamatans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
      $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kelurahan --</option>');
      $('#id_kabupaten').val('');
      $('#id_kecamatan').val('');
      $('#id_kelurahan').val('');
      table.draw();
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
