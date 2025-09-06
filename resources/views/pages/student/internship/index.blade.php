@extends('layouts.student.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card p-0 mb-6">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-6">
            <div class="card-body py-0 pt-6 mx-4 my-4 ps-12">
                <img src="{{ asset('/assets/img/illustrations/bulb-light.png') }}" class="img-fluid scaleX-n1-rtl"
                    alt="Bulb in hand" data-app-light-img="illustrations/bulb-light.png"
                    data-app-dark-img="illustrations/bulb-dark.png" height="60" />
            </div>
            <div class="card-body d-flex align-items-md-center flex-column text-md-center mb-6 py-6">
                <span class="card-title mb-4 px-md-12 h4">
                    Laksanakan PRAKTEK KERJA LAPANGAN dengan JUJUR, KREATIF, INOVATIF
                    <span class="text-primary text-nowrap">All in one place</span>.
                </span>
                <p class="mb-4">
                    Tumbuhkan keterampilanmu dengan semangat, kejujuran, kreativitas, dan inovasi melalui pelaksanaan
                    praktek kerja lapangan industri yang terpercaya dan berkualitas.
                </p>
            </div>
            <div class="d-flex align-items-end justify-content-end">
                <img src="{{ asset('/assets/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket" height="180"
                    class="scaleX-n1-rtl" />
            </div>
        </div>
    </div>
    @if ($status == 'before')
        <h1 class="text-center fw-bold mt-5">Belum Masa PKL</h1>
    @elseif ($status == 'during')
        <!-- Attendance Modal -->
        <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="attendanceForm" action="{{ route('student/internship.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="attendanceModalLabel">Absensi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="attendanceStatus" class="form-label">Keterangan</label>
                                <select class="form-select" id="attendanceStatus" name="keterangan" required>
                                    <option value="HADIR">Hadir</option>
                                    <option value="IZIN">Izin</option>
                                    <option value="SAKIT">Sakit</option>
                                </select>
                            </div>
                            <div id="photoCapture" class="mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <div>
                                    <video id="video" width="100%" height="auto" autoplay></video>
                                    <button type="button" id="snap" class="btn btn-primary mt-2">Ambil
                                        Foto</button>
                                    <canvas id="canvas" style="display: none;"></canvas>
                                    <input type="hidden" id="photo" name="photo">
                                </div>
                            </div>
                            <div id="fileInput" class="mb-3" style="display: none;">
                                <label for="file" class="form-label">Surat Izin Orang Tua/Dokter <span
                                        class="text-danger">*WAJIB SCAN SURAT IZIN</span></label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <input type="hidden" name="internship_id" value="{{ $internship->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                            <h5 class="mb-2 mb-sm-0">Persentase Kehadiran</h5>
                            <div class="text-center text-sm-end">
                                <h6 class="mb-1">{{ date('l, d F Y') }}</h6>
                                <h6 id="current-time" class="mb-0"></h6>
                            </div>
                        </div>
                        <h5 class="text-center mt-1">Absensi dapat diisi mulai pukul
                            {{ Carbon::parse($internship->corporation->jam_mulai)->format('H:i') }} sampai
                            {{ Carbon::parse($internship->corporation->jam_berakhir)->format('H:i') }}.</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Bagian gambar ilustrasi pertama -->
                            <div class="col-md-4 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                                <img src="{{ asset('/assets/img/illustrations/juicy-classroom-with-school-supplies-stationery-globe-backpack.png') }}"
                                    alt="juicy-classroom-with-school-supplies-stationery-globe-backpack" class="img-fluid"
                                    style="max-height: 180px;" />
                            </div>

                            <!-- Bagian absensi dan persentase kehadiran -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                @if ($todayAbsence)
                                    <div class="alert alert-info" role="alert">
                                        Anda sudah mengisi absensi untuk hari ini.
                                    </div>
                                @elseif ($jamKerja)
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#attendanceModal">
                                        Tambah Absensi
                                    </button>
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        Absensi hanya dapat dilakukan pada jam kerja.
                                    </div>
                                @endif
                                <h6>{{ number_format($attendancePercentage) }} % Kehadiran</h6>
                                <ul class="list-unstyled">
                                    <li>Hadir: {{ $attendanceDetails['HADIR'] }}</li>
                                    <li>Izin: {{ $attendanceDetails['IZIN'] }}</li>
                                    <li>Sakit: {{ $attendanceDetails['SAKIT'] }}</li>
                                    <li>Alpha: {{ $attendanceDetails['ALPHA'] }}</li>
                                </ul>

                                <!-- Button Lihat Detail Absensi -->
                                <a href="{{ route('student/attendanceDetail') }}" class="btn btn-success mt-3">Lihat
                                    detail
                                    absensi</a>
                            </div>

                            <!-- Bagian gambar ilustrasi kedua -->
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('/assets/img/illustrations/3d-fluency-pencil-and-ruler.png') }}"
                                    alt="3d-fluency-pencil-and-ruler" class="img-fluid" style="max-height: 180px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <style>
            @media (max-width: 767px) {
                .card-header {
                    text-align: center;
                }

                .card-body .row {
                    flex-direction: column-reverse;
                }

                .card-body .col-md-4:last-child {
                    margin-bottom: 1rem;
                }
            }
        </style>


        <!-- Tabel Logbook -->
        <div class="card p-4">
            <h5 class="card-header p-0 mb-4">
                Tambah Jurnal Harian
                @if ($cekHadir)
                    <span><a href="{{ route('student/internship.create') }}" id="addLogbookBtn"
                            class="text-decoration-none mx-2"><i class='display-5 bx bxs-comment-add'></i></a></span>
                @endif
            </h5>
            <div class="table-responsive text-nowrap">
                <table id="example" class="table">
                    <thead>
                        <tr class="text-nowrap bg-primary">
                            <th class="text-white">No</th>
                            <th class="text-white">Tanggal</th>
                            <th class="text-white">Kategori Kegiatan</th>
                            <th class="text-white">Judul Kegiatan</th>
                            <th class="text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logbooks as $logbook)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ Carbon::Parse($logbook->tanggal)->format('d M Y') }}</td>
                                <td>{{ $logbook->category }}</td>
                                <td>{{ $logbook->judul }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('student/internship.show', $logbook) }}">
                                                <i class="bx bx-show-alt me-1"></i>
                                                Lihat
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('student/internship.edit', $logbook) }}">
                                                <i class="bx bx-edit-alt me-1"></i>
                                                Edit
                                            </a>
                                            <button type="submit" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="bx bx-trash me-1"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p>Are you sure to delete?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('student/internship.destroy', $logbook) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Yes
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif ($status == 'after')
        <h1 class="text-center fw-bold mt-5">Masa PKL telah berakhir</h1>
    @else
        <h1 class="text-center fw-bold mt-5">Data PKL tidak ditemukan</h1>
    @endif



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const snap = document.getElementById('snap');
            const photoInput = document.getElementById('photo');
            const attendanceStatus = document.getElementById('attendanceStatus');
            const photoCapture = document.getElementById('photoCapture');
            const fileInput = document.getElementById('fileInput');
            const attendanceForm = document.getElementById('attendanceForm');
            let isSubmitting = false;

            // Inisialisasi Bootstrap Modal
            const attendanceModal = new bootstrap.Modal(document.getElementById('attendanceModal'), {
                keyboard: false
            });

            // Event Listener untuk Perubahan Status Absensi
            attendanceStatus.addEventListener('change', function() {
                if (this.value === 'HADIR') {
                    photoCapture.style.display = 'block';
                    fileInput.style.display = 'none';
                } else if (this.value === 'IZIN' || this.value === 'SAKIT') {
                    photoCapture.style.display = 'none';
                    fileInput.style.display = 'block';
                } else {
                    photoCapture.style.display = 'none';
                    fileInput.style.display = 'none';
                }
            });

            // Event Listener untuk Menampilkan Modal dan Akses Kamera
            attendanceModal._element.addEventListener('show.bs.modal', () => {
                console.log('Modal is shown, trying to access the camera...');
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        video.srcObject = stream;
                        console.log('Camera accessed successfully.');
                    })
                    .catch(err => {
                        console.error('Error accessing camera: ' + err);
                        alert(
                            'Gagal mengakses kamera. Pastikan kamera Anda terhubung dan izin diberikan.');
                    });
            });

            // Event Listener untuk Menutup Modal dan Menghentikan Kamera
            attendanceModal._element.addEventListener('hidden.bs.modal', () => {
                const stream = video.srcObject;
                if (stream) {
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                    console.log('Camera stream stopped.');
                }
                // Reset form dan status submit saat modal ditutup
                attendanceForm.reset();
                isSubmitting = false;
                enableSubmitButton();
                photoInput.value = ''; // Clear any previously captured photo
            });

            // Event Listener untuk Mengambil Foto
            snap.addEventListener('click', () => {
                console.log('Snap button clicked.');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Validate the captured image
                canvas.toBlob((blob) => {
                    if (blob && blob.size > 0) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = new Image();
                            img.onload = function() {
                                if (img.width > 0 && img.height > 0) {
                                    console.log(
                                        'Photo captured successfully and validated.');
                                    photoInput.value = canvas.toDataURL('image/png');
                                    alert('Foto berhasil diambil.');
                                } else {
                                    console.error('Captured image is invalid.');
                                    alert(
                                        'Foto yang diambil tidak valid. Silakan coba lagi.');
                                    photoInput.value = '';
                                }
                            };
                            img.onerror = function() {
                                console.error('Error loading captured image.');
                                alert(
                                    'Terjadi kesalahan saat memproses foto. Silakan coba lagi.');
                                photoInput.value = '';
                            };
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(blob);
                    } else {
                        console.error('Failed to capture photo.');
                        alert('Gagal mengambil foto. Silakan coba lagi.');
                        photoInput.value = '';
                    }
                }, 'image/png');
            });

            // Fungsi untuk menonaktifkan tombol submit
            function disableSubmitButton() {
                const submitButton = attendanceForm.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            }

            // Fungsi untuk mengaktifkan tombol submit
            function enableSubmitButton() {
                const submitButton = attendanceForm.querySelector('button[type="submit"]');
                submitButton.disabled = false;
                submitButton.innerHTML = 'Simpan';
            }

            // Event Listener untuk Submit Form Absensi
            attendanceForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                // Cek apakah form sedang dalam proses submit
                if (isSubmitting) {
                    console.log('Form is already being submitted');
                    return;
                }

                // Check if a photo is required and has been taken
                if (attendanceStatus.value === 'HADIR' && !photoInput.value) {
                    alert('Silakan ambil foto terlebih dahulu.');
                    return;
                }

                try {
                    // Set flag submit menjadi true
                    isSubmitting = true;
                    disableSubmitButton();

                    const formData = new FormData(attendanceForm);
                    const response = await fetch(attendanceForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert('Absensi berhasil disimpan.');
                        attendanceModal.hide();
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Gagal menyimpan absensi');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                } finally {
                    // Reset flag submit
                    isSubmitting = false;
                    enableSubmitButton();
                }
            });

            // Fungsi untuk Update Jam
            function updateClock() {
                const now = new Date();
                const currentTime = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                document.getElementById('current-time').innerText = currentTime;
            }

            setInterval(updateClock, 1000);
            updateClock();
        });
    </script>
@endsection
