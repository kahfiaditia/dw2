@extends('layouts.main')
@section('container')
    <?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
    <div class="page-content">
        <div class="container-fluid">
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
            <div id="app">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <header-component></header-component>
                                    <contact-component></contact-component>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pusher -->
    <script src="/js/app.js"></script>
@endsection
