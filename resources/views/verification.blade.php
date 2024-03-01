@extends('layouts.app')

@section('title', 'Verification')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th, .table th {
        vertical-align: middle !important;
        text-align: center;
    }
    .table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th{
        height: 43px !important;
    }
</style>
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:80%">Kuesioner - Verifikasi</h1>
        <div class="float-right; text-right" style="width: 20%;"><strong>System : </strong> <span class="badge badge-sm badge-dark">{{$data->level}}</span></div>
      </div>

      <div class="section-body">
        {{-- <h2 class="section-title">Verifikasi </h2>  --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/kuesioner-unverif">List Kuesioner - Unverified</a></li>
              <li class="breadcrumb-item {{ request()->routeIs('verif-page/{id}/{level}') ? 'active' : '' }}">
                @if(request()->routeIs('verif-page/{id}/{level}'))
                    Verifikasi
                @endif
            </li>
            </ol>
          </nav>
        <p class="section-leadx">Memverifikasi final level dengan hasil data responden.</p>
        <div class="card">
            <div class="card-body">
                <a data-toggle="collapse" href="#collapseProfil" style="text-decoration:none; color: #000" role="button" s aria-expanded="false" aria-controls="collapseProfil">
                    <strong>Detail Data Profil</strong> :
                </a>
                <div class="float-right">
                    <b>Tgl Regist</b> : 
                    <span class="badge badge-xs badge-info" style="padding: 7px 12px;font-size:12px"><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($data->email_verified_at)->locale('id')->format('j F Y')}}</span>
                    <td></td>

                </div>
                <hr>
                <div class="collapse" id="collapseProfil">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nama</b> : {{$data->name}}<hr />
                            <b>Email</b> : {{$data->email}}<hr />
                            <b>NIK</b> : {{$data->nik}}<hr />
                            <b>No HP</b> : {{$data->no_hp}}<hr />
                        </div>
                        <div class="col-md-4">
                            <b>Kabupaten</b> : {{$data->nama_kabupaten ?? '-'}}<hr />
                            <b>Kecamatan</b> : {{$data->nama_kecamatan ?? '-'}}<hr />
                            <b>Kelurahan</b> : {{$data->nama_kelurahan ?? '-'}}<hr />
                            <b>Alamat Lengkap</b> :
                            {{$data->alamat_lengkap ?? '-'}}<hr />
                        </div>
                        <div class="col-md-4">
                            <b>Toko</b> : <span class="badge badge-xs badge-danger" style="padding: 7px 12px;font-size:12px"><i class="fa fa-store"></i> {{$data->nama_usaha}}</span><hr />
                            <b>No Telp</b> : {{$data->no_telp}}<hr />
                            <b>Email Usaha</b> : {{$data->email_usaha}}<hr />
                            <b>NIB</b> : {{$data->nib}}<hr />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <a data-toggle="collapse" href="#collapseResponden" style="text-decoration:none; color: #000" role="button" s aria-expanded="false" aria-controls="collapseResponden">
                    <strong>Detail Data Responden</strong> :
                </a>
                <div class="float-right">
                    <b>Tgl Submit</b> : 
                    <span class="badge badge-xs badge-warning" style="padding: 7px 12px;font-size:12px"><i class="fa fa-calendar"></i> {{$data->updated_at != null ? \Carbon\Carbon::parse($data->updated_at)->locale('id')->format('j F Y') : ''}}</span>
                    <td></td>

                </div>
                <hr>
                <div class="collapse" id="collapseResponden">
                    <div class="row">
                        {!! $data->html !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form class="form-inline" id="formLevel" action="{{url('/')}}/submit-verif" method="POST">
                    @csrf
                    <strong class="text-dark">Aksi Verifikasi : </strong>
                      <input type="hidden" class="hidden" name="id_user" value="{{$data->id_user}}">
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="inputLevel" class="sr-only">Password</label>
                      <select class="form-control" name="level" id="level" required>
                          <option value="">-- Pilih --</option>
                          <option value="5">Novice</option>
                          <option value="1">Beginner</option>
                          <option value="2">Observer</option>
                          <option value="3">Adopter</option>
                          <option value="4">Leader</option>
                      </select>
                    </div>
                    <button type="button" class="btn btn-primary btn-lg mb-2" id="simpanLevel">Simpan <i class="fa fa-paper-plane"></i></button>
                  </form>
            </div>
        </div>
      </div>
    </section>
  </div>

@endsection
   
@push('scripts')
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
" rel="stylesheet">

<script>
    $(document).ready(function() {
      $('.select2').select2({
        width: 'resolve'
      });
    });

    $( "#simpanLevel" ).on( "click", function() {
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