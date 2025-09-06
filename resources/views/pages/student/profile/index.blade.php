@extends('layouts.student.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Data Pribadi</h5>
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4 col">
                <img class="img-fluid rounded-circle mb-4"
                    src="{{ $profile->foto ? asset('storage/public/students-images/' . $profile->foto) : asset('/assets/img/avatars/1.png') }}"
                    height="100" width="100" alt="User avatar" />
                <div class="user-info text-center">
                    <h4>{{ $profile->user->email ?? 'Belum diisi' }}</h4>
                    <span class="text-center badge bg-label-success">{{ $profile->user->role ?? 'Belum diisi' }}</span>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
            <form id="formAccountSettings" method="POST" onsubmit="return false">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input class="form-control" type="text" id="nisn" name="nisn"
                            value="{{ $profile->nisn ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->nama ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Jurusan</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->mayor->department->nama ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Kelas</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->mayor->nama ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Tahun Masuk</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->tahun_masuk ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Tempat / Tanggal Lahir</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->tempat_lahir ?? 'Belum diisi' }} / {{ Carbon::parse($profile->tanggal_lahir)->format('d M Y') }}"
                            readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Jenis Kelamin</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->jenis_kelamin ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Alamat Orang Tua</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->alamat_ortu ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Alamat Siswa</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->alamat_siswa ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">No Hp Orang Tua</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->hp_ortu ?? 'Belum diisi' }}" readonly />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">No Hp Siswa</label>
                        <input class="form-control" type="text" id="nama" name="nama"
                            value="{{ $profile->hp_siswa ?? 'Belum diisi' }}" readonly />
                    </div>
                </div>
                <div class="mt-2">
                    <a href="{{ route('student/profile.edit', $profile) }}" class="btn btn-primary" type="submit">Edit
                        Data Pribadi</a>
                </div>
            </form>
        </div>
    </div>
@endsection
