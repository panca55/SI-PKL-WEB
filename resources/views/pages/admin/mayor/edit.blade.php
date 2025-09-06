@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Data Kelas</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/mayor.update', $mayor) }}">
                @method('PUT')
                @csrf
                <div class="row mb-3">
                    <label for="department_id" class="form-label col-sm-2 mt-2">Jurusan</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="department_id">
                            <option selected>Pilih</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $department->id == $mayor->department_id ? 'selected' : '' }}>
                                    {{ $department->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Nama Kelas</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder=""
                            value="{{ $mayor->nama }}" />
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
