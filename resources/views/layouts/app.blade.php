<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') &mdash; Admin UMKM Levelup</title>
  <link href="{{ asset('img/logo2.png') }}" rel="icon">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  @stack('style')

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">

  @yield('custom-css')

  <style>
    #data-table tbody tr td {
      vertical-align: middle;
    }

    #data-table thead tr th {
      vertical-align: middle;
      text-align: center;
    }

    #data-table tbody tr td {
      vertical-align: middle;
    }

    #data-table thead tr th {
      vertical-align: middle;
      text-align: center;
    }

    .dataTables_length select {
      outline-color: #6777ef
    }

    .dataTables_wrapper .dataTables_filter input {
      outline-color: #6777ef;
      outline-offset: unset;
      -webkit-appearance: auto;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      margin: 3px 3px !important;
      padding: 5px 10px !important;
      outline-color: #6777ef;
      outline-offset: unset;
      -webkit-appearance: auto;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
      background: linear-gradient(to bottom, #6777ef 0%, #6777ef 100%) !important;
      border: 1px solid #6777ef !important;
      color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: linear-gradient(to bottom, #6777ef 0%, #6777ef 100%) !important;
      border: 1px solid #6777ef !important;
      color: white !important;
    }

    .swal2-cancel {
      margin-right: 10px;
    }

  </style>

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');

  </script>
  <!-- END GA -->
</head>
</head>

<body class="{{ Request::is('dashboard-gudang') ? 'sidebar-mini' : '' }}"
  {{ Request::is('dashboard-gudang') ? 'style=min-width:5500px' : '' }}>
  <div id="app">
    <div class="main-wrapper">
      <!-- Header -->
      @include('components.header')

      <!-- Sidebar -->
      @include('components.sidebar')

      <!-- Content -->
      @yield('main')

      <!-- Footer -->
      @include('components.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
  <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
  <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('js/stisla.js') }}"></script>

  @stack('scripts')

  <!-- Template JS File -->
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
  
  {{-- @if (Session::has('success'))
  <script>
    Swal.fire({
      title: "Success!",
      text: "{{Session::get('success')}}",
      icon: "success",
    });
  </script>
  @endif --}}

  <script>
    $(document).ready(function () {
      $(".select2-tags").select2({
        tags: true
      });
    });

  </script>
</body>

</html>
