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
        <h1 style="width:87%">List Pengumuman</h1>
        <div class="float-right">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button>
        </div>
      </div>
      <div class="section-body">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              List Pengumuman
          </li>        
          </ol>
        </nav>
        <p class="section-leadx">Fitur Pengumuman untuk memberitahukan sebuah event atau sesuatu kepada pelaku UMKM yang terdaftar di dalam sistem.</p>
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">List Pengumuman </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-hovered" id="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>Keterangan</th>
                      <th>Tanggal</th>
                      <th>Status?</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($pengumuman as $item)
                        <tr>
                            <td class="text-center">{{$item->id}}</td>
                            <td>{{$item->judul_notifikasi}}</td>
                            <td style="width: 40%">{{$item->keterangan}}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->format('j F Y')}}</td>
                            <td class="text-center">{!! $item->status_aktif == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i></span>" : "<span class='badge badge-dark'><i class='fa fa-times'></i></span>" !!}</td>
                            <td class="text-center">
                              @if ($item->status_aktif == 1)
                                  
                              <form action="/hapus-pengumuman/{{$item->id}}" method="post">
                              <a href="/edit-pengumuman/{{$item->id}}" class="btn btn-sm btn-warning"><i
                              class="fa fa-th-list"></i>
                            Edit</a>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <button class="btn btn-sm btn-danger" type="submit"><i class="far fa-trash-alt"></i> Hapus</button>
                              </form>
                              @endif
                          </td>
                          </tr>
                    @empty
                        <tr>
                        <td class="text-center" colspan="4">No Data</td>
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
  <form action="{{url('add-pengumuman')}}" method="POST">
    <div class="modal fade" id="tambahData"  aria-labelledby="tambahData" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahDataLabel">Tambah Pengumuman</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pb-0">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Judul Pengumuman <span class="text-danger text-bold">*</span></label>
                        <input type="nama" class="form-control" id="nama" name="judul_notifikasi" aria-describedby="namaHelp" required>
                        <div id="namaHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                      <label for="deskripsi" class="form-label">Keterangan <span class="text-danger text-bold">*</span></label>
                      <textarea class="form-control" rows="5" id="deskripsi" name="keterangan" aria-describedby="deskripsiHelp" style="height: 100px" required></textarea>
                    </div>
                    <hr />
                </div>
                <div class="modal-footer pt-1 justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
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