@extends('layouts.teacher.main')

@section('content')
    <div class="card p-4">
        <h2 class="mb-4">Form Data Diri Guru</h2>
        <form action="{{ route('teacher/profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="status" class="form-label">Status Kepegawaian</label>
                <select class="form-select" id="status" name="status" required onchange="togglePNSFields()">
                    <option value="">Pilih Status</option>
                    <option value="pns">PNS</option>
                    <option value="non_pns">Non PNS</option>
                </select>
            </div>

            <div id="pnsFields" style="display: none;">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" maxlength="20">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="golongan">Golongan PNS</label>
                    <select class="form-select" id="golongan" name="golongan">
                        <option value="">Pilih</option>
                        @foreach ($golonganPNS as $golongan)
                            <option value="{{ $golongan }}">{{ $golongan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">Pilih</option>
                    @foreach ($genders as $gender)
                        <option value="{{ $gender }}">{{ $gender }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="hp" name="hp" required>
            </div>

            <div class="mb-3">
                <label for="bidang_studi" class="form-label">Bidang Studi</label>
                <input type="text" class="form-control" id="bidang_studi" name="bidang_studi" required>
            </div>

            <div class="mb-3">
                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil <span class="text-danger">*</span><br><span
                        class="text-muted">*Masukan Foto Formal</span><br><span class="text-muted">*Max
                        500kb</span></label>
                <img class="img-preview img-fluid mb-3">
                <input class="form-control" type="file" id="foto" name="foto" onchange="previewImage()"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
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

        function togglePNSFields() {
            var status = document.getElementById('status').value;
            var pnsFields = document.getElementById('pnsFields');

            if (status === 'pns') {
                pnsFields.style.display = 'block';
            } else {
                pnsFields.style.display = 'none';
            }
        }
    </script>
@endsection
