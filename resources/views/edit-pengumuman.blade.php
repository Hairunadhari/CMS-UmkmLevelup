@extends('layouts.app')

@section('title', 'Edit Sub Materi')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:87%">Edit Pengumuman</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4 style="color: black">Edit Pengumuman '{{$pengumumanById->judul_notifikasi}}'</h4>
        </div>
        <div class="card-body">
          <form action="{{url('/update-pengumuman/'.$pengumumanById->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Title <span class="text-danger text-bold">*</span></label>
              <input type="text" class="form-control" id="title" value="{{$pengumumanById->judul_notifikasi}}" name="judul_notifikasi"
                aria-describedby="titleHelp" required>
              <div id="titleHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
              <textarea class="form-control" rows="5" id="deskripsi" name="keterangan" aria-describedby="deskripsiHelp"
                style="height: 100px" required>{{$pengumumanById->keterangan}}</textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
