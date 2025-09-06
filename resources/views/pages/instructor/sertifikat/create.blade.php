@extends('layouts.corporation.main')

@section('content')
    <div class="card p-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Sertifikat Siswa</h5>
        </div>
        <div class="card-body border p-4">
            <h6 class="text-muted">*PASTIKAN TIDAK ADA KESALAHAN PENGETIKAN</h6>
            <hr>
            <form action="{{ route('instructor/storeSertifikat') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Static Inputs for UMUM Category -->
                <input type="hidden" name="internship_id" id="internship_id" value="{{ $internship->id }}">

                <!-- Kategori UMUM -->
                <h4>UMUM</h4>
                @foreach (['Kedisiplinan', 'Kerajinan', 'Tanggung Jawab', 'Kerjasama', 'Ketelitian'] as $point)
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">{{ $point }}</label>
                        <input type="hidden" name="categories[UMUM][]" value="{{ $point }}">
                        <div class="col-sm-3">
                            <input type="number" class="form-control score-input" name="scores[UMUM][]" min="0"
                                max="100" placeholder="0-100" required>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control predikat-input" name="predikats[UMUM][]" readonly>
                        </div>
                    </div>
                @endforeach

                <!--  KOMPETENSI UTAMA -->
                <h4>KOMPETENSI UTAMA</h4>
                <div id="kompetensi-utama">
                    <!-- Form dinamis untuk Kompetensi Utama akan ditambahkan di sini -->
                </div>
                <button type="button" class="btn btn-success mb-4" onclick="addField('kompetensi-utama')">Tambah Kompetensi
                    Utama</button>

                <!-- KOMPETENSI PENUNJANG -->
                <h4>KOMPETENSI PENUNJANG</h4>
                <div id="kompetensi-penunjang">
                    <!-- Form dinamis untuk Kompetensi Penunjang akan ditambahkan di sini -->
                </div>
                <button type="button" class="btn btn-success mb-4" onclick="addField('kompetensi-penunjang')">Tambah
                    Kompetensi
                    Penunjang</button>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama Pimpinan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_pimpinan" name="nama_pimpinan">
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
