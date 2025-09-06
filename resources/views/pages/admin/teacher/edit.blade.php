@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Data Guru</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/teacher.update', $teacher) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="name">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder=""
                            value="{{ $teacher->user->name }}" readonly />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nip">NIP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nip" name="nip" placeholder=""
                            value="{{ $teacher->nip }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="masukan dengan gelar" required value="{{ $teacher->nama }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jenis_kelamin" class="form-label col-sm-2 mt-2">jenis kelamin</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="jenis_kelamin">
                            <option selected>Pilih</option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender }}"
                                    {{ $teacher->jenis_kelamin === $gender ? 'selected' : '' }}>
                                    {{ $gender }}</option>
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
                                <option value="{{ $golongan }}"
                                    {{ $teacher->golongan === $golongan ? 'selected' : '' }}>{{ $golongan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="bidang_studi">Bidang Studi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bidang_studi" name="bidang_studi" placeholder=""
                            required value="{{ $teacher->bidang_studi }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="pendidikan_terakhir">Pendidikan Terakhir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir"
                            placeholder="" required value="{{ $teacher->pendidikan_terakhir }}" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="" required
                            value="{{ $teacher->jabatan }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tempat_lahir">Tempat lahir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder=""
                            value="{{ $teacher->tempat_lahir }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_lahir">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            placeholder="" value="{{ $teacher->tanggal_lahir }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="alamat">alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder=""
                            required value="{{ $teacher->alamat }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="hp">No Hp</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hp" name="hp" placeholder=""
                            value="{{ $teacher->hp }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="foto" class="form-label col-sm-2 mt-2">Foto Profil</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="oldImage" value="{{ $teacher->foto }}">
                        @if ($teacher->foto)
                            <img src="{{ asset('storage/public/teachers-images/' . $teacher->foto) }}"
                                class="img-preview img-fluid mb-3 col-sm-2">
                        @else
                            <img class="img-preview img-fluid mb-3 col-sm-2">
                        @endif
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
