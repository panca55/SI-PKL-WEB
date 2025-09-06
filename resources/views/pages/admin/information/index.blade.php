@extends('layouts.admin.main')

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
            Tambah Informasi
            <span><a href="{{ route('admin/information.create') }}" class="text-decoration-none mx-2"><i
                        class='display-5 bx bx-comment-add'></i></a></span>
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">Judul</th>
                        <th class="text-white">Isi</th>
                        <th class="text-white">Tanggal Mulai</th>
                        <th class="text-white">Tanggal Berakhir</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($informations as $information)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $information->nama }}</td>
                            <td>{!! $information->isi !!}</td>
                            <td>{{ $information->tanggal_mulai }}</td>
                            <td>{{ $information->tanggal_berakhir }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin/information.edit', $information) }}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            <i class="bx bx-trash me-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p>Are you sure to delete?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin/information.destroy', $information) }}"
                                            method="POST">
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
