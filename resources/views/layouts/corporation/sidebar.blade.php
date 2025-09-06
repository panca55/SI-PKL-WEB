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
        @if (auth()->user()->role === 'PERUSAHAAN')
            <!-- Menu untuk Perusahaan -->
            <li class="menu-item {{ Request::is('corporation/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('corporation/dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('corporation/profile*') ? 'active' : '' }}">
                <a href="{{ route('corporation/profile.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Profile</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('corporation/bursa*') ? 'active' : '' }}">
                <a href="{{ route('corporation/bursa.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-detail"></i>
                    <div data-i18n="Analytics">Bursa Kerja</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('corporation/siswa*') ? 'active' : '' }}">
                <a href="{{ route('corporation/siswa.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-circle"></i>
                    <div data-i18n="Analytics">Siswa Yang Sudah PKL</div>
                </a>
            </li>
        @elseif(auth()->user()->role === 'INSTRUKTUR')
            <!-- Menu untuk Instruktur -->
            <li class="menu-item {{ Request::is('instructor/dashboard*') ? 'active' : '' }}">
                <a href="{{ route('instructor/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('instructor/profile*') ? 'active' : '' }}">
                <a href="{{ route('instructor/profile.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Profile</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('instructor/bimbingan*') ? 'active' : '' }}">
                <a href="{{ route('instructor/bimbingan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-notepad"></i>
                    <div data-i18n="Analytics">Bimbingan Siswa</div>
                </a>
            </li>

            <li class="menu-item {{ Request::is('instructor/sertifikat*') ? 'active' : '' }}">
                <a href="{{ route('instructor/sertifikat.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-credit-card-front"></i>
                    <div data-i18n="Analytics">Sertifikat Siswa</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
