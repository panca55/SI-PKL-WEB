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
        <h5 class="card-header p-0 mb-4">
            Data PKL
            <span><a href="{{ route('admin/internship.create') }}" class="text-decoration-none mx-2">
                    <i class='display-5 bx bx-user-plus'></i></a>
            </span>
            <div class="d-flex justify-content-end">
                <span>
                    <a href="{{ route('admin/exportExcel') }}" class="btn btn-success mb-3">
                        <i class='bx bx-export'></i> Export Data Siswa</a>
                </span>
            </div>
        </h5>
        <div>
            <a href="{{ route('admin/rekapAbsensi') }}" class="btn btn-primary mb-3">
                <i class='bx bxs-user-check'></i> Absensi Siswa</a>
            {{-- <a href="{{ route('admin/rekapJurnal') }}" class="btn btn-info mb-3">
                <i class='bx bx-book-reader'></i> Jurnal Siswa</a> --}}
        </div>
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
                        <th class="text-white">Tanggal Ditambahkan</th>
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
                            <td>{{ Carbon::parse($internship->created_at)->format('d M Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin/internship.edit', $internship) }}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $internship->id }}">
                                            <i class="bx bx-trash me-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal for each teacher -->
                        <div class="modal fade" id="deleteModal{{ $internship->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $internship->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p>Are you sure to delete {{ $internship->student->nama }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin/internship.destroy', $internship) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Yes
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
