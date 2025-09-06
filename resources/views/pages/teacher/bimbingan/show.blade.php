@extends('layouts.teacher.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card p-4">
        <div class="row">
            <!-- Card Informasi Siswa -->
            <div class="col-md-12 mb-4 info-siswa">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="text-white ms-1 mt-1">Informasi Siswa</h4>
                        <span class="badge bg-white text-primary">
                            Kehadiran: {{ number_format($attendancePercentage) }}%
                        </span>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row align-items-center">
                            <!-- Bagian Gambar -->
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <img src="{{ asset('storage/public/Students-images/' . $internship->student->foto) }}"
                                    alt="Foto Siswa" class="img-fluid rounded-circle" style="max-width: 150px;">
                            </div>
                            <!-- Bagian Informasi -->
                            <div class="col-md-8">
                                <h5 class="card-title mb-3">{{ $internship->student->nama }}</h5>
                                <p class="card-text"><strong>Perusahaan:</strong> {{ $internship->corporation->nama }}</p>
                                <p class="card-text"><strong>Alamat:</strong> {{ $internship->corporation->alamat }}</p>
                                <p class="card-text"><strong>Instruktur:</strong>
                                    {{ $internship->instructor->nama ?? 'Belum diisi' }}</p>
                                <p class="card-text"><strong>No HP Instruktur:</strong>
                                    {{ $internship->instructor->hp ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card Absensi Harian -->
                <div class="col-md-12 mb-4 absensi">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h4 class="text-white ms-1 mt-1">Absensi Siswa</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($absents as $absent)
                                            <tr>
                                                <td>{{ Carbon::parse($absent->created_at)->format('d M Y H:i') }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $absent->keterangan == 'HADIR' ? 'bg-success' : ($absent->keterangan == 'IZIN' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ $absent->keterangan }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($absent->keterangan == 'HADIR' && $absent->photo)
                                                        <img src="{{ asset('storage/Absents-Siswa/' . $absent->photo) }}"
                                                            alt="Foto Kehadiran" height="50" width="50"
                                                            class="img-thumbnail cursor-pointer" data-bs-toggle="modal"
                                                            data-bs-target="#fotoModal" onclick="showImageInModal(this)">
                                                    @elseif (in_array($absent->keterangan, ['IZIN', 'SAKIT']) && $absent->deskripsi)
                                                        <img src="{{ asset('storage/' . $absent->deskripsi) }}"
                                                            alt="Surat Izin/Sakit" height="50" width="50"
                                                            class="img-thumbnail cursor-pointer" data-bs-toggle="modal"
                                                            data-bs-target="#fotoModal" onclick="showImageInModal(this)">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">
                                                    Belum ada absensi untuk hari ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Absensi -->
                            @if ($absents->hasPages())
                                <div class="d-flex justify-content-center mt-4" id="absent-pagination">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($absents->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">«</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $absents->previousPageUrl() }}"
                                                        rel="prev">«</a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($absents->getUrlRange(1, $absents->lastPage()) as $page => $url)
                                                @if ($page == $absents->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($absents->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $absents->nextPageUrl() }}"
                                                        rel="next">»</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">»</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Logbook -->
                <div class="col-md-12 mb-4 logbook">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h4 class="text-white ms-1 mt-1">Jurnal Siswa</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4 mt-2" id="logbook-container">
                                @forelse ($logbooks as $logbook)
                                    <div class="col-md-4">
                                        <div class="card logbook-card shadow-sm h-100">
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title fw-bold text-primary mb-3">{{ $logbook->judul }}</h6>
                                                <div class="card-text mb-2 flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-calendar3 me-2"></i>
                                                        <span>{{ Carbon::parse($logbook->tanggal)->format('d M Y') }}</span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong>Bentuk Kegiatan:</strong>
                                                        <p class="mb-1">{{ $logbook->bentuk_kegiatan }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <strong>Keterangan:</strong>
                                                        <p class="mb-1">{{ Str::limit($logbook->keterangan, 100) }}</p>
                                                    </div>
                                                </div>
                                                @if ($logbook->foto_kegiatan)
                                                    <div class="mb-3">
                                                        <p class="fw-bold mb-2">Foto Kegiatan:</p>
                                                        <img src="{{ asset('storage/public/foto-kegiatan/' . $logbook->foto_kegiatan) }}"
                                                            height="80" width="80" alt="Foto Kegiatan"
                                                            class="img-thumbnail rounded cursor-pointer"
                                                            data-bs-toggle="modal" data-bs-target="#fotoModal"
                                                            onclick="showImageInModal(this)">
                                                    </div>
                                                @endif
                                                <div class="mt-auto">
                                                    <a href="{{ route('teacher/detailLogbook', $logbook->id) }}"
                                                        class="btn btn-primary btn-sm w-100">
                                                        <i class="bi bi-eye-fill me-1"></i> Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-info text-center" role="alert">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Belum ada logbook yang ditambahkan.
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination Logbook -->
                            @if ($logbooks->hasPages())
                                <div class="d-flex justify-content-center mt-4" id="logbook-pagination">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            {{-- Previous Page Link --}}
                                            @if ($logbooks->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">«</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $logbooks->previousPageUrl() }}"
                                                        rel="prev">«</a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($logbooks->getUrlRange(1, $logbooks->lastPage()) as $page => $url)
                                                @if ($page == $logbooks->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link"
                                                            href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($logbooks->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $logbooks->nextPageUrl() }}"
                                                        rel="next">»</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">»</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for displaying images -->
        <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid rounded" alt="Foto Kegiatan">
                    </div>
                </div>
            </div>
        </div>

        <style>
            .card {
                border: none;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                margin-bottom: 1rem;
            }

            .card-header {
                padding: 1rem;
                border-bottom: none;
            }

            .info-siswa .card-header {
                background-color: #0d6efd;
            }

            .absensi .card-header {
                background-color: #198754;
            }

            .absensi .page-item.active .page-link {
                background-color: #198754;
                border-color: #198754;
                color: #fff;
            }

            .absensi .page-link {
                color: #198754;
            }

            .absensi .page-link:hover {
                color: #0f5132;
                background-color: #e9ecef;
            }

            .logbook .card-header {
                background-color: #ffc107;
            }

            .logbook .page-item.active .page-link {
                background-color: #ffc107;
                border-color: #ffc107;
                color: #000;
            }

            .logbook .page-link {
                color: #ffc107;
            }

            .logbook .page-link:hover {
                color: #000;
                background-color: #ffecb5;
            }

            .logbook-card {
                transition: transform 0.2s ease-in-out;
            }

            .logbook-card:hover {
                transform: translateY(-5px);
            }

            .cursor-pointer {
                cursor: pointer;
            }

            .img-thumbnail {
                transition: transform 0.2s ease-in-out;
            }

            .img-thumbnail:hover {
                transform: scale(1.05);
            }
        </style>

        <script>
            // Function untuk menampilkan gambar di modal
            function showImageInModal(element) {
                var modalImage = document.getElementById('modalImage');
                modalImage.src = element.src;
            }

            // Handle pagination dengan AJAX untuk absensi
            $(document).on('click', '#absent-pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $.get(url, function(data) {
                    // Replace only the absensi part and pagination
                    var newAbsensiTable = $(data).find('.absensi .table-responsive').html();
                    var newAbsentPagination = $(data).find('#absent-pagination').html();

                    $('.absensi .table-responsive').html(newAbsensiTable);
                    $('#absent-pagination').html(newAbsentPagination);
                });
            });

            // Handle pagination dengan AJAX untuk logbook
            $(document).on('click', '#logbook-pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                $.get(url, function(data) {
                    // Replace only the logbook part and pagination
                    var newLogbookContainer = $(data).find('#logbook-container').html();
                    var newLogbookPagination = $(data).find('#logbook-pagination').html();

                    $('#logbook-container').html(newLogbookContainer);
                    $('#logbook-pagination').html(newLogbookPagination);
                });
            });
        </script>
    @endsection
