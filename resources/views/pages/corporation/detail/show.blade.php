@extends('layouts.corporation.main')

@section('content')
    {{-- <style>
        .custom-progress-bar {
            height: 10px;
        }
    </style> --}}

    <div class="row mb-4">
        <div class="col-md-4">
            <!-- Student Profile Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <img src="{{ asset('/storage/public/students-images/' . $internship->student->foto) }}"
                        class="rounded-circle mb-3" alt="{{ $internship->student->nama }}" width="120" height="120">
                    <h5 class="card-title">{{ $internship->student->nama }}</h5>
                    <p class="text-muted">{{ $internship->student->user->email }}</p>
                    <p class="badge bg-info text-white">{{ $internship->student->mayor->department->nama }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <!-- Student Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">Informasi Siswa</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Tanggal Mulai Magang:</span>
                            <span>{{ \Carbon\Carbon::parse($internship->tanggal_mulai)->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Tanggal Berakhir Magang:</span>
                            <span>{{ \Carbon\Carbon::parse($internship->tanggal_berakhir)->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Status Magang:</span>
                            <span class="badge bg-success">{{ $internship->status }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Instruktur:</span>
                            <span>{{ $internship->instructor->nama ?? 'Belum Ditugaskan' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Guru Pembimbing:</span>
                            <span>{{ $internship->teacher->nama ?? 'Belum Ditugaskan' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>No Hp Guru Pembimbing:</span>
                            <span>{{ $internship->teacher->hp ?? 'Belum Ditugaskan' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Attendance Summary -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success mb-4">
                    <h5 class="mb-0 text-white">Ringkasan Kehadiran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-primary">Hadir: {{ $summary['hadir'] }} hari</span>
                            <span class="badge bg-warning">Izin: {{ $summary['izin'] }} hari</span>
                            <span class="badge bg-warning">Sakit: {{ $summary['sakit'] }} hari</span>
                            <span class="badge bg-danger">Alpha: {{ $summary['alpha'] }} hari</span>
                        </div>
                        <div class="progress w-50 ms-3">
                            <div class="progress-bar bg-primary custom-progress-bar" role="progressbar"
                                style="width: {{ $summary['percentage'] ?? 0 }}%;"
                                aria-valuenow="{{ $summary['percentage'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $summary['percentage'] ?? 0 }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Logbook Summary -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info mb-4">
                    <h5 class="mb-0 text-white">Ringkasan Logbook</h5>
                </div>
                <div class="card-body">
                    @forelse ($logbooks as $logbook)
                        <div class="mb-3">
                            <h6 class="mb-1">{{ $logbook->judul }}</h6>
                            <small
                                class="text-muted">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</small>
                            <p class="mb-0">{{ Str::limit($logbook->bentuk_kegiatan, 100) }}</p>
                            <a href="{{ route('logbook.show', $logbook->id) }}"
                                class="btn btn-sm btn-outline-info mt-2">Lihat
                                Detail</a>
                        </div>
                        <hr>
                    @empty
                        <p class="text-muted">Belum ada logbook yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
