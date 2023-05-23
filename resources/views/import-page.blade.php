@extends('layouts.app')

@section('title', 'Import Data')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th, .table th {
        vertical-align: middle !important;
        text-align: center;
    }
</style>
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">Import Data</h1>
        <div class="float-right">
          {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button> --}}
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Import Data </h2> 
        <p class="section-lead">Fitur Import data khusus untuk file excel dengan format header yang sudah ditentukan.</p>
        <div class="card">
            <div class="card-body text-center">
                <form class="form-inline justify-content-center" id="formLevel" action="#" method="POST">
                    @csrf
                    <strong class="text-dark">File Excel (Xlsx / Xls) : </strong>
                      <input type="hidden" class="hidden" name="id_user" value="">
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="inputFile" class="sr-only">File Excel (Xlsx / Xls)</label>
                      <input type="file" class="form-control" id="inputFile" name="file-input" />
                    </div>
                    <button type="button" class="btn btn-warning btn-lg mb-2" id="simpanLevel">Jalankan Import <i class="fa fa-upload"></i></button>
                  </form>
            </div>
        </div>

    </section>
    
  </div>
@endsection
   
@push('scripts')


<!-- Page Specific JS File -->
@endpush