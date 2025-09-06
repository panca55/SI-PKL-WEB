@extends('layouts.teacher.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card p-4 mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Siswa
        </div>
        <div class="card-body mt-2">
            <p class="card-text">Nama Peserta Didik : {{ $internship->student->nama }}</p>
            <p class="card-text">NISN : {{ $internship->student->nisn }}</p>
            <p class="card-text">Kelas : {{ $internship->student->mayor->nama }}</p>
            <p class="card-text">Program Keahlian : {{ $internship->student->mayor->department->nama }}</p>
            <p class="card-text">Konsentrasi :{{ $internship->student->konsentrasi }}</p>
            <p class="card-text">Tempat PKL : {{ $internship->corporation->nama }}</p>
            <p class="card-text">Tanggal PKL : Mulai: {{ Carbon::parse($internship->tanggal_mulai)->format('d F Y') }} /
                Selesai ;
                {{ Carbon::parse($internship->tanggal_berakhir)->format('d F Y') }} </p>
            <p class="card-text">Nama Instruktur : {{ $internship->instructor->nama }}</p>
            <p class="card-text">Nama Pembimbing : {{ $internship->teacher->nama }}</p>
        </div>
    </div>
    <div class="card p-4">
        <div class="text-nowrap">
            <table class="table text-center text-nowrap table-border-top-0">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">Judul Penilaian</th>
                        <th class="text-white">Tanggal Penilaian</th>
                        <th class="text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($assessments as $assessment)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $assessment->nama }}</td>
                            <td>{{ Carbon::parse($assessment->created_at)->format('d F Y') }}</td>
                            <td>
                                <a class="btn btn-success"
                                    href="{{ route('teacher/assessments.detail', $assessment->id) }}"><i
                                        class="bx bx-show-alt me-1"></i>
                                    Lihat Detail</a>
                                <a class="btn btn-success"
                                    href="{{ route('teacher/assessment.edit', $assessment->id) }}"><i
                                        class="bx bx-edit-alt me-1"></i>
                                    Edit</a>
                                <a class="btn btn-danger"
                                    href="{{ route('teacher/assessments.print', $assessment->id) }}"><i
                                        class="bx bx-printer me-1" target="_blank"></i>
                                    Print</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
