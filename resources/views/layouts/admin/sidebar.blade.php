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
        <!-- Dashboard Admin -->
        @if (auth()->user()->role === 'ADMIN')
            <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- User -->
            <li class="menu-item {{ Request::is('admin/user*') ? 'active' : '' }}">
                <a href="{{ route('admin/user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">User</div>
                </a>
            </li>

            <!-- Siswa -->
            <li class="menu-item {{ Request::is('admin/student*') ? 'active' : '' }}">
                <a href="{{ route('admin/student.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Siswa</div>
                </a>
            </li>

            <!-- Guru -->
            <li class="menu-item {{ Request::is('admin/teacher*') ? 'active' : '' }}">
                <a href="{{ route('admin/teacher.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-graduation'></i>
                    <div data-i18n="Analytics">Guru</div>
                </a>
            </li>

            <!-- Mitra Sekolah -->
            <li class="menu-item {{ Request::is('admin/corporation*') ? 'active' : '' }}">
                <a href="{{ route('admin/corporation.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-school"></i>
                    <div data-i18n="Analytics">Mitra Sekolah</div>
                </a>
            </li>

            <!-- Instruktur -->
            <li class="menu-item {{ Request::is('admin/instructor*') ? 'active' : '' }}">
                <a href="{{ route('admin/instructor.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Instruktur</div>
                </a>
            </li>

            <!-- Jurusan -->
            <li class="menu-item {{ Request::is('admin/department*') ? 'active' : '' }}">
                <a href="{{ route('admin/department.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-book"></i>
                    <div data-i18n="Analytics">Jurusan</div>
                </a>
            </li>

            <!-- Kelazzz -->
            <li class="menu-item {{ Request::is('admin/mayor*') ? 'active' : '' }}">
                <a href="{{ route('admin/mayor.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-backpack"></i>
                    <div data-i18n="Analytics">Kelas</div>
                </a>
            </li>

            {{-- <!-- PKL -->
            <li class="menu-item {{ Request::is('admin/internship*') ? 'active' : '' }}">
                <a href="{{ route('admin/internship.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-briefcase-alt-2"></i>
                    <div data-i18n="Analytics">PKL</div>
                </a>
            </li>

            <!-- Nilai -->
            <li class="menu-item {{ Request::is('admin/evaluation*') ? 'active' : '' }}">
                <a href="{{ route('admin/evaluation.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-chart"></i>
                    <div data-i18n="Analytics">Penilaian</div>
                </a>
            </li> --}}

            <!-- Informasi -->
            <li class="menu-item {{ Request::is('admin/information*') ? 'active' : '' }}">
                <a href="{{ route('admin/information.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-notepad"></i>
                    <div data-i18n="Analytics">Informasi</div>
                </a>
            </li>
        @elseif (auth()->user()->role === 'WAKAHUMAS')
            <!-- Dashboard -->
            <li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin/dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <!-- Siswa -->
            <li class="menu-item {{ Request::is('admin/student*') ? 'active' : '' }}">
                <a href="{{ route('admin/student.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Siswa</div>
                </a>
            </li>

            <!-- Guru -->
            <li class="menu-item {{ Request::is('admin/teacher*') ? 'active' : '' }}">
                <a href="{{ route('admin/teacher.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-graduation'></i>
                    <div data-i18n="Analytics">Guru</div>
                </a>
            </li>

            <!-- Mitra Sekolah -->
            <li class="menu-item {{ Request::is('admin/corporation*') ? 'active' : '' }}">
                <a href="{{ route('admin/corporation.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-school"></i>
                    <div data-i18n="Analytics">Mitra Sekolah</div>
                </a>
            </li>

            <!-- Instruktur -->
            <li class="menu-item {{ Request::is('admin/instructor*') ? 'active' : '' }}">
                <a href="{{ route('admin/instructor.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user"></i>
                    <div data-i18n="Analytics">Instruktur</div>
                </a>
            </li>

            <!-- PKL -->
            <li class="menu-item {{ Request::is('admin/internship*') ? 'active' : '' }}">
                <a href="{{ route('admin/internship.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-briefcase-alt-2"></i>
                    <div data-i18n="Analytics">PKL</div>
                </a>
            </li>

            <!-- Nilai -->
            <li class="menu-item {{ Request::is('admin/evaluation*') ? 'active' : '' }}">
                <a href="{{ route('admin/evaluation.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-chart"></i>
                    <div data-i18n="Analytics">Penilaian</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
