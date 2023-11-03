@extends('layouts.app')

@section('title', 'Detail Sub Materi')

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">Detail Sub Materi</h1>
      </div>
      
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4 style="color: black">Detail Sub Materi '{{$a->nama}}'</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label>File PDF Location</label>
                    <br>
                    <a target="_blank" href="{{ $data->file_location }}">{{ $data->file_location }}</a>
                </div>
                <div class="form-group">
                    <label>Video Location</label>
                    <br>
                    <a target="_blank" href="{{ $data->video_url }}">{{ $data->video_url }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
     </section>
  </div>
@endsection