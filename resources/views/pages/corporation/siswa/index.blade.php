@extends('layouts.corporation.main')

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
            Data Siswa Yang Sudah PKL
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-primary">
                        <th class="text-white">No</th>
                        <th class="text-white">Nama</th>
                        <th class="text-white">Jurusan</th>
                        <th class="text-white">Tahun Ajaran</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($internships as $internship)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $internship->student->nama }}</td>
                            <td>{{ $internship->student->mayor->department->nama }}</td>
                            <td>{{ $internship->tahun_ajaran }}</td>
                            <td>{{ $internship->student->status_pkl }}</td>
                            <td>
                                <a class="list-item" href="{{ route('corporation/siswa.show', $internship) }}">
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
