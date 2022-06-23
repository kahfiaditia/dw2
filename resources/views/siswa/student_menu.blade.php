<div class="col-xl-2 col-sm-3" <?php echo $device; ?>>
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a href="{{ route('siswa.edit', $student->id) }}"
            class="nav-link @if ($submenu == 'siswa') active @endif">
            <i class="bx bx-user d-block check-nav-icon mt-2"></i>
            <p class="fw-bold mb-4">Data Pribadi</p>
        </a>
        <a class="nav-link @if ($submenu == 'orang tua') active @endif"
            href="{{ route('siswa.show_parents', $student->id) }}">
            <i class="bx bx-group d-block check-nav-icon mt-2"></i>
            {{-- <i class="bx bx-book-content d-block check-nav-icon mt-2"></i> --}}
            <p class="fw-bold mb-4">Orang Tua / Wali</p>
        </a>
        <a href="{{ route('siswa.show_periodic', $student->id) }}"
            class="nav-link @if ($submenu == 'priodik') active @endif">
            <i class="bx bx-user d-block check-nav-icon mt-2"></i>
            <p class="fw-bold mb-4">Data Priodik</p>
        </a>
        <a href="{{ route('siswa.list_performance_students', $student->id) }}"
            class="
            nav-link @if ($submenu == 'prestasi') active @endif">
            <i class="bx bx-chart d-block check-nav-icon mt-2"></i>
            <p class="fw-bold mb-4">Prestasi</p>
        </a>
        <a href="{{ route('siswa.index_beasiswa_student', $student->id) }}"
            class="nav-link @if ($submenu == 'beasiswa') active @endif">
            <i class="bx bx-star check-nav-icon mt-2"></i>
            <p class="fw-bold mb-4">Beasiswa</p>
        </a>
        <a href="{{ route('siswa.index_kesejahteraan_siswa', $student->id) }}"
            class="nav-link @if ($submenu == 'kesejahteraan') active @endif">
            <i class="bx bx-plus-medical check-nav-icon mt-2"></i>
            <p class="fw-bold mb-4">Kesejahteraan Siswa</p>
        </a>
    </div>
</div>
