<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ strtoupper($title) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="DHARMAWIDYA" name="description" />
    <meta content="DHARMAWIDYA" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
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
    <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link href="{{ URL::asset('assets/form.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/loading.css') }}">
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>

</head>

<body data-sidebar="dark">
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

        $(".datepicker").change(function() {
            let tahun_masuk = document.getElementById("tahun_masuk").value;
            let tahun_lulus = document.getElementById("tahun_lulus").value;
            if (tahun_lulus < tahun_masuk && tahun_lulus != '') {
                Swal.fire(
                    'Gagal',
                    'Tahun masuk tidak boleh lebih besar dari tahun lulus',
                    'error'
                ).then(function() {
                    document.getElementById("submit").disabled = true;
                    document.getElementById("tahun_lulus").value = null;
                })
            } else {
                document.getElementById("submit").disabled = false;
            }
        });
    </script>
</body>

</html>
