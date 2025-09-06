@extends('layouts.student.main')

@section('content')
    <div class="card p-4">
        <h3>Isi Data Diri Anda</h3>

        <form action="{{ route('student/profile.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data"
            id="studentProfileForm">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
                <div class="invalid-feedback">Mohon isi nama lengkap Anda.</div>
            </div>

            <div class="mb-3">
                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nisn" name="nisn" maxlength="10" required>
                <div class="invalid-feedback">Mohon isi NISN Anda (maksimal 10 digit).</div>
            </div>

            <div class="mb-3">
                <label for="mayor_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                <select class="form-select" id="mayor_id" name="mayor_id" required>
                    <option value="">Pilih</option>
                    @foreach ($mayors as $mayor)
                        <option value="{{ $mayor->id }}">{{ $mayor->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Mohon pilih kelas Anda.</div>
            </div>

            <div class="mb-3">
                <label for="konsentrasi" class="form-label">Konsentrasi <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="konsentrasi" name="konsentrasi" required>
                <div class="invalid-feedback">Mohon isi konsentrasi Anda.</div>
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
                <label for="tahun_masuk" class="form-label">Tahun Masuk <span class="text-danger">*</span></label>
                <select class="form-select" id="tahun_masuk" name="tahun_masuk" required>
                    <option value="">Pilih</option>
                    @php
                        $currentYear = date('Y');
                        $startYear = 2016;
                    @endphp
                    @for ($year = $currentYear; $year >= $startYear; $year--)
                        <option value="{{ $year }}/{{ $year + 1 }}">{{ $year }}/{{ $year + 1 }}
                        </option>
                    @endfor
                </select>
                <div class="invalid-feedback">Mohon pilih tahun masuk Anda.</div>
            </div>

            <div class="mb-3">
                <label for="alamat_siswa" class="form-label">Alamat Siswa <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="alamat_siswa" name="alamat_siswa" required>
                <div class="invalid-feedback">Mohon isi alamat Anda.</div>
            </div>

            <div class="mb-3">
                <label for="hp_siswa" class="form-label">Nomor HP Siswa <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="hp_siswa" name="hp_siswa" required pattern="[0-9]{10,13}">
                <div class="invalid-feedback">Mohon isi nomor HP Anda (10-13 digit).</div>
            </div>

            <div class="mb-3">
                <label for="alamat_ortu" class="form-label">Alamat Orang Tua <span class="text-danger">*</span> <span
                        class="text-muted">(boleh sama dengan alamat siswa)</span></label>
                <input type="text" class="form-control" id="alamat_ortu" name="alamat_ortu" required>
                <div class="invalid-feedback">Mohon isi alamat orang tua Anda.</div>
            </div>

            <div class="mb-3">
                <label for="hp_ortu" class="form-label">Nomor HP Ortu <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="hp_ortu" name="hp_ortu" required
                    pattern="[0-9]{10,13}">
                <div class="invalid-feedback">Mohon isi nomor HP orang tua Anda (10-13 digit).</div>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil <span class="text-danger">*</span><br><span
                        class="text-muted">*Masukan Foto Formal</span><br><span class="text-muted">*Max
                        500kb</span></label>
                <img class="img-preview img-fluid mb-3">
                <input class="form-control" type="file" id="foto" name="foto" onchange="previewImage()"
                    required accept="image/*">
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

        // Form validation
        (function() {
            'use strict'

            var form = document.getElementById('studentProfileForm')
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })()
    </script>
@endsection
