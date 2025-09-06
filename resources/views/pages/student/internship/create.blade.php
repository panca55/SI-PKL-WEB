@extends('layouts.student.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Jurnal Harian <br><br><span class="text-danger">*Tidak boleh ada yang kosong!</span></h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('student/logbookStore') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="category" class="form-label col-sm-2 mt-2">Kategori Pekerjaan <span
                            class="text-danger">*</span></label>
                    <select class="select2 form-select" id="categorySelect" name="category"
                        aria-label="Default select example">
                        <option selected>Pilih</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="judul">Nama Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="" required />
                </div>
                <div id="assigmentForm" class="mb-3 d-none">
                    <label class="form-label" for="assigmentSelect">Penugasan Pekerjaan <span
                            class="text-danger">*</span></label>
                    <select class="select2 form-select" id="assigmentSelect" name="penugasan_pekerjaan">
                        <option selected>Pilih</option>
                        @foreach ($assigments as $assigment)
                            <option value="{{ $assigment }}">{{ $assigment }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="activityForm" class="mb-3 d-none">
                    <label class="form-label" for="activitySelect">Bentuk Kegiatan <span
                            class="text-danger">*</span></label>
                    <select class="select2 form-select" id="activitySelect" name="bentuk_kegiatan">
                        <option selected>Pilih</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity }}">{{ $activity }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mulai">Jam Mulai Pekerjaan <span class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="mulai" name="mulai" step="60" placeholder=""
                        required />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="selesai">Jam Selesai Pekerjaan <span
                            class="text-danger">*</span></label>
                    <input type="time" class="form-control" id="selesai" name="selesai" step="60" placeholder=""
                        required />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="petugas">Staf yang menugaskan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="petugas" name="petugas" placeholder="" required />
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Uraian Proses Kerja <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="isi" id="isi" placeholder="Masukan Uraian"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label col-sm-2 mt-2">Foto Kegiatan / Foto Hasil Pekerjaan<span
                            class="text-danger">(*Max 5MB)</span></label>
                    <div class="row-sm-10">
                        <img class="img-preview img-fluid mb-3 col-sm-2">
                        <input class="form-control" type="file" id="foto_kegiatan" name="foto_kegiatan"
                            onchange="previewImage()">
                        <div id="fileError" class="text-danger mt-2" style="display: none;">
                            File terlalu besar. Maksimum ukuran file adalah 5MB.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">keterangan <span class="text-danger">*</span></label>
                    <select class="select2 form-select" id="exampleFormControlSelect1"
                        aria-label="Default select example" name="keterangan" required>
                        <option selected>Pilih</option>
                        <option value="TUNTAS">TUNTAS</option>
                        <option value="BELUM TUNTAS">BELUM TUNTAS</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('categorySelect');
            const assigmentForm = document.getElementById('assigmentForm');
            const activityForm = document.getElementById('activityForm');
            const form = document.querySelector('form');
            const fileInput = document.getElementById('foto_kegiatan');
            const fileError = document.getElementById('fileError');
            const submitButton = form.querySelector('button[type="submit"]');
            const uraianField = document.querySelector('#isi');

            let isSubmitting = false;
            let editorTextarea;

            // Event listener for category selection change
            categorySelect.addEventListener('change', function() {
                if (categorySelect.value === 'KOMPETENSI') {
                    assigmentForm.classList.add('d-none');
                    activityForm.classList.remove('d-none');
                } else if (categorySelect.value === 'LAINNYA') {
                    assigmentForm.classList.remove('d-none');
                    activityForm.classList.add('d-none');
                } else {
                    assigmentForm.classList.add('d-none');
                    activityForm.classList.add('d-none');
                }
            });

            // File size validation
            function validateFileSize() {
                if (fileInput.files.length > 0) {
                    const fileSize = fileInput.files[0].size;
                    const maxSize = 5 * 1024 * 1024; // 5MB

                    if (fileSize > maxSize) {
                        fileError.style.display = 'block';
                        fileError.textContent =
                            'File terlalu besar. Maksimum ukuran file adalah 5MB. Silakan pilih file yang lebih kecil.';
                        return false;
                    } else {
                        fileError.style.display = 'none';
                    }
                }
                return true;
            }

            // Uraian validation
            function validateUraian() {
                const uraianContent = editorTextarea.getData().trim();
                if (uraianContent === '') {
                    alert('Uraian Proses Kerja tidak boleh kosong.');
                    return false;
                }
                return true;
            }

            // Form submit event listener
            form.addEventListener('submit', function(event) {
                if (isSubmitting) {
                    event.preventDefault();
                    return;
                }

                if (!validateFileSize() || !validateUraian()) {
                    event.preventDefault();
                    return;
                }

                isSubmitting = true;
                submitButton.disabled = true;
                submitButton.innerHTML = 'Menyimpan...';
            });

            // File input change event for file size validation
            fileInput.addEventListener('change', validateFileSize);

            // CKEditor initialization
            ClassicEditor
                .create(document.querySelector('#isi'))
                .then(editor => {
                    editorTextarea = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            // CKEditor minlength validation
            $.validator.addMethod("ckminlength", function(value, element, params) {
                let content_length = editorTextarea.getData().replace(/<[^>]*>/g, '').length;
                return this.optional(element) || content_length >= params;
            }, "Masukkan minimal {0} karakter.");

            // jQuery validation for form
            $("#my_form_id").validate({
                ignore: [],
                rules: {
                    isi: {
                        required: true,
                        ckminlength: 10,
                    },
                },
                messages: {
                    isi: {
                        required: "Uraian Proses Kerja tidak boleh kosong.",
                        ckminlength: "Uraian Proses Kerja minimal harus berisi 10 karakter."
                    }
                }
            });

        });
        // Image preview function
        function previewImage() {
            const foto = document.querySelector('#foto_kegiatan');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
@endsection
