@extends('layouts.app')

@section('title', 'Setting Level')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th {
        vertical-align: middle;
        text-align: center;
    }
</style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1 style="width:87%">Set Level</h1>
            <div class="float-right">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button>
            </div>
          </div>

            <div class="section-body">
                    <h2 class="section-title">List Setting Level</h2>
                    <p class="section-lead">List daftar setting level.</p>
                <div class="card">
                    {{-- <div class="card-header"> --}}
                        {{-- <h4>Set Level</h4> --}}
                    {{-- </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                              <thead>
                                <tr>
                                  <th class="text-center" scope="col">#</th>
                                  <th class="text-center" scope="col">Nama</th>
                                  <th class="text-center" scope="col">Level</th>
                                  <th class="text-center" scope="col">Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse ($data as $key => $value)
                                  <tr>
                                      <td class="text-center">{{$key+1}}</td>
                                      <td class="text-center">{{$value->name}}</td>
                                      <td class="text-center">{{$value->level}}</td>
                                      <td class="text-center">
                                        <a class="btn btn-warning btn-sm" href="set-logic/{{$value->id}}">Logic</a> &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" href="delete/{{$value->id}}"><i class="fa fa-times"></i></button>
                                      </td>
                                  </tr>
                                @empty
                                  <tr>
                                      <td colspan="4">Tidak Ada Data</td>
                                  </tr>
                                @endforelse
                              </tbody>
                            </table>
                          </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

     
<!-- Modal -->
<form action="add-level" method="POST">
  <div class="modal fade" id="tambahData"  aria-labelledby="tambahData" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahDataLabel">Tambah Data Level</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                  {{ csrf_field() }}
                  <div class="mb-3">
                      <label for="nama" class="form-label">Nama</label>
                      <input type="nama" class="form-control" id="nama" name="nama" aria-describedby="namaHelp" required>
                      <div id="namaHelp" class="form-text"></div>
                  </div>
                  <div class="mb-3">
                      <label for="level" class="form-label">Level</label>
                      <select class="form-control" name="level" id="level" required>
                          <option value="">-- Pilih --</option>
                          <option value="1">Beginner</option>
                          <option value="2">Adapter</option>
                          <option value="3">Observer</option>
                          <option value="4">Legend</option>
                      </select>
                      <div id="levelHelp" class="form-text"></div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
              </div>
          </div>
      </div>
  </div>
  </form>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
