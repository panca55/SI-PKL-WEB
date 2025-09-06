@extends('layouts.corporation.main')

@section('content')
    <div class="card p-4">
        <h2 class="mb-4">Form Data Perusahaan</h2>
        <form action="{{ route('corporation/profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3" hidden>
                <label for="slug" class="col-sm-2 col-form-label">slug</label>
                <input type="text" class="form-control" id="slug" name="slug" required>
            </div>
            <div class="mb-3">
                <label for="email_perusahaan">Email Perusahaan</label>
                <input type="email" name="email_perusahaan" id="email_perusahaan" class="form-control">
            </div>
            <div class="mb-3">
                <label for="mulai_hari_kerja"> Mulai Hari Kerja</label>
                <select name="mulai_hari_kerja" id="mulai_hari_kerja" class="form-control">
                    @foreach ($days as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="akhir_hari_kerja">Akhir Hari Kerja</label>
                <select name="akhir_hari_kerja" id="akhir_hari_kerja" class="form-control">
                    @foreach ($days as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="jam_mulai">Jam Mulai Kerja</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control">
            </div>

            <div class="mb-3">
                <label for="jam_berakhir">Jam Berakhir Kerja</label>
                <input type="time" name="jam_berakhir" id="jam_berakhir" class="form-control">
            </div>

            <div class="mb-3">
                <label for="quota">Kuota Siswa</label>
                <input type="number" name="quota" id="quota" class="form-control">
            </div>

            <div class="mb-3">
                <label for="editor">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5"></textarea>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" maxlength="13" id="hp" name="hp"
                    placeholder="08xxxxx tanpa -" required>
            </div>
            <div class="mb-3">
                <label for="logo">Logo Perusahaan</label>
                <img class="logo-preview img-fluid mb-3 col-sm-2">
                <input class="form-control" type="file" id="logo" name="logo" onchange="previewLogo()">
            </div>
            <div class="mb-3">
                <label for="website">Website Perusahaan</label>
                <input type="text" name="website" id="website" class="form-control" placeholder="namawebsite.com">
            </div>
            <div class="mb-3">
                <label for="instagram">Instagram Perusahaan</label>
                <input type="text" name="instagram" id="instagram" class="form-control" placeholder="masukan username">
            </div>
            <div class="mb-3">
                <label for="tiktok">Tiktok Perusahaan</label>
                <input type="text" name="tiktok" id="tiktok" class="form-control" placeholder="@">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        function previewLogo() {

            const logo = document.querySelector('#logo');
            const logoPreview = document.querySelector('.logo-preview')

            logoPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(logo.files[0]);

            oFReader.onload = function(oFREvent) {
                logoPreview.src = oFREvent.target.result;
            }
        }
        const nama = document.querySelector('#nama');
        const slug = document.querySelector('#slug');

        nama.addEventListener('change', function() {
            fetch('/corporation/checkSlug?+nama=' + nama.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        ClassicEditor
            .create(document.querySelector('#deskripsi'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
