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
        <h5 class="card-header p-0 mb-4">
            Data PKL
            {{-- <div class="d-flex justify-content-end">
                <span>
                    <a href="{{ route('admin/exportExcel') }}" class="btn btn-success mb-3">
                        <i class='bx bx-export'></i> Export to Excel</a>
                </span>
            </div> --}}
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">NISN</th>
                        <th class="text-white">Jurusan</th>
                        <th class="text-white">Kelas</th>
                        <th class="text-white">Nama Siswa</th>
                        <th class="text-white">Nama Guru Pembimbing</th>
                        <th class="text-white">Nama Perusahaan</th>
                        <th class="text-white">Tahun Ajaran</th>
                        <th class="text-white">Tanggal Mulai</th>
                        <th class="text-white">Tanggal Berakhir</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($internships as $internship)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $internship->student->nisn }}</td>
                            <td>{{ $internship->student->mayor->department->nama }}</td>
                            <td>{{ $internship->student->mayor->nama }}</td>
                            <td>{{ $internship->student->nama }}</td>
                            <td>{{ $internship->teacher->nama }}</td>
                            <td>{{ $internship->corporation->nama }}</td>
                            <td>{{ $internship->tahun_ajaran }}</td>
                            <td>{{ Carbon::parse($internship->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ Carbon::parse($internship->tanggal_berakhir)->format('d M Y') }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('pimpinan/showSiswaPkl', $internship->id) }}">
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
