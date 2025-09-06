@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah Data Siswa</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/student.store') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="user_id" class="form-label col-sm-2 mt-2">Username</label>
                    <div class="col-sm-10">
                        <select class="select2 form-select" id="exampleFormControlSelect1"
                            aria-label="Default select example" name="user_id">
                            <option selected>Pilih</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="mayor_id" class="form-label col-sm-2 mt-2">Kelas</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="mayor_id">
                            <option selected>Pilih</option>
                            @foreach ($mayors as $mayor)
                                <option value="{{ $mayor->id }}">{{ $mayor->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nisn">NISN</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nisn" name="nisn" placeholder=""
                            value="{{ old('nisn') }}" maxlength="10" />
                    </div>
                </div>

                <div class="row
                            mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="masukan nama lengkap" value="{{ old('nama') }}" />
                    </div>
                </div>

                <div class="row
                            mb-3">
                    <label class="col-sm-2 col-form-label" for="konsentrasi">konsentrasi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="konsentrasi" name="konsentrasi" placeholder=""
                            value="{{ old('konsentrasi') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tahun_masuk" class="form-label col-sm-2 mt-2">Tahun Masuk</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="tahun_masuk">
                            <option selected>Pilih</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2000;
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                <option value="{{ $year }}/{{ $year + 1 }}">
                                    {{ $year }}/{{ $year + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jenis_kelamin" class="form-label col-sm-2 mt-2">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="jenis_kelamin">
                            <option selected>Pilih</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender }}">{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder=""
                            value="{{ old('tanggal_lahir') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tempat_lahir">Tempat Lahir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder=""
                            value="{{ old('tempat_lahir') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="alamat_siswa">Alamat Lengkap Siswa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat_siswa" name="alamat_siswa" placeholder=""
                            value="{{ old('alamat_siswa') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="alamat_ortu">Alamat Lengkap Orang Tua</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat_ortu" name="alamat_ortu" placeholder=""
                            value="{{ old('alamat_ortu') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="hp_siswa">No Hp siswa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hp_siswa" name="hp_siswa" placeholder=""
                            value="{{ old('hp_siswa') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="hp_ortu">No Hp ortu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hp_ortu" name="hp_ortu" placeholder=""
                            value="{{ old('hp_ortu') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="image" class="form-label col-sm-2 mt-2">Foto Profil</label>
                    <div class="col-sm-10">
                        <img class="img-preview img-fluid mb-3 col-sm-2">
                        <input class="form-control" type="file" id="foto" name="foto"
                            onchange="previewImage()">
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
