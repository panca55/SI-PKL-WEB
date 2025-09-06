@extends('layouts.student.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="container my-5">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Detail Logbook</h5>
                <a href="{{ route('student/logbook.index') }}" class="btn btn-light">Kembali</a>
            </div>
            <div class="card-body mt-2">
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Judul Pekerjaan</strong></div>
                    <div class="col-md-8">{{ $logbook->judul }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kategori</strong></div>
                    <div class="col-md-8">{{ $logbook->category }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Tanggal</strong></div>
                    <div class="col-md-8">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d M Y') }}</div>
                </div>

                @if ($logbook->category == 'KOMPETENSI')
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Bentuk Kegiatan</strong></div>
                        <div class="col-md-8">{{ $logbook->bentuk_kegiatan }}</div>
                    </div>
                @else
                    <div class="row mb-3">
                        <div class="col-md-4"><strong>Penugasan Kegiatan</strong></div>
                        <div class="col-md-8">{{ $logbook->penugasan_kegiatan }}</div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Waktu Pekerjaan</strong></div>
                    <div class="col-md-8">
                        Mulai Jam {{ Carbon::parse($logbook->mulai)->format('H:i') }} <br>
                        Selesai Jam {{ Carbon::parse($logbook->selesai)->format('H:i') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Petugas</strong></div>
                    <div class="col-md-8">{{ $logbook->petugas }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Deskripsi Pekerjaan</strong></div>
                    <div class="col-md-8">{!! $logbook->isi !!}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Keterangan</strong></div>
                    <div class="col-md-8">{{ $logbook->keterangan }}</div>
                </div>

                <div class="row">
                    <div class="col-md-4"><strong>Foto Kegiatan</strong></div>
                    <div class="col-md-8">
                        @if ($logbook->foto_kegiatan)
                            <img src="{{ asset('storage/public/foto-kegiatan/' . $logbook->foto_kegiatan) }}"
                                class="img-fluid rounded" alt="Foto Kegiatan" style="cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showImageInModal(this)">
                        @else
                            <p class="text-muted">Tidak ada foto kegiatan</p>
                        @endif
                    </div>
                </div>
                <!-- Komentar Guru dan Instruktur-->
                <hr>
                <div class="row mb-3 mt-4">
                    <div class="col-md-4"><strong>Komentar Guru Pembimbing</strong></div>
                    <div class="col-md-8">{{ $noteGuru->catatan ?? 'Belum diisi' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Penilaian Guru Pembimbing</strong></div>
                    <div class="col-md-8">{{ $noteGuru ? $noteGuru->penilaian : 'Belum diisi' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Komentar Instruktur</strong></div>
                    <div class="col-md-8">{{ $noteInstruktur ? $noteInstruktur->catatan : 'Belum diisi' }}</div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('student/internship.edit', $logbook->id) }}" class="btn btn-warning">Edit Logbook</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Foto Kegiatan">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImageInModal(element) {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = element.src;
        }
    </script>
@endsection
