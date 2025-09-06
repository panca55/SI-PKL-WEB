@extends('layouts.admin.main')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="card p-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h5 class="card-header p-0 mb-4 d-flex justify-content-between align-items-center">
            <span>Data Absensi Siswa</span>
            <a href="#" class="text-decoration-none">
            </a>
        </h5>
        <div class="card-body">
            <form action="{{ route('admin/exportAbsent') }}" method="GET"
                class="d-flex flex-column flex-md-row align-items-center gap-3">
                <div class="input-group">
                    <!-- Dropdown untuk bulan dengan ikon -->
                    <span class="input-group-text bg-light">
                        <i class='bx bx-calendar'></i>
                    </span>
                    <select name="month" class="form-select" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Pilih Bulan">
                        @foreach ($months as $key => $month)
                            <option value="{{ $key }}" {{ Carbon::now()->month == $key ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group">
                    <!-- Dropdown untuk tahun dengan ikon -->
                    <span class="input-group-text bg-light">
                        <i class='bx bx-calendar-alt'></i>
                    </span>
                    <select name="year" class="form-select" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Pilih Tahun">
                        @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                            <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Tombol Export yang lebih interaktif -->
                <button type="submit" class="btn btn-danger d-flex align-items-center gap-2" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Export">
                    <i class='bx bx-export'></i> Export
                </button>
            </form>
        </div>


        <div class="table-responsive table-bordered text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">NISN</th>
                        <th class="text-white">Nama Siswa</th>
                        <th class="text-white">Hadir</th>
                        <th class="text-white">Izin</th>
                        <th class="text-white">Sakit</th>
                        <th class="text-white">Alpha</th>
                        <th class="text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($internships as $internship)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $internship->student->nisn }}</td>
                            <td>{{ $internship->student->nama }}</td>
                            <td>{{ $internship->absents->where('keterangan', 'HADIR')->count() ?? 0 }}</td>
                            <td>{{ $internship->absents->where('keterangan', 'IZIN')->count() ?? 0 }}</td>
                            <td>{{ $internship->absents->where('keterangan', 'SAKIT')->count() ?? 0 }}</td>
                            <td>{{ $internship->absents->where('keterangan', 'ALPHA')->count() ?? 0 }}</td>
                            <td>{{ $internship->absents->count() ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Inisialisasi tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
