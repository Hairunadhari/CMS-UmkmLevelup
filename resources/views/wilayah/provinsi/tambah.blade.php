@extends('layouts.app')
@section('title', 'Form Input Provinsi')
@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1 style="width:87%">Input Provinsi</h1>
      </div>
    <div class="section-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/provinsi">

                    List Provinsi
                </a>
            </li>   
            <li  class="breadcrumb-item">
                Input 
            </li>        
            </ol>
          </nav>
        <div class="card">
            <div class="card-header">
                <h5>Form Input Provinsi</h5>
            </div>
            <div class="card-body">
                <form action="{{url('/add-provinsi')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label>Nama Provinsi <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="nama_provinsi" required>
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
