@extends('layouts.admin.main')
@php
    use App\Models\User;

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
            Data User
            <span><a href="{{ route('admin/user.create') }}" class="text-decoration-none mx-2">
                    <i class='display-5 bx bx-user-plus'></i></a>
            </span>
            <span>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class='bx bx-import'></i> Import Excel
                </button>
            </span>
        </h5>

        <form action="{{ route('admin/user.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach (User::ROLES as $key => $value)
                            <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-danger">
                        <th class="text-white">No</th>
                        <th class="text-white">Username</th>
                        <th class="text-white">Email</th>
                        <th class="text-white">Role</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if ($user->is_active)
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
                                        <a class="dropdown-item" href="{{ route('admin/user.edit', $user) }}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin/user.toggleActive', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="dropdown-item">
                                                @if ($user->is_active)
                                                    <i class="bx bx-power-off me-1"></i> Nonaktifkan
                                                @else
                                                    <i class="bx bx-power-off me-1"></i> Aktifkan
                                                @endif
                                            </button>
                                        </form>
                                        <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                            <i class="bx bx-trash me-1"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <p>Are you sure to delete?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin/user.destroy', $user) }}" method="POST">
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
    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import User Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin/user.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Choose Excel File</label>
                            <input type="file" class="form-control" id="excel_file" name="excel_file"
                                accept=".xlsx, .xls" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
