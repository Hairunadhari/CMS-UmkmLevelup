<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">
    <title>Login &mdash; Admin UMKM Levelup</title>

    <!-- General CSS Files -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/components.css') }}">
    <style>
        .absolute-bottom-right{
            position: absolute;
            right: 0;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="m-3 p-4">
                        <div class="text-center"> 
                            <img src="{{ asset('img/logo2.png') }}"
                                alt="logo"
                                width="80"
                                class=" mb-5 mt-2">
                        </div>
                        <h4 class="text-dark font-weight-normal">Selamat datang di <span class="font-weight-bold">Admin Panel</span>
                        </h4>
                        {{-- <p class="text-muted">sebelum memulai diharapkan memasukkan email dan password yang sudah diberikan.</p> --}}
                        <form method="POST"
                            action="{{url("process-login")}}"
                            class="needs-validation"
                            novalidate="">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email"
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    tabindex="1"
                                    required
                                    autofocus>
                                <div class="invalid-feedback">
                                        Harap masukkan email anda
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password"
                                        class="control-label">Password</label>
                                </div>
                                <input id="password"
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    tabindex="2"
                                    required>
                                <div class="invalid-feedback">
                                    Harap masukkan password anda
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit"
                                    class="btn btn-primary btn-lg btn-icon icon-right"
                                    tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="text-small mt-2 text-center">
                            Copyright &copy; Kominfo Ekonomi Digital.
                            <div class="mt-2">
                                {{-- <a href="#">Privacy Policy</a> --}}
                                {{-- <div class="bullet"></div> --}}
                                {{-- <a href="#">Terms of Service</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 min-vh-100 background-walk-y position-relative overlay-gradient-bottom order-1" style="background-position: 0 50%"
                    data-background="{{ asset('img/unsplash/login-bg2.jpg') }}">
                    <div class="absolute-bottom-right index-2 text-right">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="display-4 font-weight-bold mb-2" style="text-shadow:2px 3px 1px #1a1a1b">UMKM Levelup</h1>
                                <h5 class="font-weight-normal text-muted-transparent">Bundaran HI, Indonesia</h5>
                            </div>
                            Photo by <a class="text-light bb"
                                target="_blank"
                                href="https://Pexels.com">Pexels</a> on <a
                                class="text-light bb"
                                target="_blank"
                                href="https://Pexels.com/">Pexels.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
