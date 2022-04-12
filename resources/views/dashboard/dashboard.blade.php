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
                                                ->select('foto')
                                                ->where('user_id', Auth::user()->id)
                                                ->get();
                                            ?>
                                            @if (count($avatar) > 0 and $avatar[0]->foto != null)
                                                <img src="{{ Storage::url('karyawan/foto/' . $avatar[0]->foto) }}" alt=""
                                                    class="avatar-md rounded-circle img-thumbnail">
                                            @else
                                                <img src="{{ URL::asset('assets/images/users/avatar.png') }}" alt=""
                                                    class="avatar-md rounded-circle img-thumbnail">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 align-self-center">
                                            <div class="text-muted">
                                                <p class="mb-2">Welcome to Dashboard</p>
                                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                                <p class="mb-0">{{ Auth::user()->roles }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-4 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-4">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="clearfix mt-4 mt-lg-0">
                                        <div class="dropdown float-end">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bxs-cog align-middle me-1"></i> Setting
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
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
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-end">
                                    <div class="input-group input-group-sm">
                                        <select class="form-select form-select-sm">
                                            <option value="JA" selected>Jan</option>
                                            <option value="DE">Dec</option>
                                            <option value="NO">Nov</option>
                                            <option value="OC">Oct</option>
                                        </select>
                                        <label class="input-group-text">Month</label>
                                    </div>
                                </div>
                                <h4 class="card-title mb-4">Earning</h4>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="text-muted">
                                        <div class="mb-4">
                                            <p>This month</p>
                                            <h4>$2453.35</h4>
                                            <div><span class="badge badge-soft-success font-size-12 me-1"> + 0.2% </span>
                                                From previous period</div>
                                        </div>

                                        <div>
                                            <a href="javascript: void(0);"
                                                class="btn btn-primary waves-effect waves-light btn-sm">View Details <i
                                                    class="mdi mdi-chevron-right ms-1"></i></a>
                                        </div>

                                        <div class="mt-4">
                                            <p class="mb-2">Last month</p>
                                            <h5>$2281.04</h5>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div id="line-chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Sales Analytics</h4>

                            <div>
                                <div id="donut-chart" class="apex-charts"></div>
                            </div>

                            <div class="text-center text-muted">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mt-4">
                                            <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i>
                                                Product A</p>
                                            <h5>$ 2,132</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-4">
                                            <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success me-1"></i>
                                                Product B</p>
                                            <h5>$ 1,763</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-4">
                                            <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i>
                                                Product C</p>
                                            <h5>$ 973</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
