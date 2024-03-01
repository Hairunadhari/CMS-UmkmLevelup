@extends('layouts.app')
@section('title', 'Form Edit Kelurahan')
@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1 style="width:87%">Edit Kelurahan</h1>
      </div>
    <div class="section-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/kelurahan">

                    List Kelurahan
                </a>
            </li>   
            <li  class="breadcrumb-item">
                Edit 
            </li>        
            </ol>
          </nav>
        <div class="card">
            <div class="card-header">
                <h5>Form Edit Kelurahan</h5>
            </div>
            <div class="card-body">
                <form action="{{url('/update-kelurahan',$data->id_kelurahan)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    
                   <div class="form-group">
                    <label>Nama Kecamatan <span style="color: red">*</span></label>
                    <select class="form-control select2" name="id_kecamatan"  required>
                        @foreach ($kecamatan as $item)
                       <option value="{{ $item->id_kecamatan }}"
                           {{ $item->id_kecamatan == $data->id_kecamatan ? 'selected' : '' }}>
                           {{ $item->nama_kecamatan }}
                       </option>
                       @endforeach
                   </select>
                  </div>
                        <div class="form-group">
                            <label>Nama Kabupaten <span style="color: red">*</span></label>
                            <input type="text" class="form-control" value="{{$data->nama_kelurahan}}" name="nama_kelurahan" required>
                        </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </section>
</div>

@endsection
