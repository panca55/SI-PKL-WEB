@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah Jurusan</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/department.store') }}" autocomplete="off">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Nama Jurusan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="" required
                            value="{{ old('nama') }}" autofocus />
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
