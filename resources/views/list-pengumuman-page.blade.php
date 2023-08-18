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
          {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button> --}}
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Daftar Pengumuman </h2> 
        <p class="section-lead">Fitur Pengumuman untuk memberitahukan sebuah event atau sesuatu kepada pelaku UMKM yang terdaftar di dalam sistem.</p>
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