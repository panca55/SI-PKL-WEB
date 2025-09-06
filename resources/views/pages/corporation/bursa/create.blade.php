@extends('layouts.corporation.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah Lowongan</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('corporation/bursa.store') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="judul">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="" required
                            value="{{ old('judul') }}" />
                    </div>
                </div>

                <div class="row mb-3" hidden>
                    <label for="slug" class="col-sm-2 col-form-label">slug</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="slug" name="slug" readonly required
                            value="{{ old('slug') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="editor" class="form-label col-sm-2 mt-2">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="editor" class="form-label col-sm-2 mt-2">Persyaratan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="persyaratan" id="persyaratan" placeholder="Masukan Persyaratan"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jenis_pekerjaan" class="form-label col-sm-2 mt-2">Jenis Pekerjaan</label>
                    <div class="col-sm-10">
                        @foreach ($works as $work)
                            <div class="form-check">
                                <input name="jenis_pekerjaan" class="form-check-input" type="radio"
                                    value="{{ $work }}" id="jenis_pekerjaan_{{ $loop->index }}" />
                                <label class="form-check-label" for="jenis_pekerjaan_{{ $loop->index }}">
                                    {{ $work }} </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="lokasi">Lokasi Penempatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="" required
                            value="{{ old('lokasi') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="rentang_gaji">Rentang Gaji</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rentang_gaji" name="rentang_gaji"
                            placeholder="masukan tanpa Rp" required value="{{ old('rentang_gaji') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="batas_pengiriman">Batas Pengiriman</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="batas_pengiriman" name="batas_pengiriman"
                            placeholder="" required value="{{ old('batas_pengiriman') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="contact_email">Email Penerimaan</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder=""
                            required value="{{ old('contact_email') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="foto" class="form-label col-sm-2 mt-2">Foto Poster</label>
                    <div class="col-sm-10">
                        <img class="img-preview img-fluid mb-3 col-sm-2">
                        <input class="form-control" type="file" id="foto" name="foto"
                            onchange="previewImage()">
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-sm btn-primary mt-3">Simpan</button>
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

        const judul = document.querySelector('#judul');
        const slug = document.querySelector('#slug');

        judul.addEventListener('change', function() {
            fetch('/bursa/checkSlug?+judul=' + judul.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        ClassicEditor
            .create(document.querySelector('#deskripsi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#persyaratan'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
