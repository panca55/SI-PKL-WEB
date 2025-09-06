@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah User</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/user.store') }}" autocomplete="off">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="name">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="" required
                            value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="email">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" placeholder="" required
                            value="{{ old('email') }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="role" class="form-label col-sm-2 mt-2">Role</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="role">
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="password">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder=""
                            required />
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-sm btn-success mt-3">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
