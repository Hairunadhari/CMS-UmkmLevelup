@extends('layouts.app')

@section('title', 'List Kategori Materi')

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
        <h1 style="width:87%">List Kategori Materi</h1>
        <div class="float-right">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Daftar Kategori Materi </h2> 
        <p class="section-lead">Kategori Materi yang ditampilkan untuk semua UMKM yang terdaftar di sistem.</p>
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">List Kategori Materi </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-hovered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>Jmlh Sub</th>
                      <th>Status</th>
                      <th>Tgl</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($materi as $key => $item)
                      <tr>
                        <td class="text-center">{{$key + 1}}</td>
                        <td class="text-center">{{$item->nama}}</td>
                        <td class="text-center">{{'-'}}</td>
                        @if ($item->aktif == 2)
                          <td class="text-center">{!! '<span class="badge badge-dark"><i class="fa fa-check"></i> Waiting Verification</span>' !!}</td>
                        @else
                          <td class="text-center">{!! '<span class="badge badge-success"><i class="fa fa-check"></i> Publish</span>' !!}</td>
                        @endif
                        <td class="text-center">{{\Carbon\Carbon::parse($item->created_at)->locale('id')->format('j F Y')}}</td>
                        <td class="text-center">
                          <a href="{{url('sub-materi/'.$item->id.'/'.$item->nama)}}" class="btn btn-sm btn-danger"><i class="fa fa-th-list"></i> Sub Materi</a>
                          {!! ($item->aktif == 2) ? '<a href="'.url("approve-materi").'/'.$item->id.'" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Publish</a>' : ''!!}
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text-center" colspan="6">No Data</td>
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

  <form action="{{url('add-materi')}}" method="POST">
    <div class="modal fade" id="tambahData"  aria-labelledby="tambahData" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahDataLabel">Tambah Materi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pb-0">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Judul Materi <span class="text-danger text-bold">*</span></label>
                        <input type="nama" class="form-control" id="nama" name="nama" aria-describedby="namaHelp" required>
                        <div id="namaHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                      <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
                      <textarea class="form-control" rows="5" id="deskripsi" name="deskripsi" aria-describedby="deskripsiHelp" style="height: 100px" required></textarea>
                      <div id="deskripsiHelp" class="form-text"></div>
                    </div>
                    {{-- <div class="mb-3">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
                          <textarea class="form-control" id="deskripsi" name="deskripsi" aria-describedby="deskripsiHelp" required></textarea>
                          <div id="deskripsiHelp" class="form-text"></div>
                        </div>
                        <div class="col-md-6">
                          <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
                          <textarea class="form-control" id="deskripsi" name="deskripsi" aria-describedby="deskripsiHelp" required></textarea>
                          <div id="deskripsiHelp" class="form-text"></div>
                        </div>
                      </div>
                    </div> --}}
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