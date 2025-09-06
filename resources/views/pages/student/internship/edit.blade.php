@extends('layouts.student.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Logbook</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('student/internship.update', $logbook->id) }}" autocomplete="off"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="category" class="form-label col-sm-2 mt-2">Kategori Pekerjaan</label>
                    <select class="select2 form-select" id="categorySelect" name="category" disabled
                        aria-label="Default select example">
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ $logbook->category == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="category" value="{{ $logbook->category }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="judul">Nama Pekerjaan</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder=""
                        value="{{ $logbook->judul }}" />
                </div>
                <div id="activityForm" class="mb-3 {{ $logbook->category === 'KOMPETENSI' ? '' : 'd-none' }}">
                    <label class="form-label" for="activitySelect">Bentuk Kegiatan</label>
                    <select class="select2 form-select" id="activitySelect" name="bentuk_kegiatan">
                        @foreach ($activities as $activity)
                            <option value="{{ $activity }}"
                                {{ $logbook->bentuk_kegiatan == $activity ? 'selected' : '' }}>
                                {{ $activity }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="activityForm" class="mb-3 {{ $logbook->category === 'LAINNYA' ? '' : 'd-none' }}">
                    <label class="form-label" for="activitySelect">Penugasan Kegiatan</label>
                    <select class="select2 form-select" id="activitySelect" name="penugasan_pekerjaan">
                        @foreach ($assigments as $assigment)
                            <option value="{{ $assigment }}"
                                {{ $logbook->penugasan_pekerjaan == $assigment ? 'selected' : '' }}>
                                {{ $assigment }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mulai">Jam Mulai Pekerjaan</label>
                    <input type="time" class="form-control" id="mulai" name="mulai" placeholder=""
                        value="{{ $logbook->mulai }}" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="selesai">Jam Selesai Pekerjaan</label>
                    <input type="time" class="form-control" id="selesai" name="selesai" placeholder=""
                        value="{{ $logbook->selesai }}" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="petugas">Staf yang menugaskan</label>
                    <input type="text" class="form-control" id="petugas" name="petugas" placeholder=""
                        value="{{ $logbook->petugas }}" />
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Uraian Proses Kerja</label>
                    <textarea class="form-control" name="isi" id="isi" placeholder="Masukan Uraian">{{ $logbook->isi }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label col-sm-2 mt-2">Foto Kegiatan <span class="text-muted">(*Max
                            5mb)</span></label>
                    <div class="row-sm-10">
                        <input type="hidden" name="oldImage" value="{{ $logbook->foto_kegiatan }}">
                        @if ($logbook->foto_kegiatan)
                            <img src="{{ asset('storage/public/foto-kegiatan/' . $logbook->foto_kegiatan) }}"
                                class="img-preview img-fluid mb-3 col-sm-2">
                        @else
                            <img class="img-preview img-fluid mb-3 col-sm-2">
                        @endif
                        <input class="form-control" type="file" id="foto_kegiatan" name="foto_kegiatan"
                            onchange="previewImage()">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">keterangan</label>
                    <select class="select2 form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                        name="keterangan">
                        <option selected>Pilih</option>
                        <option value="TUNTAS"
                            {{ old('keterangan', $logbook->keterangan) == 'TUNTAS' ? 'selected' : '' }}>
                            TUNTAS</option>
                        <option
                            value="BELUM TUNTAS"{{ old('keterangan', $logbook->keterangan) == 'BELUM TUNTAS' ? 'selected' : '' }}>
                            BELUM TUNTAS</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('categorySelect');
            const activityForm = document.getElementById('activityForm');
            const assigmentForm = document.getElementById('assigmentForm');

            categorySelect.addEventListener('change', function() {
                if (categorySelect.value === 'KOMPETENSI') {
                    activityForm.classList.remove('d-none');
                    assigmentForm.classList.add('d-none');
                } else if (categorySelect.value === 'LAINNYA') {
                    activityForm.classList.add('d-none');
                    assigmentForm.classList.remove('d-none');
                } else {
                    activityForm.classList.add('d-none');
                    assigmentForm.classList.add('d-none');
                }
            });
        });

        ClassicEditor
            .create(document.querySelector('#isi'))
            .catch(error => {
                console.error(error);
            });

        function previewImage() {

            const foto = document.querySelector('#foto_kegiatan');
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
