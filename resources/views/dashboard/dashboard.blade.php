@extends('layouts.main')
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboards</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">Menu</li>
                                <li class="breadcrumb-item active">Dashboards</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <?php
                                            $avatar = DB::table('karyawan')
                                                ->select('id', 'jabatan', 'foto')
                                                ->where('user_id', Auth::user()->id)
                                                ->get();
                                            ?>
                                            @if (count($avatar) > 0 and $avatar[0]->foto != null)
                                                <?php
                                                $jabatan = $avatar[0]->jabatan;
                                                $karyawan_id = $avatar[0]->id;
                                                ?>
                                                <img src="{{ Storage::url('karyawan/foto/' . $avatar[0]->foto) }}"
                                                    alt="" class="avatar-md rounded-circle img-thumbnail">
                                            @else
                                                <?php
                                                $jabatan = null;
                                                $karyawan_id = null;
                                                ?>
                                                <img src="{{ URL::asset('assets/images/users/avatar.png') }}"
                                                    alt="" class="avatar-md rounded-circle img-thumbnail">
                                            @endif
                                            <input type="hidden" id="roles" value="{{ Auth::user()->roles }}">
                                            <input type="hidden" id="jabatan" value="{{ $jabatan }}">
                                            <input type="hidden" id="karyawan_id" value="{{ $karyawan_id }}">
                                        </div>
                                        <div class="flex-grow-1 align-self-center">
                                            <div class="text-muted">
                                                <p class="mb-2">Welcome to Dashboard</p>
                                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                                <p class="mb-0">
                                                    {{ Auth::user()->roles }}
                                                    @if (count($avatar) > 0 and $avatar[0]->jabatan === 'Guru')
                                                        - {{ $avatar[0]->jabatan }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            {{-- <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Total Projects</p>
                                                    <h5 class="mb-0">48</h5>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Projects</p>
                                                    <h5 class="mb-0">40</h5>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Clients</p>
                                                    <h5 class="mb-0">18</h5>

                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="clearfix mt-4 mt-lg-0">
                                        <div class="dropdown float-end">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-light dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                        class="mdi mdi-wallet me-1"></i> <span
                                                        class="d-none d-sm-inline-block">Wallet Balance <i
                                                            class="mdi mdi-chevron-down"></i></span></button>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md"
                                                    style="">
                                                    <div class="dropdown-item-text">
                                                        <div>
                                                            <p class="text-muted mb-2">Available Balance</p>
                                                            <h5 class="mb-0">$ 9148.23</h5>
                                                        </div>
                                                    </div>

                                                    <div class="dropdown-divider"></div>

                                                    <a class="dropdown-item" href="#">
                                                        BTC : <span class="float-end">1.02356</span>
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        ETH : <span class="float-end">0.04121</span>
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        LTC : <span class="float-end">0.00356</span>
                                                    </a>

                                                    <div class="dropdown-divider"></div>

                                                    <a class="dropdown-item text-primary text-center" href="#">
                                                        Learn more
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-xl-4">
                    <div class="card bg-primary bg-soft">
                        <div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Skote Saas Dashboard</p>

                                        <ul class="ps-3 mb-0">
                                            <li class="py-1">7 + Layouts</li>
                                            <li class="py-1">Multiple apps</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-copy-alt"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Orders</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>1,452 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        <div class="d-flex">
                                            <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span
                                                class="ms-2 text-truncate">From previous period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-archive-in"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Revenue</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>$ 28,452 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                        <div class="d-flex">
                                            <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span
                                                class="ms-2 text-truncate">From previous period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span
                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                <i class="bx bx-purchase-tag-alt"></i>
                                            </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0">Average Price</h5>
                                    </div>
                                    <div class="text-muted mt-4">
                                        <h4>$ 16.2 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>

                                        <div class="d-flex">
                                            <span class="badge badge-soft-warning font-size-12"> 0% </span> <span
                                                class="ms-2 text-truncate">From previous period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div> --}}

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Order book</h4>
                            {{ $invoice }}
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Pembayaran</h4>

                            <div data-simplebar="init" style="max-height: 310px;">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper"
                                                style="height: auto; overflow: hidden scroll;">
                                                <div class="simplebar-content" style="padding: 0px;">
                                                    <ul class="verti-timeline list-unstyled">
                                                        @foreach ($invoice as $item)
                                                            <li class="event-list">
                                                                <div class="event-timeline-dot">
                                                                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="flex-shrink-0 me-3">
                                                                        <h5 class="font-size-14">
                                                                            {{ date('d F Y H:i:s', strtotime($item->created_at)) }}
                                                                            <i
                                                                                class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <div>
                                                                            {{ $item->bills->bills . ' (' . number_format($item->amount) . ')' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: auto; height: 481px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar"
                                        style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                    <div class="simplebar-scrollbar"
                                        style="height: 199px; transform: translate3d(0px, 0px, 0px); display: block;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- subscribeModal -->
    <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-light rounded-circle text-primary h1">
                                <i class="mdi mdi-progress-alert"></i>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 class="text-primary">Lengkapi Data !</h4>
                                <div class="text-danger message_alert" id="message_alert"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let jabatan = document.getElementById("jabatan").value;
            let karyawan_id = document.getElementById("karyawan_id").value;
            let roles = document.getElementById("roles").value;
            if (roles != 'Administrator'
                or roles != 'Admin') {
                $.ajax({
                    type: "POST",
                    url: '{{ route('employee.cek_ijazah') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        jabatan,
                        karyawan_id
                    },
                    success: response => {
                        if (response.code === 404 || response.code_kontak === 404) {
                            $('#subscribeModal').modal('show');
                            $("#message_alert").html(response.message);
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            }
        });
    </script>
@endsection
