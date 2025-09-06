<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo py-4">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/favicon/SMKN2.png') }}" width="50" alt="App Logo">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('app.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @if (auth()->user()->role === 'GURU')
            <!-- Dashboard Guru -->
            <li class="menu-item {{ Request::is('teacher/dashboard') ? 'active' : '' }}">
                <a href="{{ route('teacher/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Profile Guru-->
            <li class="menu-item {{ Request::is('teacher/profile*') ? 'active' : '' }}">
                <a href="{{ route('teacher/profile.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Profile</div>
                </a>
            </li>

            <!-- Bimbingan Siswa-->
            <li class="menu-item {{ Request::is('teacher/bimbingan*') ? 'active' : '' }}">
                <a href="{{ route('teacher/bimbingan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-notepad"></i>
                    <div data-i18n="Analytics">Bimbingan Siswa</div>
                </a>
            </li>

            <!-- Monitoring Siswa-->
            <li class="menu-item {{ Request::is('teacher/assessment*') ? 'active' : '' }}">
                <a href="{{ route('teacher/assessment.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-task"></i>
                    <div data-i18n="Analytics">Penilaian Monitoring Siswa</div>
                </a>
            </li>

            <!-- Nilai Akhir Siswa-->
            <li class="menu-item {{ Request::is('teacher/evaluation*') ? 'active' : '' }}">
                <a href="{{ route('teacher/evaluation.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-check-square'></i>
                    <div data-i18n="Analytics">Penilaian Akhir Siswa</div>
                </a>
            </li>
        @elseif (in_array(auth()->user()->role, ['KEPSEK', 'WAKASEK', 'WAKAKURIKULUM', 'DAPODIK']))
            <li class="menu-item {{ Request::is('pimpinan/dashboard') ? 'active' : '' }}">
                <a href="{{ route('pimpinan/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('pimpinan/siswaPkl') ? 'active' : '' }}">
                <a href="{{ route('pimpinan/siswaPkl') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-notepad"></i>
                    <div data-i18n="Analytics">Siswa PKL</div>
                </a>
            </li>
            {{-- <li class="menu-item {{ Request::is('pimpinan/siswa') ? 'active' : '' }}">
                <a href="{{ route('pimpinan/siswa') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Siswa Yang Sudah PKL</div>
                </a>
            </li> --}}
        @endif
    </ul>
</aside>
