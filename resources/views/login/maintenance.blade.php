<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ ucfirst($submenu) . ' | ' . strtoupper($title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo/icon.png') }}">
    <!-- Bootstrap Css -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <section class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="home-wrapper">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="text-center mb-5 text-muted">
                                    <a href="javascript: void(0);" class="d-block auth-logo">
                                        <img src="{{ URL::asset('assets/images/logo/sid.png') }}" alt=""
                                            width="100%" class="auth-logo-dark mx-auto">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="assets/images/maintenance.svg" alt=""
                                        class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-5">Site is Under Maintenance</h3>
                        <p>Please check back in sometime.</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mt-4 maintenance-box">
                                    <div class="card-body">
                                        <i class="bx bx-broadcast mb-4 h1 text-primary"></i>
                                        <h5 class="font-size-15 text-uppercase">Why is the Site Down?</h5>
                                        <p class="text-muted mb-0">There are many variations of passages of
                                            Website available, but the majority have suffered alteration.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mt-4 maintenance-box">
                                    <div class="card-body">
                                        <i class="bx bx-time-five mb-4 h1 text-primary"></i>
                                        <h5 class="font-size-15 text-uppercase">
                                            What is the Downtime?</h5>
                                        <p class="text-muted mb-0">Contrary to popular belief, Website is not
                                            simply random text. It has roots in a piece of classical.<br><br></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mt-4 maintenance-box">
                                    <div class="card-body">
                                        <i class="bx bx-envelope mb-4 h1 text-primary"></i>
                                        <h5 class="font-size-15 text-uppercase">
                                            Do you need Support?</h5>
                                        <p class="text-muted mb-0">If you are going to use a passage of Website, you
                                            need to be sure there isn't anything embar.. <a
                                                href="mailto:info@sekolah-dharmawidya.sch.id"
                                                class="text-decoration-underline">info@sekolah-dharmawidya.sch.id</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
