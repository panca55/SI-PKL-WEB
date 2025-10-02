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
        <form method="GET" action="{{ route('admin/student.index') }}">
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="tahun_masuk" class="form-label">Filter Tahun Masuk</label>
                    <select name="tahun_masuk" id="tahun_masuk" class="form-select">
                        <option value="">Semua Tahun</option>
                        @php
                            $currentYear = Carbon::now()->year;
                            $startYear = 2020; // Bisa disesuaikan
                        @endphp
                        @for ($i = $startYear; $i <= $currentYear; $i++)
                            @php
                                $tahun_ajaran = $i . '/' . ($i + 1);
                            @endphp
                            <option value="{{ $tahun_ajaran }}"
                                {{ request('tahun_masuk') == $tahun_ajaran ? 'selected' : '' }}>
                                {{ $tahun_ajaran }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="mayor_id" class="form-label">Filter Jurusan</label>
                    <select name="mayor_id" id="mayor_id" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach ($mayors as $mayor)
                            <option value="{{ $mayor->id }}" {{ request('mayor_id') == $mayor->id ? 'selected' : '' }}>
                                {{ $mayor->department->nama }} - {{ $mayor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>

                <div class="d-flex justify-content-end">
                    <span>
                        <a href="{{ route('admin/studentExport', request()->query()) }}" class="btn btn-success mb-3">
                            <i class='bx bx-export'></i> Export to Excel</a>
                    </span>
                </div>
            </div>
        </form>
        <h5 class="card-header p-0 mb-4">
            Data Siswa
            <span><a href="{{ route('admin/student.create') }}" class="text-decoration-none mx-2"><i
                        class='display-5 bx bx-user-plus'></i></a></span>
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">NISN</th>
                        <th class="text-white">Email</th>
                        <th class="text-white">Nama Lengkap</th>
                        <th class="text-white">Jurusan</th>
                        <th class="text-white">Kelas</th>
                        <th class="text-white">Konsentrasi</th>
                        <th class="text-white">Tahun Masuk</th>
                        <th class="text-white">Jenis Kelamin</th>
                        <th class="text-white">Tempat Lahir</th>
                        <th class="text-white">Tanggal Lahir</th>
                        <th class="text-white">Alamat Siswa</th>
                        <th class="text-white">Alamat Ortu</th>
                        <th class="text-white">NO HP Siswa</th>
                        <th class="text-white">NO HP Ortu</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Foto</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $student->nisn }}</td>
                            <td>{{ $student->user? $student->user->email : 'N/A' }}</td>
                            <td>{{ $student->nama }}</td>
                            <td>{{ $student->mayor->department->nama }}</td>
                            <td>{{ $student->mayor->nama }}</td>
                            <td>{{ $student->konsentrasi }}</td>
                            <td>{{ $student->tahun_masuk }}</td>
                            <td>{{ $student->jenis_kelamin }}</td>
                            <td>{{ $student->tempat_lahir }}</td>
                            <td>{{ Carbon::parse($student->tanggal_lahir)->format('d M Y') }}</td>
                            <td>{{ $student->alamat_siswa }}</td>
                            <td>{{ $student->alamat_ortu }}</td>
                            <td>{{ $student->hp_siswa }}</td>
                            <td>{{ $student->hp_ortu }}</td>
                            <td>{{ $student->status_pkl }}</td>
                            <td><img src="{{ asset('storage/public/students-images/' . $student->foto) }}"
                                    alt="{{ $student->nama }}" width="50"></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin/student.edit', $student) }}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $student->id }}">
                                            <i class="bx bx-trash me-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal for each student -->
                        <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p>Are you sure to delete {{ $student->nama }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin/student.destroy', $student) }}" method="POST">
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
