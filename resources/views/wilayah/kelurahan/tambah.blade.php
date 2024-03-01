@extends('layouts.app')
@section('title', 'Form Input Kelurahan')
@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1 style="width:87%">Input Kelurahan</h1>
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
                Input 
            </li>        
            </ol>
          </nav>
        <div class="card">
            <div class="card-header">
                <h5>Form Input Kelurahan</h5>
            </div>
            <div class="card-body">
                <form action="{{url('/add-kelurahan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama Provinsi <span style="color: red">*</span></label>
                        <select class="form-control select2" name="id_provinsi" id="id_provinsi" required>
                            <option selected disabled>-- Pilih Provinsi --</option>
                            @foreach ($data as $item)
                            <option value="{{ $item->id_provinsi }}">{{ $item->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Kabupaten <span style="color: red">*</span></label>
                        <select class="form-control select2" name="id_kabupaten" id="id_kabupaten" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Kecamatan <span style="color: red">*</span></label>
                        <select class="form-control select2" name="id_kecamatan" id="id_kecamatan" required>
                        </select>
                    </div>
                        <div class="form-group">
                            <label>Nama Kelurahan <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="nama_kelurahan" required>
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
@if(session('success'))
    <script>

        $.toast({
            heading: 'Notifikasi :',
            text: "{{ session('success')['message'] }}",
            icon: "{{ session('success')['type'] }}",
            hideAfter: false,
            // loader: true,        // Change it to false to disable loader
            position: 'top-right',
            loaderBg: '#9EC600' // To change the background
        })

    </script>
    @endif
<script>
     $(document).ready(function () {
        $('#id_provinsi').on('change', function () {
            var provinsi = this.value;
            $('#id_kabupaten').html('');
            $('#id_kecamatan').html('');
            $.ajax({
                url: "get-kabupaten-by-provinsi/"+provinsi,
                type: 'get',
                success: function (res) {
                    console.log(res);
                    $('#id_kabupaten').html('<option value="" selected disabled>-- Pilih Kabupaten --</option>');
                    $.each(res, function (key, value) {
                        $('#id_kabupaten').append('<option value="' + value.id_kabupaten + '">' + value.nama_kabupaten + '</option>');
                    });
                }
            });
        });
        $('#id_kabupaten').on('change', function () {
            var kabupaten = this.value;
            $('#id_kecamatan').html('');
            $.ajax({
                url: "/get-kecamatan-by-kabupaten/"+kabupaten,
                type: 'get',
                success: function (res) {
                    // console.log('data kecamatan',res);
                    $('#id_kecamatan').html('<option value="" selected disabled>-- Pilih Kecamatan --</option>');

                    $.each(res, function (key, value) {
                        $('#id_kecamatan').append('<option value="' + value.id_kecamatan + '">' + value.nama_kecamatan + '</option>');
                    });
                }
            });
        });
    });
</script>
@endsection
