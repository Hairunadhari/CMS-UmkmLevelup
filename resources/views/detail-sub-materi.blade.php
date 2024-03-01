@extends('layouts.app')

@section('title', 'Detail Sub Materi')

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">Detail Sub Materi</h1>
      </div>
      
<div class="section-body">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/list-matero">
              List Kategori Materi 
            </a>
        </li>        
          <li class="breadcrumb-item">
            <a href="/{{$a->nama_materi}}/sub-materi/{{$a->id_materi}}">
                List Sub Materi '{{$a->nama_materi}}' 
            </a>
        </li>        
        </li>        
          <li class="breadcrumb-item">
            Detail Sub Materi '{{$a->nama}}' 
        </li>        
        </ol>
      </nav>
    <div class="card">
        <div class="card-header">
            <h4 style="color: black">Detail Sub Materi '{{$a->nama}}'</h4>
        </div>
        <div class="card-body">
            <form>
                @if ($data != null)
                    
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
                @else
                <div class="form-group">
                    <label>File PDF Location</label>
                    <br>
                    <span>-</span>
                </div>
                <div class="form-group">
                    <label>Video Location</label>
                    <br>
                    <span>-</span>
                </div>
                    
                @endif
            </form>
        </div>
    </div>
</div>
     </section>
  </div>
@endsection