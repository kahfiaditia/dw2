<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{strtoupper($title)}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{URL::asset('assets/images/favicon.ico')}}">
        <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5 text-muted">
                            <a href="{{ route('login') }}" class="d-block auth-logo">
                                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="20" class="auth-logo-dark mx-auto">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body"> 
                                <div class="p-2">
                                    <div class="text-center">
                                        <div class="avatar-md mx-auto">
                                            <div class="avatar-title rounded-circle bg-light">
                                                <i class="{{$icon}} h1 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="p-2 mt-4">
                                            <h4>{{$header}} !</h4>
                                            <p class="text-muted">{{$body}}</p>
                                            <div class="mt-4">
                                                <a href="{{ route('login') }}" class="btn btn-success">Back to Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>Verification't Accepted ? <a href="{{ route('recovery') }}" class="fw-medium text-primary">Resend Verifikasi</a> </p>
                            <p>© <script>document.write(new Date().getFullYear())</script>. Crafted with {{strtoupper($title)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('assets/js/app.js')}}"></script>
    </body>
</html>