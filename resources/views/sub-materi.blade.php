@extends('layouts.app')

@section('title', 'Tambah Materi')

@push('style')
<style>
  #data-table tbody tr td {
    vertical-align: middle;
  }

  #data-table thead tr th,
  .table th {
    vertical-align: middle !important;
    text-align: center;
  }

  .table:not(.table-sm):not(.table-md):not(.dataTable) td,
  .table:not(.table-sm):not(.table-md):not(.dataTable) th {
    height: 43px !important;
  }

  .form-custom {
    display: inline;
    width: 70%;
    /* height: calc(1.5em + 0.75rem + 2px); */
    padding: 0.375rem 0.75rem;
    /* font-size: 1rem; */
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fdfdff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
  }

  .form-custom:focus,
  .form-custom:active {
    background-color: #fefeff;
    border-color: #95a0f4;
    box-shadow: none !important;
    outline: none;
  }

  .bar {
    background-color: #00ff00;
  }

  .percent {
    position: absolute;
    left: 50%;
    top: 90%;
    color: black
  }

  .bar-pdf {
    background-color: #00ff00;
  }

  .percent-pdf {
    position: absolute;
    left: 50%;
    top: 90%;
    color: black
  }

</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:80%">List Sub Materi </h1>
      {{-- <div class="float-right; text-right" style="width: 20%;"><strong><i class="fa fa-bookmark"></i> Materi : </strong>
        <span class="badge badge-sm badge-dark"> {{$name}} </span>
    </div> --}}
</div>

<div class="section-body">
  <h2 class="section-title">Daftar Sub Materi : '{{$name}}' </h2>
  <p class="section-lead">Sub materi yang diperlukan untuk kategori materi yang sebelumnya.</p>
  {{-- <h1>tes{{ env("APP_CHILD") }}</h1> --}}

  <div class="card">
    <div class="card-body">
      <strong class="text-dark">List Sub Materi </strong>
      <span class="float-right"><button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
          data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Sub Materi</button> </span>
      <hr />
      <div class="row">
        <div class="col-12">
          <table class="table table-striped table-hovered">
            <thead>
              <tr>
                <th>No</th>
                <th>Title</th>
                {{-- <th>Kategori</th> --}}
                <th>File / Video Materi</th>
                <th>Deskripsi</th>
                <th>Tgl</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($sub_materi as $key => $item)
              <tr>
                <td class="text-center">{{$key + 1}}</td>
                <td class="text-center">{{$item->nama}}</td>
                {{-- <td class="text-center">{{'-'}}</td> --}}
                <td class="text-center"><a class="btn btn-dark btn-sm" href="/sub-materi/{{$item->id}}"><i
                      class="fa fa-search"></i>
                    Lihat</a></td>
                <td class="text-center">{{$item->deskripsi}}</td>
                <td class="text-center">{{\Carbon\Carbon::parse($item->created_at)->locale('id')->format('j F Y')}}
                </td>
                <td class="text-center">
                  <form action="/hapus-submateri/{{$item->id}}" method="post"
                    onsubmit="return confirm('Apakah anda yakin akan menghapus data ini ?');">
                    <a href="/edit-sub-materi/{{$item->id}}" class="btn btn-sm btn-warning"><i
                        class="fa fa-th-list"></i>
                      Edit</a>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <button class="btn btn-sm btn-danger" type="submit"><i class="far fa-trash-alt"></i> Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td class="text-center" colspan="6">No Data</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
</section>
</div>

