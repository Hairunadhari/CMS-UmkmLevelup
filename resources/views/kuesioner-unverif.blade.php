@extends('layouts.app')

@section('title', 'Kuesioner unverif')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th, .table th {
        vertical-align: middle !important;
        text-align: center;
    }
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
        <h1 style="width:87%">Kuesioner - Unverified</h1>
        <div class="float-right">
          <a target="_blank" class="btn btn-sm btn-success" href="export-data-unverif"><i class="fa fa-download"></i> Export Excel</a>
        </div>
      </div>

      <div class="section-body">
        {{-- <div class="card">
          <div class="card-header">
            <h4>Default</h4>
          </div>
          <div class="card-body">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
              </ol>
            </nav>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
              </ol>
            </nav>
          </div>
        </div> --}}

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item {{ request()->routeIs('/kuesioner-unverif') ? 'active' : '' }}">
              @if(request()->routeIs('/kuesioner-unverif'))
                  List Kuesioner - Unverified
              @else
                  <a href="#">List Kuesioner - Unverified</a>
              @endif
          </li>
          
            {{-- <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item " aria-current="page">Data</li> --}}
          </ol>
        </nav>
        {{-- <h2 class="section-title">List Kuesioner - Unverified</h2> --}}
        <p class="section-leadx">List daftar responden yang sudah mengisi kuesioner dengan status unverif.</p>
        <div class="card">
            {{-- <div class="card-header"> --}}
                {{-- <h4>Set Level</h4> --}}
            {{-- </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm" id="table">
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">#</th>
                          <th class="text-center" scope="col">Nama Bisnis</th>
                          <th class="text-center" scope="col">Nama</th>
                          {{-- <th class="text-center" scope="col">Form</th> --}}
                          <th class="text-center" scope="col">Submit?</th>
                          <th class="text-center" scope="col">Use?</th>
                          {{-- <th class="text-center" scope="col">Id Lvl</th> --}}
                          <th class="text-center" scope="col">Level</th>
                          <th class="text-center" scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($data as $key => $value)
                          <tr>
                            <td>{{$value->id_submit}}</td>
                            <td>{{$value->nama_usaha}}</td>
                            <td>{{$value->name}}</td>
                            {{-- <td>{{$value->title}}</td> --}}
                            <td>{!! $value->savedSession == 1 ? '<span class="badge badge-warning badge-sm"><i class="fa fa-times"></i></span>' : '<span class="badge badge-success badge-sm"><i class="fa fa-check"></i></span>' !!}</td>
                            <td>{!! $value->import == 0 ? '<span class="badge badge-dark"><i class="fa fa-desktop"></i> App</span>' : '<span class="badge badge-danger badge-sm"><i class="fa-brands fa-google-plus-g"></i> form</span>' !!}</td>
                            {{-- <td>{{$value->id_level}}</td> --}}
                            <td>{{$value->level}}</td>
                            <td>{!! $value->savedSession == 0 ? '<a type="button" target="_blank" href="verif-page/'.$value->id.'/'.urlencode(base64_encode($value->level)).'" class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Verif</a>' : '' !!} </td>
                          </tr>
                        @empty
                          <tr>
                              <td colspan="7">Tidak Ada Data</td>
                          </tr>
                        @endforelse
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
              <input type="hidden" class="form-control hidden" id="id_user" name="id_user" value="" aria-describedby="id_userHelp" required>
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

  $("#table").dataTable({
    stateSave: true,
  });

    $( document ).on( "click", ".doVerif", function() {
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

    $(document).ready(function() {
      $('.select2').select2();
    });
</script>

<!-- Page Specific JS File -->
@endpush