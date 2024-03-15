@extends('layouts.app')

@section('title', 'Kuesioner unverif')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:87%">Kuesioner - Unverified</h1>
      <div class="float-right">
        {{-- <a target="_blank" class="btn btn-sm btn-success" href="export-data-unverif"><i class="fa fa-download"></i>
          Export Excel</a> --}}
          <form action="/export-data-unverif" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id_kabupaten" name="id_kab">
            <input type="hidden" id="id_kecamatan" name="id_kec">
            <input type="hidden" id="id_kelurahan" name="id_kel">
              <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-download"></i> Export
                Excel</button>
            </form>
      </div>
    </div>

    <div class="section-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item {{ request()->routeIs('/kuesioner-unverif') ? 'active' : '' }}">
            @if(request()->routeIs('/kuesioner-unverif'))
            List Kuesioner - Unverified
            @else
            <a href="#">List Kuesioner - Unverified</a>
            @endif
          </li>

        </ol>
      </nav>
      <p class="section-leadx">List daftar responden yang sudah mengisi kuesioner dengan status unverif.</p>
      <div class="card">
        <div class="card-header">
          <div class="d-flex mt-3">
            <div class="form-group">
              <select class="form-control select2" id="kabupatens">
                <option selected disabled>-- Pilih Kabupaten --</option>
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
          </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="table-z">
                <thead>
                  <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">Nama Bisnis</th>
                    <th class="text-center" scope="col">Nama</th>
                    <th class="text-center" scope="col">Submit?</th>
                    <th class="text-center" scope="col">Use?</th>
                    <th class="text-center" scope="col">Wilayah</th>
                    <th class="text-center" scope="col">Level</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table-unverif">
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>

<!-- Modal -->
<form action="{{route('/submit-verif')}}" method="POST">
  @csrf
  <div class="modal fade" id="modalVerif" data-keyboard="false" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahDataLabel">Verifikasi User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <input type="hidden" class="form-control hidden" id="id_user" name="id_user" value=""
              aria-describedby="id_userHelp" required>
          </div>
          <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-control select2" name="level" id="level" required>
              <option value="">-- Pilih --</option>
              <option value="1">Beginner</option>
              <option value="2">Observer</option>
              <option value="3">Adopter</option>
              <option value="4">Leader</option>
            </select>
            <div id="levelHelp" class="form-text"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
  

  $(document).on("click", ".doVerif", function () {
    // alert('test');
    let name = $(this).attr('data-name');
    let id = $(this).attr('data-id');
    $('#modalVerif').find('.modal-title').html('Verifikasi User "' + name + '"');
    $('#modalVerif').find('#id_user').val(id);
    $('#modalVerif').modal('show');

  });

  function filterData() {
    let value = $(document).find('#date').val();
    let value_second = $(document).find('#date_second').val();
    window.location.href = "{{url('/')}}/showPenjualan?date=" + value + "&date_second=" + value_second;
  }

  function exportData() {
    let value = $(document).find('#date').val();
    let value_second = $(document).find('#date_second').val();
    const url = "{{url('/')}}/exportPenjualan?date=" + value + "&date_second=" + value_second;
    window.open(url, '_blank');
  }

  $(document).ready(function () {
    $('.select2').select2();

    var table = $('#table-z').DataTable({
        processing: true,
        ordering: false,
        searching: true,
        serverSide: true,
        stateSave: true,
        ajax: {
                url: '{{ url()->current() }}',
                data: function (data) {
                    data.id_kab = $('#id_kabupaten').val(),
                    data.id_kec = $('#id_kecamatan').val(),
                    data.id_kel = $('#id_kelurahan').val()
                }
            },
        columns: [
            {
              data: 'id_submit'
            },
            {
              data: 'nama_usaha', 
            },
            {
              data: 'name', 
            },
            {
              data: 'savedSession', 
              render: function(data) {
                if (data == 1) {
                  var use = `<span class="badge badge-warning badge-sm"><i
                          class="fa fa-times"></i></span>`
                } else {
                  var use = `<span class="badge badge-success badge-sm"><i
                          class="fa fa-check"></i></span>`
                }
                return use;
              }
            },
            {
              data: 'import', 
              render: function(data) {
                if (data == 0) {
                  var use = `<span class="badge badge-dark"><i class="fa fa-desktop"></i>
                        App</span>`
                } else {
                  var use = `<span class="badge badge-danger badge-sm"><i
                          class="fa-brands fa-google-plus-g"></i> form</span>`
                }
                return use;
              }
            },
            {
              data: null,
              render: function (data,row) {
                return `<span>${data.nama_kabupaten}</span>, <br><span>${data.nama_kecamatan}</span>, <br ><span>${data.nama_kelurahan}</span>`;
              }
            },
            {
              data: 'level', 
            },
            {
              data: 'savedSession', 
              render: function(data) {
                if (data == 0) {
                  var use = `<a type="button" target="_blank"
                        href="verif-page/${data.id}/${encodeURIComponent(btoa(data.level))}"
                        class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Verif</a>`
                } else {
                  var use = ``
                }
                return use;
              }
            },



           
        ],
    });
    $('#kabupatens').on('change', function () {
        var kabupatens_id = this.value;
        console.log('idkab',kabupatens_id);

        $('#kecamatans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
        $('#kelurahans').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');
        $('#table-unverif').html('');
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
          url: "/get-kecamatan/" + kecamatans_id+'/'+id_kab,
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
  });


</script>

<!-- Page Specific JS File -->
@endpush
