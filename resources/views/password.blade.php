@extends('layouts.app')
@section('title', 'Form Password')
@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1 style="width:87%">Update Password</h1>
      </div>
    <div class="section-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/management-user">

                    List User
                </a>
            </li>   
            <li  class="breadcrumb-item">
                Update Password 
            </li>        
            </ol>
          </nav>
        <div class="card">
            <div class="card-header">
                <h5>Form Update Password</h5>
            </div>
            <div class="card-body">
                <form action="/update-password/{{$data->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                        <div class="form-group">
                            <label>Password <span style="color: red">*</span></label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password <span style="color: red">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" required>
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

@push('scripts')
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css
" rel="stylesheet">

<!-- Page Specific JS File -->
@if (Session::has('alert'))
<script>
  Swal.fire({
    title: "{{Session::get('alert')['title']}}",
    text: "{{Session::get('alert')['text']}}",
    icon: "{{Session::get('alert')['icon']}}",
  });

</script>
@endif
<!-- Page Specific JS File -->
@endpush
