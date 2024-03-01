@extends('layouts.app')
@section('title', 'Form Input Kecamatan')
@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1 style="width:87%">Input kecamatan</h1>
      </div>
    <div class="section-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/kecamatan">

                    List Kecamatan
                </a>
            </li>   
            <li  class="breadcrumb-item">
                Input 
            </li>        
            </ol>
          </nav>
        <div class="card">
            <div class="card-header">
                <h5>Form Input Kecamatan</h5>
            </div>
            <div class="card-body">
                <form action="{{url('/add-kecamatan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama Provinsi <span style="color: red">*</span></label>
                        <select class="form-control select2" name="id_provinsi" id="id_provinsi" required>
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
                            <input type="text" class="form-control" name="nama_kecamatan" required>
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
                $.ajax({
                    url: "get-kabupaten-by-provinsi/"+provinsi,
                    type: 'get',
                    success: function (res) {
                        console.log(res);
                        $.each(res, function (key, value) {
                            console.log(value);
                            $('#id_kabupaten').append('<option value="' + value.id_kabupaten + '">' + value.nama_kabupaten + '</option>');
                        });
                    }
                });
            });
            // $('#id_kabupaten').on('change', function () {
            //     var provinsi = this.value;
            //     console.log(provinsi);
            // });
        });
</script>
@endsection
