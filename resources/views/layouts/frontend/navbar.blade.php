<nav class="navbar navbar-expand-lg navbar-light bgnav">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/img/favicon/SMKN2.png') }}"
                style="max-width: 50px" alt=""></a>
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/img/favicon/SIGAPKL.png') }}"
                style="max-width: 50px" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link px-3 {{ Request::is('home') ? 'active' : '' }}" aria-current="page"
                    href="{{ route('home') }}">Home</a>
                <a class="nav-link px-3 {{ Request::is('mitra*') ? 'active' : '' }}" aria-current="page"
                    href="{{ route('mitra') }}">Mitra Sekolah</a>
                <a class="nav-link px-3 {{ Request::is('bursa-kerja*') ? 'active' : '' }}" aria-current="page"
                    href="{{ route('bursa-kerja') }}">Bursa Kerja</a>
                @auth
                    @php
                        $routes = [
                            'ADMIN' => 'admin/dashboard',
                            'SISWA' => 'student/dashboard',
                            'GURU' => 'teacher/dashboard',
                            'PERUSAHAAN' => 'corporation/dashboard.index',
                            'INSTRUKTUR' => 'instructor/dashboard',
                            'WAKAHUMAS' => 'admin/dashboard',
                            'WAKAKURIKULUM' => 'pimpinan/dashboard',
                            'KEPSEK' => 'pimpinan/dashboard',
                            'WAKASEK' => 'pimpinan/dashboard',
                            'DAPODIK' => 'pimpinan/dashboard',
                        ];

                        $role = Auth::user()->role;
                    @endphp

                    @if (array_key_exists($role, $routes))
                        <a class="nav-link px-3" href="{{ route($routes[$role]) }}">Dashboard</a>
                    @endif
                @endauth
            </div>
            <div class="ms-auto">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-outline-light rounded-5">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-outline-light rounded-5">Log In</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
