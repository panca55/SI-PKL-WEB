@extends('layouts.corporation.main')

@section('content')
    <div class="card p-4">
        <h3>Isi Data Diri Anda</h3>

        <form action="{{ route('instructor/profile.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="corporation_id" class="form-label col-sm-2 mt-2">Perusahaan</label>
                <select class="select2 form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                    name="corporation_id">
                    <option selected>Pilih</option>
                    @foreach ($corporations as $corporation)
                        <option value="{{ $corporation->id }}">{{ $corporation->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
                <div class="invalid-feedback">Mohon isi nama lengkap Anda.</div>
            </div>

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" maxlength="10"
                    placeholder="boleh dikosongkan">
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih</option>
                    @foreach ($genders as $gender)
                        <option value="{{ $gender }}">{{ $gender }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Mohon pilih jenis kelamin Anda.</div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}" required>
                <div class="invalid-feedback">Mohon isi tanggal lahir Anda.</div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ old('tempat_lahir') }}" required>
                <div class="invalid-feedback">Mohon isi tempat lahir Anda.</div>
            </div>


            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
                <div class="invalid-feedback">Mohon isi alamat Anda.</div>
            </div>

            <div class="mb-3">
                <label for="hp" class="form-label">Nomor Hp<span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="hp" name="hp" required pattern="[0-9]{10,13}">
                <div class="invalid-feedback">Mohon isi nomor HP Anda (10-13 digit).</div>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil <span class="text-danger">*</span><br><span
                        class="text-muted">*Masukan Foto Formal</span><br><span class="text-muted">*Max
                        500kb</span></label>
                <img class="img-preview img-fluid mb-3">
                <input class="form-control" type="file" id="foto" name="foto" onchange="previewImage()" required
                    accept="image/*">
                <div class="invalid-feedback">Mohon unggah foto profil Anda (max 500kb).</div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data Diri</button>
        </form>
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
