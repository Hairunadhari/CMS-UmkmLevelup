@extends('layouts.app')
@section('title', 'Form Input Kabupaten')
@section('main')
<div class="main-content">
  <section class="section">
    
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Form Input Kabupaten</h5>
            </div>
            <div class="card-body">
                <form action="{{url('/update-kabupaten',$data->id_kabupaten)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <select class="form-control select2" name="id_provinsi"  required>
                        @foreach ($provinsi as $item)
                       <option value="{{ $item->id_provinsi }}"
                           {{ $item->id_provinsi == $data->id_provinsi ? 'selected' : '' }}>
                           {{ $item->nama_provinsi }}
                       </option>
                       @endforeach
                   </select>
                        <div class="form-group">
                            <label>Nama Kabupaten <span style="color: red">*</span></label>
                            <input type="text" class="form-control" value="{{$data->nama_kabupaten}}" name="nama_kabupaten" required>
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
