<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">
    <title>Login &mdash; Stisla</title>

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
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="m-3 p-4">
                        <img src="{{ asset('img/stisla-fill.svg') }}"
                            alt="logo"
                            width="80"
                            class="shadow-light rounded-circle mb-5 mt-2">
                        <h4 class="text-dark font-weight-normal">Selamat datang di <span class="font-weight-bold">Admin Panel</span>
                        </h4>
                        <p class="text-muted">sebelum memulai diharapkan memasukkan username dan password yang sudah diberikan.</p>
                        <form method="POST"
                            action="#"
                            class="needs-validation"
                            novalidate="">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username"
                                    type="text"
                                    class="form-control"
                                    name="username"
                                    tabindex="1"
                                    required
                                    autofocus>
                                <div class="invalid-feedback">
                                        Harap masukkan username anda
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

                        <div class="text-small mt-5 text-center">
                            Copyright &copy; BRI. Made with by PT Spero
                            <div class="mt-2">
                                <a href="#">Privacy Policy</a>
                                <div class="bullet"></div>
                                <a href="#">Terms of Service</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 min-vh-100 background-walk-y position-relative overlay-gradient-bottom order-1"
                    data-background="{{ asset('img/unsplash/login-bg2   .jpg') }}">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="display-4 font-weight-bold mb-2">UMKM BRI</h1>
                                <h5 class="font-weight-normal text-muted-transparent">Bali, Indonesia</h5>
                            </div>
                            Photo by <a class="text-light bb"
                                target="_blank"
                                href="https://mnews-wp.s3.ap-southeast-1.amazonaws.com/wp-content/uploads/2020/06/29135912/umkm-bank-bri.jpg">Mnews</a> on <a
                                class="text-light bb"
                                target="_blank"
                                href="https://mnews.co.id/">Mnews.co.id</a>
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
