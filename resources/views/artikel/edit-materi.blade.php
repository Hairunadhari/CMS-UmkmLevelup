@extends('layouts.app')
@section('title', 'Form Edit Artikel')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet" />

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1 style="width:87%">Edit Artikel</h1>
      </div>
    <div class="section-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/materi-artikel">
                    List Artikel
                </a>
            </li>   
            <li  class="breadcrumb-item">
                Edit 
            </li>        
            </ol>
          </nav>
        <div class="card">
            <div class="card-header">
                <h5>Form Edit Artikel</h5>
            </div>
            <div class="card-body">
                <form action="/update-materi/{{$data->id}}" id="tambahsubmateri" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                            <div class="mb-3">
                              <label for="title" class="form-label">Judul Artikel <span class="text-danger text-bold">*</span></label>
                              <input type="text" class="form-control" id="title" name="judul" value="{{ $data->judul }}" aria-describedby="titleHelp" required>
                            </div>
                            <div class="mb-3">
                              <label for="title" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
                              <div id="editor">{!!  $data->deskripsi !!}</div>
                              <input type="hidden" id="deskripsiHidden" name="deskripsi" value="{{$data->deskripsi}}">
                              
                            </div>
                            <div class="row">
                              <div class="col-6">
                                <div class="mb-3">
                                  <label for="title" class="form-label">Tanggal Berakhir <span class="text-danger text-bold">*</span></label>
                                  <input type="date" class="form-control" id="title" name="start" aria-describedby="titleHelp" value="{{ $data->start }}"
                                    >
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="mb-3">
                                  <label for="title" class="form-label">Tanggal Berakhir <span
                                      class="text-danger text-bold">*</span></label>
                                  <input type="date" class="form-control" id="title" name="end" aria-describedby="titleHelp" value="{{ $data->end }}"
                                    >
                                </div>
                              </div>
                            </div>
                            <div class="mb-3">
                              <div class="form-group">
                                <label >Kategori Artikel <span class="text-danger text-bold">*</span></label>
                                <select name="kategori[]" class="form-control select2" multiple="">
                                    @foreach ($kategori as $item)
                                        @php
                                            $isSelected = $kategoriTerpilih->contains('artikel_id', $item->id);
                                        @endphp
                                        <option value="{{$item->id}}" {{ $isSelected ? 'selected' : '' }}>{{$item->kategori}}</option>
                                    @endforeach
                                </select>
                                
                              </div>
                            </div>
                            <div class="mb-3">
                              <label for="title" class="form-label">Lokasi <span class="text-danger text-bold">*</span></label>
                              <input type="text" class="form-control" id="title" name="lokasi" aria-describedby="titleHelp" value="{{ $data->lokasi }}">
                            </div>
                            <div class="mb-3">
                              <label for="title" class="form-label">Gambar Artikel <small>max : 2mb</small><span class="text-danger text-bold">*</span></label>
                              <input type="file" class="form-control" accept=".jpg, .jpeg, .png" id="title" name="gambar" aria-describedby="titleHelp" >
                            </div>
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
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>

<script>
  $(document).ready(function () {
    const quill = new Quill('#editor', {
      theme: 'snow'
    });

    function updateHiddenInput() {
      const content = document.querySelector('.ql-editor').innerHTML;
      document.getElementById('deskripsiHidden').value = content;
    }

    // Tambahkan event listener untuk memperbarui input tersembunyi ketika konten berubah
    quill.on('text-change', function() {
      updateHiddenInput();
    });
  });
  

</script>
@if (Session::has('alert'))
<script>
  Swal.fire({
    title: "{{Session::get('alert')['title']}}",
    text: "{{Session::get('alert')['text']}}",
    icon: "{{Session::get('alert')['icon']}}",
  });

</script>
@endif
@endpush
