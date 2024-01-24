@extends('layouts.app')
@section('title', 'Form Edit Kecamatan')
@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-body">
      <div class="card">
        <div class="card-header">
          <h5>Form Edit kecamatan</h5>
        </div>
        <div class="card-body">
          <form action="{{url('/update-kecamatan',$data->id_kecamatan)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group">
              <label>Nama Kabupaten <span style="color: red">*</span></label>
              <select class="form-control select2" name="id_kabupaten" required>
                @foreach ($kabupaten as $item)
                <option value="{{ $item->id_kabupaten }}"
                  {{ $item->id_kabupaten == $data->id_kabupaten ? 'selected' : '' }}>
                  {{ $item->nama_kabupaten }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama Kabupaten <span style="color: red">*</span></label>
              <input type="text" class="form-control" value="{{$data->nama_kecamatan}}" name="nama_kecamatan" required>
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
