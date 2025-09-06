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
            Lowongan Perkerjaan
            <span><a href="{{ route('corporation/bursa.create') }}" class="text-decoration-none mx-2"><i
                        class='display-5 bx bx-plus'></i></a></span>
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-primary">
                        <th class="text-white">No</th>
                        <th class="text-white">Judul</th>
                        <th class="text-white">Deskripsi</th>
                        <th class="text-white">Jenis Pekerjaan</th>
                        <th class="text-white">Rentang Gaji</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $job->judul }}</td>
                            <td>{!! $job->deskripsi !!}</td>
                            <td>{{ $job->jenis_pekerjaan }}</td>
                            <td>Rp. {{ number_format($job->rentang_gaji) }}</td>
                            <td>
                                @if ($job->status)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('corporation/bursa.show', $job) }}">
                                            <i class="bx bx-show-alt me-1"></i>
                                            Lihat
                                        </a>
                                        <a class="dropdown-item" href="{{ route('corporation/bursa.edit', $job) }}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('corporation/bursa.toggleActive', $job) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="dropdown-item">
                                                @if ($job->status)
                                                    <i class="bx bx-power-off me-1"></i> Nonaktifkan
                                                @else
                                                    <i class="bx bx-power-off me-1"></i> Aktifkan
                                                @endif
                                            </button>
                                        </form>
                                        <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $job->id }}">
                                            <i class="bx bx-trash me-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $job->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $job->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p>Are you sure to delete?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('corporation/bursa.destroy', $job) }}" method="POST">
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
