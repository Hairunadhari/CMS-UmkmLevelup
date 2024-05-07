@extends('layouts.app')

@section('title', 'User')

@push('style')
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1 style="width:87%">User</h1>
      <div class="float-right">
      </div>
    </div>

    <div class="section-body">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            User
          </li>

        </ol>
      </nav>
      <p class="section-leadx">List user yang sudah melakukan registrasi.</p>
      <div class="card">
        
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-z">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Email</th>
                  <th scope="col">No Telp</th>
                  <th scope="col">Created at</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection

@push('scripts')
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script>
  $(document).ready(function () {
    $('.select2').select2();

    var table = $('#table-z').DataTable({
      processing: true,
      ordering: false,
      searching: true,
      serverSide: true,
      stateSave: true,
      ajax: {
        url: '{{ url()->current() }}',
      },
      columns: [{
          data: 'id'
        },
        {
          data: 'name',
        },
        {
          data: 'email',
        },
        {
          data: 'no_wa',
          render: function (data) {
            if (data == null) {
                a = `<span>-</span>`
            }else{

                a = data
            }
            return a;
          }
        },
        {
          data: 'created_at',
          render: function (data) {
            if (data == null) {
                a = `<span>-</span>`
            }else{

                a = data
            }
            return a;
          }
        },
      ],
    });
  });

</script>

<!-- Page Specific JS File -->
@endpush
