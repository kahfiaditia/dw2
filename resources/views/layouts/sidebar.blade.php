<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">Menu</li>
        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect">
                <i class="bx bxs-dashboard"></i>
                {{-- <span class="badge rounded-pill bg-info float-end">04</span> --}}
                <span key="t-dashboards">Dashboards</span>
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-group"></i>
                <span key="t-tables">Data</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('employee') }}" key="t-basic-tables">Karyawan</a></li>
                <li><a href="#" key="t-data-tables">Siswa</a></li>
            </ul>
        </li>
        <li class="menu-title" key="t-setting">Setting</li>
        <li>
            <a href="{{ route('agama') }}" class="waves-effect">
                <i class="bx bx-list-ul"></i>
                <span key="t-calendar">Agama</span>
            </a>
        </li>
        <li>
            <a href="{{ route('kodepos') }}" class="waves-effect">
                <i class="bx bx-list-ul"></i>
                <span key="t-calendar">Kodepos</span>
            </a>
        </li>
    </ul>
</div>
