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
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link href="{{ URL::asset('assets/form.css') }}" rel="stylesheet" type="text/css" />
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
                                        <h5 class="text-primary">Free Register</h5>
                                        <p>Get your free DHARMAWIDYA account now.</p>
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
                            @if ($errors->any())
                                {!! $errors->first('email', '<div class="p-2"><div class="alert alert-danger" role="alert">:message</div></div>') !!}
                            @endif
                            <div class="p-2">
                                <form class="needs-validation" action="{{ route('login.store') }}" method="POST"
                                    novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email</label>
                                        <input type="email" name="email" maxlength="255" class="form-control"
                                            id="email" placeholder="Enter email" required autofocus>
                                        <div class="invalid-feedback">
                                            Please Enter Email
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="name" maxlength="255" class="form-control"
                                            id="name" placeholder="Enter username" required>
                                        <div class="invalid-feedback">
                                            Please Enter Username
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">Password</label>
                                        <input type="password" name="password" minlength="5" maxlength="255"
                                            class="form-control" id="userpassword" placeholder="Enter password"
                                            required>
                                        <div class="invalid-feedback">
                                            Please Enter Password and It should have 5 characters or more.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Roles</label>
                                        <select class="form-control select select2" name="roles" id="roles"
                                            required>
                                            <option value="">--Pilih Roles--</option>
                                            <option value="Karyawan">Karyawan</option>
                                            <option value="Alumni">Alumni</option>
                                            <option value="Ortu">Orang Tua</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please Enter Roles
                                        </div>
                                    </div>
                                    <div class="mb-4" id="divtahun" style="display:none">
                                        <label>Tahun Lulus</label>
                                        <div class="input-daterange input-group">
                                            <input type="text" class="form-control datepicker" name="tahun_lulus"
                                                maxlength="4" placeholder="Tahun Lulus" id="tahun_lulus" required>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light"
                                            type="submit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <div>
                            <p>Already have an account ? <a href="{{ route('login') }}"
                                    class="fw-medium text-primary"> Login</a> </p>
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
    </div>
</body>

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
        });

        $('#roles').bind('change', function() {
            let roles = document.getElementById("roles").value;
            if (roles === 'Alumni') {
                document.getElementById("tahun_lulus").required = true;
                document.getElementById("divtahun").style.display = 'block';
            } else {
                document.getElementById("tahun_lulus").required = false;
                document.getElementById("divtahun").style.display = 'none';
            }
        });
    });
</script>

</html>
