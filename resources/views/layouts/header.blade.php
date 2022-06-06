<div class="navbar-header">
    <div class="d-flex">
        <div class="navbar-brand-box">
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ URL::asset('assets/images/logo.svg') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
                </span>
            </a>
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    {{-- <img src="{{ URL::asset('assets/images/logo-light.svg') }}" alt="" height="22"> --}}
                    <img src="{{ URL::asset('assets/images/logo-sid.svg') }}" alt="" height="52">
                </span>
                <span class="logo-lg">
                    {{-- <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="19"> --}}
                    <img src="{{ URL::asset('assets/images/logo-sid.png') }}" alt="" height="40">
                </span>
            </a>
        </div>
        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
            <i class="fa fa-fw fa-bars"></i>
        </button>
    </div>
    <div class="d-flex">
        <div class="dropdown d-none d-lg-inline-block ms-1">
            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                <i class="bx bx-fullscreen"></i>
            </button>
        </div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                $avatar = DB::table('karyawan')
                    ->select('foto')
                    ->where('user_id', Auth::user()->id)
                    ->get();
                ?>
                @if (count($avatar) > 0 and $avatar[0]->foto != null)
                    <img class="rounded-circle header-profile-user"
                        src="{{ Storage::url('karyawan/foto/' . $avatar[0]->foto) }}" alt="Header Avatar">
                @else
                    <img class="rounded-circle header-profile-user"
                        src="{{ URL::asset('assets/images/users/avatar.png') }}" alt="Header Avatar">
                @endif
                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->name }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('akun.edit', Crypt::encryptString(Auth::user()->id)) }}"><i
                        class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Akun</span></a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('login.logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        <span key="t-logout">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
