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
        <!-- Dashboard Siswa -->
        <li class="menu-item {{ Request::is('student/dashboard') ? 'active' : '' }}">
            <a href="{{ route('student/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-home"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Profile Siswa-->
        <li class="menu-item {{ Request::is('student/profile*') ? 'active' : '' }}">
            <a href="{{ route('student/profile.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user"></i>
                <div data-i18n="Analytics">Profile</div>
            </a>
        </li>
        <!-- Magang Siswa-->
        <li class="menu-item {{ Request::is('student/internship*') ? 'active' : '' }}">
            <a href="{{ route('student/internship.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-briefcase-alt-2"></i>
                <div data-i18n="Analytics">PKL</div>
            </a>
        </li>

        <!-- Magang Siswa-->
        <li class="menu-item {{ Request::is('student/logbook*') ? 'active' : '' }}">
            <a href="{{ route('student/logbook.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-book-content"></i>
                <div data-i18n="Analytics">Historis Logbook</div>
            </a>
        </li>
        <!-- Penilaian Siswa -->
        <li class="menu-item {{ Request::is('student/evaluation*') ? 'active' : '' }}">
            <a href="{{ route('student/evaluation.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Penilaian dan Sertifikat</div>
            </a>
        </li>

    </ul>
</aside>
