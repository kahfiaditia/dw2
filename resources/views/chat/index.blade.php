@extends('layouts.main')
@section('container')
    <?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Chat</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">SID</li>
                                <li class="breadcrumb-item">Chat</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="" id="app">

                <example-component></example-component>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // document.getElementById('last').scrollIntoView({
            //     // behavior: 'auto', // otomatis langsung ke bawah chat
            //     behavior: 'smooth', // ada animasi untuk ke bawah chat
            //     block: 'end',
            // });
        });
    </script>
@endsection
