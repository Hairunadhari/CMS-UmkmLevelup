@extends('layouts.app')

@section('title', 'Edit Sub Materi')
@push('style')
    <style>
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
      <h1 style="width:87%">Edit Sub Materi</h1>
    </div>

    <div class="section-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/list-materi">
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
            Edit Sub Materi '{{$a->nama}}' 
        </li>        
        </ol>
      </nav>
      <div class="card">
        <div class="card-header">
          <h4 style="color: black">Edit Sub Materi '{{$a->nama}}'</h4>
        </div>
        <div class="card-body">
          <form action="{{url('/update-sub-materi/'.$a->id)}}" id="editsubmateri" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" value="{{$a->nama}}" name="title"
                aria-describedby="titleHelp" required>
              <div id="titleHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea class="form-control" rows="5" id="deskripsi" name="deskripsi" aria-describedby="deskripsiHelp"
                style="height: 100px" required>{{$a->deskripsi}}</textarea>
              <div id="deskripsiHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="file" class="form-label">Upload File Materi</label>
              <div class="form-group">
                <div class="form-check mb-1">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                  <label class="form-check-label" for="pdf">PDF (max: 50 mb)</label>
                  <div id="input-pdf" style="display: none">
                    <input type="file" class="form-control mb-2" name="file" accept=".pdf" aria-describedby="fileHelp"
                      id="input-value-pdf">
                    <div class="progress progrespdf mb-3" style="display: none">
                      <div class="bar-pdf"></div>
                      <div class=" percent-pdf">0%</div>
                    </div>
                  </div>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">Video (max: 100 mb)</label>
                  <div id="input-video" style="display: none">
                    <input type="file" class="form-control mb-2" accept=".mp4, .webm, .mkv" name="video" id="input-value-video">
                    <div class="progress progresvideo mb-3" style="display: none">
                      <div class="bar"></div>
                      <div class="percent">0%</div>
                    </div>
                  </div>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="flexRadioDefault2">
                  <label class="form-check-label" for="flexRadioDefault2">Link Embedded Video</label>
                  <div id="input-link" style="display: none">
                    <input type="text" class="form-control mb-2"  name="link_video" id="input-link-video">
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" id="submit-button" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
  $(document).ready(function () {
    var barPdf = $('.bar-pdf');
    var percentPdf = $('.percent-pdf');
    var barVideo = $('.bar');
    var percentVideo = $('.percent');
    var submitButton = $('#submit-button');

    $('#editsubmateri').ajaxForm({
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
            var responseData = xhr.responseJSON;
            if (responseData.success) {
                var name = responseData.name;
                var id = responseData.id;
                window.location.href = "/"+name+"/sub-materi/"+id;
            }
            // Gantilah window.location.href dengan URL yang sesuai
            // window.location.href = "";
            
        }
    });
});
document.getElementById('flexCheckChecked').addEventListener('click', function () {
    if (this.checked) {
      document.getElementById('input-pdf').style.display = 'block';
      document.getElementById('input-value-pdf').required = true;
    }else{
      document.getElementById('input-pdf').style.display = 'none';
      document.getElementById('input-value-pdf').required = false;
      document.getElementById('input-value-pdf').value = '';

    }
  });

  document.getElementById('flexCheckDefault').addEventListener('click', function () {
    if (this.checked) {
      document.getElementById('input-video').style.display = 'block';
      document.getElementById('input-value-video').required = true;
      document.getElementById('flexRadioDefault2').checked = false;

      // link embed
      document.getElementById('input-link-video').required = false;
      document.getElementById('input-link').style.display = 'none';
      document.getElementById('input-link-video').value = '';
    }else{
      document.getElementById('input-video').style.display = 'none';
      document.getElementById('input-value-video').value = '';
      
    }
  });

  document.getElementById('flexRadioDefault2').addEventListener('click', function () {
    if (this.checked) {
      document.getElementById('input-link').style.display = 'block';
      document.getElementById('input-link-video').required = true;
      
      document.getElementById('input-video').style.display = 'none';
      document.getElementById('input-value-video').required = false;
      document.getElementById('input-value-video').value = '';
      document.getElementById('flexCheckDefault').checked = false;
    }else{
      document.getElementById('input-link').style.display = 'none';
      document.getElementById('input-link-video').value = '';

    }
  });
</script>
@endsection
