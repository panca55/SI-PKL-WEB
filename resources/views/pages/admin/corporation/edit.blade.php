@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Data Guru</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/corporation.update', $corporation) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="name">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder=""
                            value="{{ $corporation->user->name }}" readonly />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Nama Perusahaan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="masukan dengan gelar" required value="{{ $corporation->nama }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="slug" class="col-sm-2 col-form-label">slug</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="slug" name="slug" readonly required
                            value="{{ $corporation->slug }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="quota">Quota</label>
                    <div class="col-sm-10">
                        <input type="nummber" class="form-control" id="quota" name="quota"
                            placeholder="masukan maksimal quota siswa" required value="{{ $corporation->quota }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="mulai_hari_kerja" class="form-label col-sm-2 mt-2">Mulai Hari Kerja</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="mulai_hari_kerja">
                            <option selected>Pilih</option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}"
                                    {{ $corporation->mulai_hari_kerja === $day ? 'selected' : '' }}>
                                    {{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="akhir_hari_kerja" class="form-label col-sm-2 mt-2">Akhir Hari Kerja</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="akhir_hari_kerja">
                            <option selected>Pilih</option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}"
                                    {{ $corporation->akhir_hari_kerja === $day ? 'selected' : '' }}>
                                    {{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="jam_mulai">Jam Mulai Kerja</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" placeholder="" required
                            value="{{ $corporation->jam_mulai }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="jam_berakhir">Jam Pulang</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" id="jam_berakhir" name="jam_berakhir" placeholder=""
                            required value="{{ $corporation->jam_berakhir }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="alamat">alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="" required
                            value="{{ $corporation->alamat }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="hp">No Hp</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hp" name="hp" placeholder=""
                            value="{{ $corporation->hp }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="foto" class="form-label col-sm-2 mt-2">Foto Profil</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="oldImage" value="{{ $corporation->foto }}">
                        @if ($corporation->foto)
                            <img src="{{ asset('storage/public/corporations-images/' . $corporation->foto) }}"
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

        const nama = document.querySelector('#nama');
        const slug = document.querySelector('#slug');

        nama.addEventListener('change', function() {
            fetch('/corporation/checkSlug?+nama=' + nama.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });
    </script>
@endsection
