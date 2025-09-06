@extends('layouts.corporation.main')

@section('content')
    <div class="card p-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Sertifikat Siswa</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('instructor/updateSertifikat', $sertifikat->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Static Inputs for UMUM Category -->
                <input type="hidden" name="internship_id" id="internship_id" value="{{ $sertifikat->internship_id }}">

                <!-- Kategori UMUM -->
                <h4>UMUM</h4>
                @foreach (['Kedisiplinan', 'Kerajinan', 'Tanggung Jawab', 'Kerjasama', 'Ketelitian'] as $point)
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">{{ $point }}</label>
                        <input type="hidden" name="categories[UMUM][]" value="{{ $point }}">
                        <div class="col-sm-3">
                            <input type="number" class="form-control score-input" name="scores[UMUM][]" min="0"
                                max="100" placeholder="0-100" required
                                value="{{ $sertifikat->scores['UMUM'][$loop->index] }}">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control predikat-input" name="predikats[UMUM][]" readonly
                                value="{{ $sertifikat->predikats['UMUM'][$loop->index] }}">
                        </div>
                    </div>
                @endforeach

                <!-- KOMPETENSI UTAMA -->
                <h4>KOMPETENSI UTAMA</h4>
                <div id="kompetensi-utama">
                    @foreach ($sertifikat->categories['KOMPETENSI_UTAMA'] as $index => $category)
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama Kompetensi</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="categories[KOMPETENSI_UTAMA][]"
                                    placeholder="Masukan kompetensi" required value="{{ $category }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control score-input" name="scores[KOMPETENSI_UTAMA][]"
                                    min="0" max="100" placeholder="0-100" required
                                    value="{{ $sertifikat->scores['KOMPETENSI_UTAMA'][$index] }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control predikat-input"
                                    name="predikats[KOMPETENSI_UTAMA][]" readonly
                                    value="{{ $sertifikat->predikats['KOMPETENSI_UTAMA'][$index] }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-success mb-4" onclick="addField('kompetensi-utama')">Tambah Kompetensi
                    Utama</button>

                <!-- KOMPETENSI PENUNJANG -->
                <h4>KOMPETENSI PENUNJANG</h4>
                <div id="kompetensi-penunjang">
                    @foreach ($sertifikat->categories['KOMPETENSI_PENUNJANG'] as $index => $category)
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama Kompetensi</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="categories[KOMPETENSI_PENUNJANG][]"
                                    placeholder="Masukan kompetensi" required value="{{ $category }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control score-input" name="scores[KOMPETENSI_PENUNJANG][]"
                                    min="0" max="100" placeholder="0-100" required
                                    value="{{ $sertifikat->scores['KOMPETENSI_PENUNJANG'][$index] }}">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control predikat-input"
                                    name="predikats[KOMPETENSI_PENUNJANG][]" readonly
                                    value="{{ $sertifikat->predikats['KOMPETENSI_PENUNJANG'][$index] }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-success mb-4" onclick="addField('kompetensi-penunjang')">Tambah
                    Kompetensi Penunjang</button>

                <!-- File Input -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="file-upload">Upload Sertifikat <br><span
                            class="text-muted">*opsional</span></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="file-upload" name="file">
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to automatically update the predikat field
        function updatePredikat(input) {
            let score = parseInt(input.value);
            let predikat = '';

            if (score >= 0 && score <= 50) {
                predikat = 'Kurang';
            } else if (score > 50 && score <= 70) {
                predikat = 'Cukup';
            } else if (score > 70 && score <= 85) {
                predikat = 'Baik';
            } else if (score > 85 && score <= 100) {
                predikat = 'Baik Sekali';
            } else {
                predikat = 'Invalid';
            }

            input.closest('.row').querySelector('.predikat-input').value = predikat;
        }

        // Apply event listener to existing static fields
        document.querySelectorAll('.score-input').forEach(input => {
            input.addEventListener('input', function() {
                updatePredikat(this);
            });
        });

        // Function to dynamically add new fields
        function addField(category) {
            var container = document.getElementById(category);
            var html = `
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Kompetensi</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="categories[` + category.toUpperCase().replace('-',
                    '_') + `][]" placeholder="Masukan kompetensi" required>
                </div>
                <div class="col-sm-3">
                    <input type="number" class="form-control score-input" name="scores[` + category.toUpperCase()
                .replace('-', '_') + `][]" min="0" max="100" placeholder="0-100" required>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control predikat-input" name="predikats[` + category.toUpperCase()
                .replace('-', '_') + `][]" readonly>
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);

            // Re-bind event listener to newly added fields
            container.querySelectorAll('.score-input').forEach(input => {
                input.addEventListener('input', function() {
                    updatePredikat(this);
                });
            });
        }
    </script>
@endsection
