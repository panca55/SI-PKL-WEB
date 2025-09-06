@extends('layouts.student.main')

@section('content')
    @if (!$evaluationDate)
        <div class="card p-4">
            <h1 class="text-center text-danger">BELUM PERIODE PENILAIAN</h1>
        </div>
    @elseif ($isEvaluationEmpty)
        <div class="card p-4">
            <h1 class="text-center text-danger"> Anda belum diberi penilaian. Silakan cek kembali nanti.</h1>
        </div>
    @else
        <!-- Card Sertifikat -->
        <div class="card shadow-lg p-4 mb-5 bg-white rounded">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="font-weight-bold">Sertifikat Anda</h2>
                <!-- Tombol untuk memunculkan form feedback -->
                @if (empty($feedback))
                    <button id="show-feedback-form" class="btn btn-primary btn-lg">
                        <i class="bx bx-printer me-1"></i> Unduh Sertifikat
                    </button>
                @else
                    <a class="btn btn-primary text-white btn-lg"
                        href="{{ route('student/evaluation.print', $internship->id) }}"><i class="bx bx-printer me-1"></i>
                        Unduh
                        Sertifikat</a>
                @endif
            </div>
            <p class="text-muted">Berikut adalah nilai akhir dan sertifikat Anda. Pastikan untuk mengunduhnya sebagai
                dokumentasi.</p>

            <!-- Nilai Akhir Section -->
            <div class="mt-4">
                <h4 class="mb-3">Nilai Akhir</h4>
                <table class="table table-bordered">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col" class="text-white">Komponen</th>
                            <th scope="col" class="text-white">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Penilaian Monitoring</td>
                            <td>{{ $internship->evaluation->monitoring }}</td>
                        </tr>
                        <tr>
                            <td>Rata Rata Nilai Sertifikat</td>
                            <td>{{ $internship->evaluation->sertifikat }}</td>
                        </tr>
                        <tr>
                            <td>Jurnal Harian</td>
                            <td>{{ $internship->evaluation->logbook }}</td>
                        </tr>
                        <tr>
                            <td>Presentasi</td>
                            <td>{{ $internship->evaluation->presentasi }}</td>
                        </tr>
                        <tr class="table-success">
                            <td><strong>Nilai Akhir</strong></td>
                            <td><strong>{{ $internship->evaluation->nilai_akhir }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Form Feedback (tersembunyi pada awalnya) -->
            <div id="feedback-form" class="mt-5" style="display: none;">
                <h4 class="mb-3">Beri Feedback terhadap Perusahaan</h4>

                <!-- Form Feedback -->
                <form action="{{ route('student/evaluation.store') }}" method="POST">
                    @csrf

                    <!-- Textarea komentar -->
                    <div class="form-group">
                        <label for="komentar">Komentar Anda</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="5"
                            placeholder="Tuliskan komentar Anda mengenai pengalaman di perusahaan..." required></textarea>
                    </div>

                    <!-- Tombol submit -->
                    <button type="submit" class="mt-2 btn btn-success">
                        <i class="fas fa-paper-plane"></i> Kirim Feedback
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- JavaScript untuk memunculkan form feedback -->
    <script>
        document.getElementById('show-feedback-form')?.addEventListener('click', function() {
            document.getElementById('feedback-form').style.display = 'block'; // Menampilkan form feedback
            this.style.display = 'none'; // Menyembunyikan tombol setelah diklik
        });
    </script>
@endsection
