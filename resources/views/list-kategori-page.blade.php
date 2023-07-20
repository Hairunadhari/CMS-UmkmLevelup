@extends('layouts.app')

@section('title', 'List Kategori')

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
        <h1 style="width:87%">List Kategori</h1>
        <div class="float-right">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Daftar Kategori </h2> 
        <p class="section-lead">Daftar Kategori dibutuhkan sebelum membuat materi.</p>
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">List Kategori </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-bordered" id="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Tanggal Buat</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($kategori as $key => $item)
                        <tr>
                          <td class="text-center">{{$key + 1}}</td>
                          <td class="text-center">{{$item->nama}}</td>
                          <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->format('j F Y')}}</td>
                        </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="3">No Data</td>
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
  
  <form action="{{url('add-kategori')}}" method="POST">
    <div class="modal fade" id="tambahData"  aria-labelledby="tambahData" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahDataLabel">Tambah Data Kategori</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pb-0">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger text-bold">*</span></label>
                        <input type="nama" class="form-control" id="nama" name="nama" aria-describedby="namaHelp" required>
                        <div id="namaHelp" class="form-text"></div>
                    </div>
                    <hr />
                </div>
                <div class="modal-footer pt-1 justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
                </div>
            </div>
        </div>
    </div>
  </form>
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
</script>
<!-- Page Specific JS File -->
@endpush