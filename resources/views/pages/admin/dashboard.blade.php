@extends('layouts.admin.main')

@section('content')
    <div class="card p-4 container-fluid p-4">
        <!-- Welcome Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="welcome-text mb-0">Selamat datang, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Total Users Card -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-opacity-10 p-2 rounded-circle me-3">
                                <a href="{{ route('admin/user.index') }}">
                                    <i class="bx bx-user fs-4 text-primary"></i>
                                </a>
                            </div>
                            <span class="text-muted fw-medium">Total Users</span>
                        </div>
                        <h3 class="card-title mb-0">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Students Card -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-opacity-10 p-2 rounded-circle me-3">
                                <a href="{{ route('admin/student.index') }}">
                                    <i class="bx bx-user-pin fs-4 text-success"></i>
                                </a>
                            </div>
                            <span class="text-muted fw-medium">Total Siswa</span>
                        </div>
                        <h3 class="card-title mb-0">{{ $totalStudents }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Corporations Card -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-opacity-10 p-2 rounded-circle me-3">
                                <a href="{{ route('admin/corporation.index') }}">
                                    <i class="bx bxs-school fs-4 text-warning"></i>
                                </a>
                            </div>
                            <span class="text-muted fw-medium">Total Perusahaan</span>
                        </div>
                        <h3 class="card-title mb-0">{{ $totalCorporations }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Teachers Card -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-opacity-10 p-2 rounded-circle me-3">
                                <a href="{{ route('admin/teacher.index') }}">
                                    <i class="bx bxs-graduation fs-4 text-info"></i>
                                </a>
                            </div>
                            <span class="text-muted fw-medium">Total Guru</span>
                        </div>
                        <h3 class="card-title mb-0">{{ $totalTeachers }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Statistics Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div
                        class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0">Statistik Siswa</h5>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                id="growthReportId" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $tahun_masuk }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="growthReportId">
                                @foreach ($tahun_masuk_list as $tahun)
                                    <li><a class="dropdown-item" href="#"
                                            onclick="updateYear('{{ $tahun }}')">{{ $tahun }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4 text-center mb-4 mb-lg-0">
                                <h2 class="mb-2">{{ $studentYears }}</h2>
                                <span class="text-muted">Total Siswa</span>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div style="height: 300px;">
                                    <canvas id="studentChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('studentChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['PRIA', 'WANITA'],
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: [
                            {{ $students->where('jenis_kelamin', 'PRIA')->first()->total ?? 0 }},
                            {{ $students->where('jenis_kelamin', 'WANITA')->first()->total ?? 0 }}
                        ],
                        backgroundColor: ['#4e73df', '#e83e8c'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });

        function updateYear(tahun) {
            var url = new URL(window.location.href);
            url.searchParams.set('tahun_masuk', tahun);
            window.location.href = url.toString();
        }
    </script>

    <style>
        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .avatar {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-text {
            font-size: 1.1rem;
            color: #6c757d;
        }
    </style>
@endsection
