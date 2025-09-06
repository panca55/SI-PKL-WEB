@extends('layouts.corporation.main')

@section('content')
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-center rounded">
                        <h2 class="text-white"><i class='bx bx-edit-alt'></i> Edit Profil Perusahaan</h2>
                    </div>
                    <div class="card-body mt-2">
                        <form method="POST" action="{{ route('corporation/profile.update', $user->id) }}"
                            enctype="multipart/form-data" autocomplete="off">
                            @method('PUT')
                            @csrf

                            <h5 class="mt-2 text-center">Akun Login</h5>
                            <hr class="my-0" />
                            <div class="form-group mb-3 mt-2">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}">
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password <span class="text-muted">(*Biarkan kosong
                                        apabila
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

                            <h5 class="mt-2 text-center">Detail Perusahaan</h5>
                            <hr class="my-0" />
                            <div class="form-group mb-3 mt-2">
                                <label for="nama"><i class='bx bx-building-house'></i> Nama Perusahaan</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ old('nama', $profile->nama) }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug" class="col-sm-2 col-form-label">slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" readonly
                                    value="{{ $profile->slug }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="alamat"><i class='bx bx-map'></i> Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control"
                                    value="{{ old('alamat', $profile->alamat) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="email_perusahaan"><i class='bx bx-envelope'></i> Email Perusahaan</label>
                                <input type="email" name="email_perusahaan" id="email_perusahaan" class="form-control"
                                    value="{{ old('email_perusahaan', $profile->email_perusahaan) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="hp"><i class='bx bx-phone'></i> Phone</label>
                                <input type="text" name="hp" id="hp" class="form-control"
                                    value="{{ old('hp', $profile->hp) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="mulai_hari_kerja"><i class='bx bx-calendar'></i> Mulai Hari Kerja</label>
                                <select name="mulai_hari_kerja" id="mulai_hari_kerja" class="form-control">
                                    @foreach ($days as $day)
                                        <option value="{{ $day }}"
                                            {{ $profile->mulai_hari_kerja === $day ? 'selected' : '' }}>
                                            {{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="akhir_hari_kerja"><i class='bx bx-calendar-check'></i> Akhir Hari
                                    Kerja</label>
                                <select name="akhir_hari_kerja" id="akhir_hari_kerja" class="form-control">
                                    @foreach ($days as $day)
                                        <option value="{{ $day }}"
                                            {{ $profile->akhir_hari_kerja === $day ? 'selected' : '' }}>
                                            {{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="jam_mulai"><i class='bx bx-time-five'></i> Jam Mulai Kerja</label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control"
                                    value="{{ old('jam_mulai', $profile->jam_mulai) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="jam_berakhir"><i class='bx bx-time'></i> Jam Berakhir Kerja</label>
                                <input type="time" name="jam_berakhir" id="jam_berakhir" class="form-control"
                                    value="{{ old('jam_berakhir', $profile->jam_berakhir) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="quota"><i class='bx bx-group'></i> Kuota Siswa</label>
                                <input type="number" name="quota" id="quota" class="form-control"
                                    value="{{ old('quota', $profile->quota) }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="editor"><i class='bx bx-info-circle'></i> Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5">{{ old('deskripsi', $profile->deskripsi) }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="logo"><i class='bx bx-image'></i> Logo Perusahaan</label>
                                <input type="hidden" name="oldLogo" value="{{ $profile->logo }}">
                                @if ($profile->logo)
                                    <img src="{{ asset('storage/public/corporations-logos/' . $profile->logo) }}"
                                        class="logo-preview img-fluid mb-3 col-sm-2">
                                @else
                                    <img class="logo-preview img-fluid mb-3 col-sm-2">
                                @endif
                                <input class="form-control" type="file" id="logo" name="logo"
                                    onchange="previewLogo()">
                            </div>

                            <div class="form-group mb-3">
                                <label for="foto"><i class='bx bx-image-add'></i> Foto Perusahaan</label>
                                <input type="hidden" name="oldImage" value="{{ $profile->foto }}">
                                @if ($profile->foto)
                                    <img src="{{ asset('storage/public/corporations-images/' . $profile->foto) }}"
                                        class="img-preview img-fluid mb-3 col-sm-2">
                                @else
                                    <img class="img-preview img-fluid mb-3 col-sm-2">
                                @endif
                                <input class="form-control" type="file" id="foto" name="foto"
                                    onchange="previewImage()">
                            </div>


                            <h5 class="mt-2 mb-2 text-center">Sosial Media</h5>
                            <hr class="my-0 mb-2" />

                            <div class="form-group mb-3">
                                <label for="website"><i class="bx bxs-building-house"></i> Website Perusahaan</label>
                                <input type="text" name="website" id="website" class="form-control"
                                    value="{{ old('website', $profile->website) }}" placeholder="namawebsite.com">
                            </div>
                            <div class="form-group mb-3">
                                <label for="instagram"><i class='bx bxl-instagram'></i> Instagram Perusahaan</label>
                                <input type="text" name="instagram" id="instagram" class="form-control"
                                    value="{{ old('instagram', $profile->instagram) }}" placeholder="masukan username">
                            </div>
                            <div class="form-group mb-3">
                                <label for="tiktok"><i class='bx bxl-tiktok'></i> Tiktok Perusahaan</label>
                                <input type="text" name="tiktok" id="tiktok" class="form-control"
                                    value="{{ old('tiktok', $profile->tiktok) }}" placeholder="@">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Simpan
                                    Perubahan</button>
                                <a href="{{ route('corporation/profile.index') }}" class="btn btn-secondary"><i
                                        class='bx bx-arrow-back'></i> Batal</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small class="text-muted"><i class='bx bx-time'></i> Terakhir diperbaharui:
                            {{ $profile->updated_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
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

        ClassicEditor
            .create(document.querySelector('#deskripsi'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
