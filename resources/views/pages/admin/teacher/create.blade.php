@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah Data Guru</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/teacher.store') }}" autocomplete="off" enctype="multipart/form-data">
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
                    <label class="col-sm-2 col-form-label" for="nip">NIP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="" required
                            value="{{ old('nip') }}" maxlength="20" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="masukan dengan gelar" required value="{{ old('nama') }}" />
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
                    <label class="col-sm-2 col-form-label" for="golongan">Golongan PNS</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="golongan" name="golongan" required>
                            <option value="">Pilih</option>
                            @foreach ($golonganPNS as $golongan)
                                <option value="{{ $golongan }}">{{ $golongan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="bidang_studi">Bidang Studi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bidang_studi" name="bidang_studi" placeholder=""
                            required value="{{ old('bidang_studi') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="pendidikan_terakhir">Pendidikan Terakhir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir"
                            placeholder="" required value="{{ old('pendidikan_terakhir') }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="" required
                            value="{{ old('jabatan') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder=""
                            required value="{{ old('tanggal_lahir') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tempat_lahir">Tempat Lahir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder=""
                            required value="{{ old('tempat_lahir') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="alamat">Alamat Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder=""
                            required value="{{ old('alamat') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="hp">No Hp</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hp" name="hp" placeholder=""
                            required value="{{ old('hp') }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="foto" class="form-label col-sm-2 mt-2">Foto Profil</label>
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
