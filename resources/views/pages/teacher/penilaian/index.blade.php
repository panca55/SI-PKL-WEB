@extends('layouts.teacher.main')
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
        @if ($periode)
            <h3 class="card header text-center p-2">Periode Penilaian <br>
                {{ Carbon::parse($periode->start_date)->format('d F Y') }}
                -
                {{ Carbon::parse($periode->end_date)->format('d F Y') }}
            </h3>
        @endif
        <h5 class="card-header">Penilaian Akhir Siswa</h5>

        <div class="table-responsive text-nowrap">
            <table id="example" class="table table-striped">
                <thead>
                    <tr class="bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">Nama Siswa</th>
                        <th class="text-white">Jurusan</th>
                        <th class="text-white">Kelas</th>
                        <th class="text-white">Nama Perusahaan</th>
                        <th class="text-white">Penilaian</th>
                        <th class="text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($internships as $internship)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $internship->student->nama }}</td>
                            <td>{{ $internship->student->mayor->department->nama }}</td>
                            <td>{{ $internship->student->mayor->nama }}</td>
                            <td>{{ $internship->corporation->nama }}</td>
                            <!-- Cek apakah penilaian sudah ada -->
                            <td>
                                @if ($internship->evaluation)
                                    Sudah Dinilai
                                @else
                                    Belum Diberi Nilai
                                @endif
                            </td>

                            <!-- Button Lihat/Edit -->
                            <td>
                                @if (empty($internship->evaluation))
                                    <a class="btn btn-warning"
                                        href="{{ route('teacher/createEvaluation', $internship->id) }}">
                                        <i class="bx bx-plus me-1"></i> Beri Penilaian
                                    </a>
                                @else
                                    <a class="btn btn-success"
                                        href="{{ route('teacher/evaluation.show', $internship->evaluation->id) }}">
                                        <i class="bx bx-show me-1"></i> Lihat
                                    </a>
                                    <a class="btn btn-warning"
                                        href="{{ route('teacher/evaluation.edit', $internship->evaluation->id) }}">
                                        <i class="bx bx-edit me-1"></i> Edit
                                    </a>
                                    <a class="btn btn-danger"
                                        href="{{ route('teacher/evaluation.print', $internship->evaluation->id) }}"><i
                                            class="bx bx-printer me-1"></i>
                                        Print</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
