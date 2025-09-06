@extends('layouts.admin.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card mb-2">

        <div class="card shadow-sm text-center border-0 bg-dark">
            <div class="row">
                <div class="col">
                    <div class="card-body">
                        <h5 class="card-title text-white">Tanggal Penilaian</h5>
                        <h6 class="text-danger fw-bold">
                            @if ($evaluationDates->isNotEmpty())
                                {{ Carbon::parse($evaluationDates->first()->start_date)->format('d M Y') }}
                                -
                                {{ Carbon::parse($evaluationDates->first()->end_date)->format('d M Y') }}
                            @else
                                Belum diisi
                            @endif
                        </h6>
                        @if ($evaluationDates->isNotEmpty())
                            <a href="#editDateModal" class="btn btn btn-outline-light" data-bs-toggle="modal"
                                data-bs-target="#editDateModal">
                                Edit Tanggal Penilaian
                            </a>
                        @else
                            <a href="#" class="btn btn btn-outline-light" data-bs-toggle="modal"
                                data-bs-target="#dateModal">
                                Buat Tanggal Penilaian
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal untuk mengisi tanggal penilaian -->
        <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dateModalLabel">
                            {{ $evaluations->isNotEmpty() ? 'Edit Tanggal Penilaian' : 'Buat Tanggal Penilaian' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin/evaluation.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit"
                                    class="btn btn-primary">{{ $evaluations->isNotEmpty() ? 'Simpan Perubahan' : 'Simpan' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Edit Tanggal Penilaian -->
        @if ($evaluationDates->isNotEmpty())
            <div class="modal fade" id="editDateModal" tabindex="-1" aria-labelledby="editDateModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDateModalLabel">Edit Tanggal Penilaian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin/evaluation.update', $evaluationDates->first()->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $evaluationDates->first()->start_date }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $evaluationDates->first()->end_date }}" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

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

        <h5 class="card-header p-0 mb-4">
            Penilaian Siswa <i class="display-5 bx bxs-chart"></i>
        </h5>
        <div class="d-flex justify-content-end">
            <span>
                <a href="{{ route('admin/evaluationExel') }}" class="btn btn-success mb-3">
                    <i class='bx bx-export'></i> Export to Excel</a>
            </span>
        </div>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">Nisn</th>
                        <th class="text-white">Nama Siswa</th>
                        <th class="text-white">Kelas</th>
                        <th class="text-white">Nama Guru Pembimbing</th>
                        <th class="text-white">Nama Perusahaan</th>
                        <th class="text-white">Nilai Monitoring</th>
                        <th class="text-white">Nilai Sertifikat</th>
                        <th class="text-white">Nilai Akhir</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($internships as $internship)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $internship->student->nisn }}</td>
                            <td>{{ $internship->student->nama }}</td>
                            <td>{{ $internship->student->mayor->nama }}</td>
                            <td>{{ $internship->teacher->nama }}</td>
                            <td>{{ $internship->corporation->nama }}</td>
                            <td>{{ $internship->assessment->count() }}/5</td>
                            <td>
                                @if ($internship->certificate)
                                    <span class="badge bg-label-success me-1">Sudah diberi Sertifikat</span>
                                @else
                                    <span class="badge bg-label-danger me-1">Belum diberi Sertifikat</span>
                                @endif
                            </td>
                            <td>
                                @if ($internship->evaluation)
                                    <span class="badge bg-label-success me-1">Sudah diberi Penilaian</span>
                                @else
                                    <span class="badge bg-label-danger me-1">Belum diberi Penilaian</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('admin/evaluation.show', $internship->id) }}">
                                    <i class="bx bx-show-alt me-1"></i>
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
