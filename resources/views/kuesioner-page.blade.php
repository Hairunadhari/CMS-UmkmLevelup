@extends('layouts.app')

@section('title', 'Kuesioner Data')

@push('style')
<style>
    #data-table tbody tr td {
        vertical-align: middle;
    }
    #data-table thead tr th, .table th {
        vertical-align: middle !important;
        text-align: center;
    }
    table tr th {
        width: auto;
        height: auto;
        font-size: 12px;
    }
    table tr td {
        width: 20%;
        height: auto;
        font-size: 12px;
    }
</style>
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1 style="width:87%">Kuesioner Data</h1>
        <div class="float-right">
          <a type="button" target="_blank" class="btn btn-sm btn-success" href="{{url('/')}}/export-kuesioner/{{$id}}"><i class="fa fa-file-excel"></i> Export Excel</a>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Kuesioner Data </h2> 
        <p class="section-lead">Kuesioner data yang sudah di isi oleh responden.</p>
        <div class="card">
          <div class="card-body">
            <strong class="text-dark">Semua Data Kuesioner Responden </strong>
            <hr />
            <div class="row">
              <div class="col-12">
                <div class="table-responsive" style="max-height:400px; overflow:auto">
                    <table class="table table-striped table-bordered table-sm" >
                    <thead>
                        <tr>
                        {!! $data['head'] !!}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['body'] as $item)
                            {!! $item !!}
                        @empty
                            
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
@endsection
   
@push('scripts')

<!-- Page Specific JS File -->
@endpush