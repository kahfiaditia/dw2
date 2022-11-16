<div class="navbar-header">
    <div class="d-flex">
        <div class="navbar-brand-box">
            <a href="{{ route('dashboard') }}"
                class="{{ Auth::user()->menu_tema == 'light' ? 'logo logo-dark' : 'logo logo-light' }}">
                <span class="logo-sm">
                    <img src="{{ URL::asset('assets/images/logo/icon.png') }}" alt="" height="25">
                </span>
                <span class="logo-lg">
                    <img src="{{ URL::asset('assets/images/logo/sid.png') }}" alt="" height="40">
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
            <form method="GET" action="{{ route('akun.profile', Crypt::encryptString(Auth::user()->id)) }}">
                @csrf
                <button class="btn header-item waves-effect">
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
                </button>
            </form>
            {{-- <div class="dropdown-menu dropdown-menu-end">
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
            </div> --}}
        </div>
        <div class="">
            <form method="POST" action="{{ route('login.logout') }}">
                @csrf
                <button class="btn header-item noti-icon waves-effect logout_confirm">
                    <i class="mdi mdi-logout text-danger"></i>
                </button>
            </form>
        </div>
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                <i class="bx bx-cog bx-spin"></i>
            </button>
        </div>
    </div>
</div>
<script>
    $('.logout_confirm').on('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Keluar Aplikasi',
            text: 'Ingin keluar aplikasi?',
            icon: 'question',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: "Batal",
            focusConfirm: false,
        }).then((value) => {
            if (value.isConfirmed) {
                $(this).closest("form").submit()
            }
        });
    });
</script>
