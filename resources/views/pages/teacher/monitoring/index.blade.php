@extends('layouts.teacher.main')

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
        <h5 class="card-header">Penilaian Monitoring
            <span>
                <i class='display-5 bx bx-message-add'></i>
            </span>
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table table-striped">
                <thead>
                    <tr class="bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">Nama Siswa</th>
                        <th class="text-white">Jurusan</th>
                        <th class="text-white">kelas</th>
                        <th class="text-white">Nama Perusahaan</th>
                        <th class="text-white">Nama Instruktur</th>
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
                            <td>{{ $internship->instructor->nama ?? 'Belum diisi' }}</td>
                            <td>{{ $internship->assessment->count() }}/5</td>
                            <td>
                                @if ($internship->assessment->count() >= 5)
                                    <a class="btn btn-success"
                                        href="{{ route('teacher/assessment.show', $internship->id) }}">
                                        <i class="bx bx-show me-1"></i> Lihat</a>
                                @else
                                    <a class="btn btn-primary"
                                        href="{{ route('teacher/createAssessment', $internship->id) }}">
                                        <i class="bx bx-plus me-1"></i> Tambah</a>
                                    <a class="btn btn-success"
                                        href="{{ route('teacher/assessment.show', $internship->id) }}">
                                        <i class="bx bx-show me-1"></i> Lihat</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