<form action="{{ '/add-sub-materi/'.$id.'/'.$name }}" id="tambahsubmateri" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="modal fade" id="tambahData" aria-labelledby="tambahData" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahDataLabel">Tambah Sub Materi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pb-0">
          <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger text-bold">*</span></label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp" required>
            <div id="titleHelp" class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger text-bold">*</span></label>
            <textarea class="form-control" rows="5" id="deskripsi" name="deskripsi" aria-describedby="deskripsiHelp"
              style="height: 100px" required></textarea>
            <div id="deskripsiHelp" class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="file" class="form-label">Upload File Materi</label>
            <div class="form-group">
              <div class="form-check mb-1">
                <label class="form-check-label" for="pdf">PDF (max: 50 mb)</label>
                <div id="input-pdf">
                  <input type="file" class="form-control mb-2" name="file" accept=".pdf" aria-describedby="fileHelp"
                    id="value-pdf">
                  <div class="progress progrespdf mb-3" style="display: none">
                    <div class="bar-pdf"></div>
                    <div class=" percent-pdf">0%</div>
                  </div>
                </div>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                <label class="form-check-label" for="flexRadioDefault1">Video (max: 100 mb)</label>
                <div id="input-video" >
                  <input type="file" class="form-control mb-2" accept=".mp4, .webm, .mkv" name="video" id="value-video">
                  <div class="progress progresvideo mb-3" style="display: none">
                    <div class="bar"></div>
                    <div class="percent">0%</div>
                  </div>
                </div>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                <label class="form-check-label" for="flexRadioDefault2">Link Embedded Video</label>
                <div id="input-link" style="display: none">
                  <input type="text" class="form-control mb-2"  name="link_video" id="link-video">
                </div>
              </div>

            </div>
          </div>
          <hr />
        </div>
        <div class="modal-footer pt-1 justify-content-center">
          <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
 $(document).ready(function () {
    var barPdf = $('.bar-pdf');
    var percentPdf = $('.percent-pdf');
    var barVideo = $('.bar');
    var percentVideo = $('.percent');
    var submitButton = $('#submit-button');

    $('#tambahsubmateri').ajaxForm({
        beforeSend: function () {
            submitButton.prop('disabled', true);
            var percentVal = '0%';
            barPdf.width(percentVal);
            percentPdf.html(percentVal);
            barVideo.width(percentVal);
            percentVideo.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            var pdfFile = $('#value-pdf')[0].files[0];
            var videoFile = $('#value-video')[0].files[0];

            if (pdfFile && !videoFile) {
                // Jika hanya input PDF
                $('.progrespdf').show();
                barPdf.width(percentVal);
                percentPdf.html(percentVal);
            } else if (!pdfFile && videoFile) {
                // Jika hanya input video
                $('.progresvideo').show();

                barVideo.width(percentVal);
                percentVideo.html(percentVal);
            } else if (pdfFile && videoFile) {
                // Jika keduanya diisi
                $('.progrespdf').show();
                $('.progresvideo').show();

                barPdf.width(percentVal);
                percentPdf.html(percentVal);
                barVideo.width(percentVal);
                percentVideo.html(percentVal);
            }
        },
        complete: function (xhr) {
            submitButton.prop('disabled', false);
            // Alert atau tindakan lainnya setelah pengunggahan berhasil
            // var responseData = xhr.responseJSON;
            // if (responseData.success) {
            //     var name = responseData.name;
            //     var id = responseData.id;
            //     window.location.href = "";
            // }
            // Gantilah window.location.href dengan URL yang sesuai
            // window.location.href = "";
            console.log('tes');
            
        }
    });
});




document.getElementById('flexRadioDefault1').addEventListener('click', function () {
    if (this.checked) {
      document.getElementById('input-video').style.display = 'block';
      document.getElementById('input-link').style.display = 'none';
    }
  });

  document.getElementById('flexRadioDefault2').addEventListener('click', function () {
    if (this.checked) {
      document.getElementById('input-link').style.display = 'block';
      document.getElementById('input-video').style.display = 'none';
    }
  });

</script>
@endsection

@push('scripts')
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
" rel="stylesheet">

<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
  $("#table").dataTable({});

</script>
@if (Session::has('error'))
<script>
  Swal.fire({
    title: "Ada Kesalahan!",
    text: "{{Session::get('error')}}",
    icon: "error",
  });

</script>
@endif
<script>
  $(document).ready(function () {
    $('.select2').select2({
      width: 'resolve'
    });

  });

  $("#simpanLevel").on("click", function () {
    const form = $('#formLevel');
    Swal.fire({
      title: 'Apakah anda yakin?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: 'Iya',
      denyButtonText: `Tidak, kembali`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        Swal.fire('Tersimpan!', '', 'success')
        form.submit()
      } else if (result.isDenied) {
        Swal.fire('Aksi simpan dibatalkan', '', 'info')
      }
    })


  });

</script>

<!-- Page Specific JS File -->
@endpush
