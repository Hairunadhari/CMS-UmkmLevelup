@extends('layouts.app')

@section('title', 'Edit Sub Materi')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:87%">Edit Sub Materi</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h4 style="color: black">Edit Sub Materi '{{$a->nama}}'</h4>
        </div>
        <div class="card-body">
          <form action="{{url('/update-sub-materi/'.$a->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Title <span class="text-danger text-bold">*</span></label>
              <input type="text" class="form-control" id="title" value="{{$a->nama}}" name="title"
                aria-describedby="titleHelp" required>
              <div id="titleHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
              <textarea class="form-control" rows="5" id="deskripsi" name="deskripsi" aria-describedby="deskripsiHelp"
                style="height: 100px" required>{{$a->deskripsi}}</textarea>
              <div id="deskripsiHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="file" class="form-label">Upload File Materi <span
                  class="text-danger text-bold">*</span></label>
              <div class="form-group">
                  <label class="form-label" >PDF</label><br>
                  {{-- <span for="">File saat ini</span><input type="tex" class="form-control mb-2" id="file" value="{{$data->file_name}}" name="file"
                  accept=".pdf" aria-describedby="fileHelp"> --}}
                  <input type="file" class="form-control" id="input-pdf" name="file" accept=".pdf"
                    aria-describedby="fileHelp" value="{{$data->file_name}}">
                  <label class="form-label">Video</label>
                  <input type="file" class="form-control" accept=".mp4, .webm, .mkv" id="input-video"
                    value="{{$data->video_name}}" name="video">
              </div>
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
