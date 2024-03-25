@extends('layouts.app')
@section('title', 'List Artikel')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{('assets/modules/summernote/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{('assets/modules/codemirror/lib/codemirror.css')}}">
<link rel="stylesheet" href="{{('assets/modules/codemirror/theme/duotone-dark.css')}}">
<link rel="stylesheet" href="{{('assets/modules/jquery-selectric/selectric.css')}}">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet" />
   
@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:85%">Management Artikel</h1>
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i
          class="fa fa-plus"></i> Tambah Artikel</button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            List Artikel
          </li>
        </ol>
      </nav>
      <div class="card">
        <div class="card-body"><strong class="text-dark">List Artikel </strong>
          <hr />
          <div class="row">
            <div class="col-12">
              <table class="table table-striped table-hovered" id="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Judul Artikel</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berakhir</th>
                    <th>Lokasi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<form action="/submit-materi" id="tambahsubmateri" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="modal fade" id="tambahData" aria-labelledby="tambahData" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahDataLabel">Form Tambah Artikel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0">
          <div class="mb-3">
            <label for="title" class="form-label">Judul Artikel <span class="text-danger text-bold">*</span></label>
            <input type="text" class="form-control" id="title" name="judul" value="{{ session('judul') }}" aria-describedby="titleHelp" required>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
            <div id="editor"></div>
            <input type="hidden" id="deskripsiHidden" name="deskripsi" value="">
            
          </div>
          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="title" class="form-label">Tanggal Mulai <span class="text-danger text-bold">*</span></label>
                <input type="date" class="form-control" id="title" name="start" aria-describedby="titleHelp"
                  required>
              </div>
            </div>
            <div class="col-6">
              <div class="mb-3">
                <label for="title" class="form-label">Tanggal Berakhir <span
                    class="text-danger text-bold">*</span></label>
                <input type="date" class="form-control" id="title" name="end" aria-describedby="titleHelp"
                  required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <div class="form-group">
              <label >Kategori Artikel <span class="text-danger text-bold">*</span></label>
              <select name="kategori[]" class="form-control select2" multiple="">
                @foreach ($kategori as $item)
                    <option value="{{$item->id}}">{{$item->kategori}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Lokasi <span class="text-danger text-bold">*</span></label>
            <input type="text" class="form-control" id="title" name="lokasi" aria-describedby="titleHelp" required>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Gambar Artikel <small>max : 5mb</small><span class="text-danger text-bold">*</span></label>
            <input type="file" class="form-control" accept=".jpg, .jpeg, .png" id="title" name="gambar" aria-describedby="titleHelp" required>
          </div>
        </div>
        <div class="modal-footer pt-1 justify-content-center">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<script src="{{('assets/modules/summernote/summernote-bs4.js')}}"></script>
<script src="{{('assets/modules/codemirror/lib/codemirror.js')}}"></script>
<script src="{{('assets/modules/codemirror/mode/javascript/javascript.js')}}"></script>
<script src="{{('assets/modules/jquery-selectric/jquery.selectric.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>



<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
  $(document).ready(function () {
      var table = $('#table').DataTable({
          processing: true,
          ordering: false,
          searching: true,
          serverSide: true,
          stateSave: true,

          ajax: '{{ url()->current() }}',
          columns: [{
              render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
                }

                ,
            }

            ,
            {
              data: 'judul',
            },
            {
              data: 'start',
            },
            {
              data: 'end',
            },
            {
              data: 'lokasi',
            },
            {
              data: 'gambar',
              render: function (data) {
                return '<a href="'+data+'" target="_blank"><img src="' +data+
                    '"style="width: 100px; box-shadow: rgba(0, 0, 0, 0.16) 0px 2px 2px; margin:5px; padding:0.25rem; border:1px solid #dee2e6;"></a>';
              },
            },
            {

              data: null,
              render: function (data) {
                var deleteUrl = '/delete-kategori/' + data.encryptId;
                var editUrl = '/edit-materi/' + data.encryptId;
                return `
                        <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Apakah anda yakin akan menghapus data ini ?');">
                        <span><a class="btn btn-primary" href="${editUrl}"><i class="far fa-edit"></i></a></span>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <button class="btn btn-danger" type="submit"><i class="far fa-trash-alt"></i></button>
                        </form>
                    `;
              },
            }

            ,

          ],
        }

      );
    
      
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
