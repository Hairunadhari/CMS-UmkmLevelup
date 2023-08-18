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
                <form class="form-inline justify-content-center" id="formLevel" action="{{url('import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <strong class="text-dark">File Excel (Xlsx / Xls) : </strong>
                      <input type="hidden" class="hidden" name="id_user" value="">
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="inputFile" class="sr-only">File Excel (Xlsx / Xls)</label>
                      <input type="file" class="form-control" id="inputFile" name="file" />
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="SelectForm" class="sr-only">Form</label>
                      <select class="form-control" id="SelectForm" name="id_form" required>
                        <option value="">-- Pilih Form --</option>
                        @forelse ($forms as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @empty
                            
                        @endforelse
                      </select>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg mb-2" id="simpanLevel">Jalankan Import <i class="fa fa-upload"></i></button>
                </form>
            </div>
        </div>
        {{-- <div class="card">
          <div class="card-body">
            <strong class="text-dark">Histori Import </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <table class="table table-striped table-hovered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center" colspan="4">No Data</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> --}}

    </section>
    
  </div>
@endsection
   
@push('scripts')

<!-- Page Specific JS File -->
@endpush