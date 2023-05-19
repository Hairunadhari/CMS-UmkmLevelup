@extends('layouts.app')

@section('title', 'Setting Level')

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
      <h1 style="width:87%">Setting Logic Level "{{$data->name}}"</h1>
      <div class="float-right">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahData"><i class="fa fa-plus"></i> Tambah Data</button>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Logic Level "{{$data->name}}"</h2>
      <p class="section-lead">List Logic untuk mendapatkan level dari input serta parameter output yang ditargetkan.</p>
      <div class="card">
          {{-- <div class="card-header"> --}}
              {{-- <h4>Set Level</h4> --}}
          {{-- </div> --}}
          <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hovered table-sm">
              <thead>
                <tr>
                  <th class="text-center" scope="col">#</th>
                  <th class="text-center" scope="col">Input</th>
                  <th class="text-center" scope="col">Parameter Output</th>
                  <th class="text-center" scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if (empty($data_logic))
                  <tr>
                  <td colspan="4">Tidak ada data</td>
                </tr>
                  @else
                  @foreach ($data_logic as $key => $value)
                  <tr>
                    <td class="text-center">{{$key + 1}}</td>
                    <td class="text-center">{{$value['name']}}</td>
                    <td class="text-center">{{$value['parameter'] == 'false' ? 'Tidak Terisi' : 'Terisi'}}</td>
                    <td class="text-center"><a class="btn btn-info text-white" href="#{{$value['input_id']}}">edit</a></td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    
<!-- Modal -->
<form action="{{route('/add-logic')}}" method="POST">
<div class="modal fade" id="tambahData" data-backdrop="static" role="dialog" data-keyboard="false" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="tambahDataLabel">Tambah Data Level</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                {{ csrf_field() }}
                <input type="hidden" name="id" class="hidden" value="{{$data->id}}">
                <div class="mb-3">
                    <label for="input" class="form-label">Input</label>
                    <select class="select2" name="input" id="input" style="width: 100%" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($data_json as $item)
                            @if ($item['type'] == 'nf-text' || $item['type'] == 'nf-page-break')
                                @continue
                            @endif
                            <option value="{{$item['id']}}">{{$item['name']}} <small>[{{$item['type']}}]</small></option>
                        @endforeach
                    </select>
                    <textarea name="forms" class="hidden" style="display:none">{{$data_form->properties}}</textarea>
                    <div id="inputHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="parameter" class="form-label">Parameter Output</label>
                    <br>
                    {{-- <input type="parameter" class="form-control" id="parameter" name="parameter" aria-describedby="parameterHelp" required> --}}
                    Terisi : <input type="radio" name="parameter" value="true"><br>
                    Tidak : <input type="radio" name="parameter" value="false">
                    <div id="parameterHelp" class="form-text"></div>
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
    <script>
        $(document).ready(function() {
          $('.select2').select2({
            // dropdownParent: $('#tambahData')
          });
        });
    </script>

    <!-- Page Specific JS File -->
@endpush