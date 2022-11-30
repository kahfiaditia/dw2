<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ strtoupper($title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="DHARMAWIDYA" name="description" />
    <meta content="DHARMAWIDYA" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo/icon.png') }}">
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link href="{{ URL::asset('assets/form.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/loading.css') }}">
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>

</head>

<?php preg_match('/(chrome|firefox|avantgo|blackberry|android|blazer|elaine|hiptop|iphone|ipod|kindle|midp|mmp|mobile|o2|opera mini|palm|palm os|pda|plucker|pocket|psp|smartphone|symbian|treo|up.browser|up.link|vodafone|wap|windows ce; iemobile|windows ce; ppc;|windows ce; smartphone;|xiino)/i', $_SERVER['HTTP_USER_AGENT'], $version); ?>
@if ($version[1] == 'Android' || $version[1] == 'Mobile' || $version[1] == 'iPhone')

    <body data-sidebar="{{ Auth::user()->menu_tema == 'light' ? 'light' : 'dark' }}">
    @else

        <body data-sidebar="{{ Auth::user()->menu_tema == 'light' ? 'light' : 'dark' }}"
            class="{{ Auth::user()->menu_icon == 'text' ? '' : 'sidebar-enable vertical-collpsed' }}">
@endif

{{-- loading --}}
<div id="loader"></div>

@include('sweetalert::alert')
<div id="layout-wrapper">
    <header id="page-topbar">
        @include('layouts.header')
    </header>
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            @include('layouts.sidebar')
        </div>
    </div>
    <div class="main-content">
        @yield('container')
        @include('layouts.footer')
    </div>
</div>

<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            <h5 class="m-0 me-2">Pengaturan</h5>
            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>
        <hr class="mt-0" />
        <h6 class="text-center mb-0">Pilih Tampilan</h6>
        <div class="p-4">
            <div class="mb-3">
                <label class="d-block mb-3">Tema Menu :</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input radio menu_sidebar" type="radio" name="thema" id="thema1"
                        value="dark" <?php if (Auth::user()->menu_tema == 'dark' or Auth::user()->menu_tema == null) {
                            echo 'checked';
                        } ?>>
                    <label class="form-check-label" for="thema1">Dark</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input radio" type="radio" name="thema" id="thema2" value="light"
                        {{ Auth::user()->menu_tema == 'light' ? 'checked' : '' }}>
                    <label class="form-check-label" for="thema2">Light</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="d-block mb-3">Menu :</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input radio" type="radio" name="menu" id="menu1" value="icon"
                        <?php if (Auth::user()->menu_icon == 'icon' or Auth::user()->menu_icon == '') {
                            echo 'checked';
                        } ?>>
                    <label class="form-check-label" for="menu1">Icon</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input radio" type="radio" name="menu" id="menu2"
                        value="text" {{ Auth::user()->menu_icon == 'text' ? 'checked' : '' }}>
                    <label class="form-check-label" for="menu2">Icon & Text</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/numeral.js') }}"></script>
<script src="{{ asset('assets/libs/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-mask.init.js') }}"></script>

{{-- loading --}}
<script type="text/javascript">
    var $loading = $('#loader').hide();
    $(document)
        .ajaxStart(function() {
            $loading.show();
        })
        .ajaxStop(function() {
            $loading.hide();
        });

    $('.number-only').on('keydown keyup', function(e) {
        let value = $(this).val().replace(/[^0-9.]/g, "");
        $(this).val(value);
    });

    function setMoney(num) {
        return numeral(num).format('0,0');
    }

    function unMoney(num) {
        return numeral(num).value();
    };

    // Pop up for delete confirm
    $('.delete_confirm').on('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Data',
            text: 'Ingin menghapus data?',
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Batal",
            focusConfirm: false,
        }).then((value) => {
            console.log($(this).closest('form'))
            if (value.isConfirmed) {
                $(this).closest("form").submit()
            }
        });
    });

    $(".datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
    });

    $(document).ready(function() {
        document.getElementById('thema1').addEventListener('click', function() {
            button = document.getElementById('thema1').value;
            rubah_sidebar(button)
            $loading.show();
        });
        document.getElementById('thema2').addEventListener('click', function() {
            button = document.getElementById('thema2').value;
            rubah_sidebar(button)
            $loading.show();
        });
        document.getElementById('menu1').addEventListener('click', function() {
            button = document.getElementById('menu1').value;
            rubah_sidebar(button)
            $loading.show();
        });
        document.getElementById('menu2').addEventListener('click', function() {
            button = document.getElementById('menu2').value;
            rubah_sidebar(button)
            $loading.show();
        });

        function rubah_sidebar(button) {
            $.ajax({
                type: "POST",
                url: '{{ route('dashboard.tema') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    button,
                },
                success: response => {
                    if (response.code == 200) {

                        location.reload();
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            showConfirmButton: false,
                            timer: 1500,
                            willClose: () => {
                                location.reload();
                            }
                        })
                    }
                    $loading.hide();
                },
                error: (err) => {
                    console.log(err);
                },
            });
        }
    });
</script>
</body>

</html>
