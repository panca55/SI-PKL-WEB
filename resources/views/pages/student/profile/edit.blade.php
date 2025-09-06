@extends('layouts.student.main')

@section('content')
    <div class="card mb-6 mx-auto" style="max-width: 600px;">
        <div class="card-body pt-12">
            <h5 class="pb-4 border-bottom mb-4">Edit Profile</h5>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('student/profile.update', $user->id) }}" enctype="multipart/form-data"
                autocomplete="off">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->name }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $profile->nama }}">
                </div>
                <div class="mb-3">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" value="{{ $profile->nisn }}">
                </div>
                <div class="mb-3">
                    <label for="mayor_id" class="form-label col-sm-2 mt-2">Kelas</label>
                    <select class="form-select" id="mayor_id" aria-label="Default select example"
                        name="mayor_id">
                        @foreach ($mayors as $mayor)
                            <option value="{{ $mayor->id }}" {{ $mayor->id == $profile->mayor_id ? 'selected' : '' }}>
                                {{ $mayor->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tahun_masuk" class="form-label col-sm-2 mt-2">Tahun Masuk</label>
                    <select class="form-select" id="tahun_masuk" aria-label="Default select example"
                        name="tahun_masuk">
                        <option>Pilih</option>
                        @php
                            $currentYear = date('Y');
                            $startYear = 2014;
                            $selectedYear = explode('/', $profile->tahun_masuk)[0];
                        @endphp
                        @for ($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}/{{ $year + 1 }}"
                                {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}/{{ $year + 1 }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" aria-label="Default select example"
                        name="jenis_kelamin">
                        <option selected>Pilih</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender }}"
                                {{ $profile->jenis_kelamin === $gender ? 'selected' : '' }}>
                                {{ $gender }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                        value="{{ $profile->tempat_lahir }}">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                        value="{{ $profile->tanggal_lahir }}">
                </div>
                <div class="mb-3">
                    <label for="alamat_ortu" class="form-label">Alamat Orang Tua</label>
                    <input type="text" class="form-control" id="alamat_ortu" name="alamat_ortu"
                        value="{{ $profile->alamat_ortu }}">
                </div>
                <div class="mb-3">
                    <label for="alamat_siswa" class="form-label">Alamat Siswa </label>
                    <span class="text-muted">(*Boleh Disi sama dengan alamat orang tua)</span>
                    <input type="text" class="form-control" id="alamat_siswa" name="alamat_siswa"
                        value="{{ $profile->alamat_siswa }}">
                </div>
                <div class="mb-3">
                    <label for="hp_ortu" class="form-label">No Hp Orang Tua</label>
                    <input type="text" class="form-control" id="hp_ortu" name="hp_ortu"
                        value="{{ $profile->hp_ortu }}">
                </div>
                <div class="mb-3">
                    <label for="hp_siswa" class="form-label">No Hp Siswa</label>
                    <span class="text-muted">(*Boleh Disi sama dengan no hp orang tua)</span>
                    <input type="text" class="form-control" id="hp_siswa" name="hp_siswa"
                        value="{{ $profile->hp_siswa }}">
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label col-sm-2 mt-2">Foto Profil</label>
                    <span class="text-muted">(*maksimal ukuran 500kb ratio 4:3)</span>
                    <div class="col-sm-10">
                        <input type="hidden" name="oldImage" value="{{ $profile->foto }}">
                        @if ($profile->foto)
                            <img src="{{ asset('storage/public/students-images/' . $profile->foto) }}"
                                class="img-preview img-fluid mb-3 col-sm-2">
                        @else
                            <img class="img-preview img-fluid mb-3 col-sm-2">
                        @endif
                        <input class="form-control" type="file" id="foto" name="foto"
                            onchange="previewImage()">
                    </div>
                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">Password <span class="text-muted">(*Biarkan kosong apabila
                            tidak ingin merubah)</span>
                    </label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" autocomplete="new-password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password_confirmation" class="form-control"
                            name="password_confirmation"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" autocomplete="new-password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        function previewImage() {

            const foto = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview')

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
