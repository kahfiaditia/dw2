<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ ucfirst($submenu) . ' | ' . strtoupper($title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo/icon.png') }}">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">{{ $subject }}</h5>
                                        <p>{{ $p }}</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="#">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ URL::asset('assets/images/logo/icon.png') }}" alt=""
                                                class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            @if (session()->has('Error'))
                                <div class="p-2">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('Error') }}
                                    </div>
                                </div>
                            @endif
                            @if ($errors->any())
                                {!! $errors->first(
                                    'email',
                                    '<div class="p-2"><div class="alert alert-danger" role="alert">:message</div></div>',
                                ) !!}
                            @endif
                            <div class="p-2">
                                @if ($type === 'reverify')
                                    <form class="needs-validation" action="{{ route('login.reverifycode') }}"
                                        method="POST" novalidate>
                                    @else
                                        <form class="needs-validation" action="{{ route('login.resetcode') }}"
                                            method="POST" novalidate>
                                @endif
                                @csrf
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="mb-3">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" name="email" maxlength="255" class="form-control"
                                        id="email" placeholder="Enter email" required autofocus>
                                    <div class="invalid-feedback">
                                        Please Enter Email
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit"
                                        value="{{ $submit }}">{{ $submit }}</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Already have an account ? <a href="{{ route('login') }}" class="fw-medium text-primary">
                                Login</a> </p>
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>. Crafted with {{ strtoupper($title) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
</body>

</html>
