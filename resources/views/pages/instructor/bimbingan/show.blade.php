@extends('layouts.corporation.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card p-4">
        <div class="row">
            <!-- Card Informasi Siswa -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Informasi Siswa
                    </div>
                    <div class="card-body mt-2">
                        <h5 class="card-title fw-bold">{{ $internship->student->nama }}</h5>
                        <p class="card-text">Guru Pembimbing: {{ $internship->teacher->nama }}</p>
                        <p class="card-text">Email Guru Pembimbing: {{ $internship->teacher->user->email }}</p>
                        <p class="card-text">No Hp Guru Pembimbing: {{ $internship->teacher->hp }}</p>
                        <p class="card-text">Persentase Kehadiran:
                            <strong>{{ number_format($attendancePercentage) }}%</strong>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card Absensi Harian -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Absensi Harian
                    </div>
                    <div class="card-body">
                        @forelse ($absents as $absent)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Tanggal:
                                        {{ Carbon::parse($absent->absent)->format('d M Y H:i') }}</h6>
                                    <p class="card-text">Keterangan: {{ $absent->keterangan }}</p>
                                    @if ($absent->keterangan == 'HADIR' && $absent->photo)
                                        {{-- Menampilkan foto kehadiran jika keterangan HADIR --}}
                                        <p class="card-text">Foto Kehadiran:</p>
                                        <img src="{{ asset('storage/Absents-Siswa/' . $absent->photo) }}"
                                            alt="Foto Kehadiran" height="80" width="80"
                                            class="img-fluid rounded cursor-pointer" data-bs-toggle="modal"
                                            data-bs-target="#fotoModal" onclick="showImageInModal(this)">
                                    @elseif (in_array($absent->keterangan, ['IZIN', 'SAKIT']) && $absent->deskripsi)
                                        {{-- Menampilkan surat izin/sakit --}}
                                        <p class="card-text">Surat Izin/Sakit:</p>
                                        <img src="{{ asset('storage/' . $absent->deskripsi) }}" alt="Surat Izin/Sakit"
                                            height="80" width="80" class="img-fluid rounded cursor-pointer"
                                            data-bs-toggle="modal" data-bs-target="#fotoModal"
                                            onclick="showImageInModal(this)">
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada absensi untuk hari ini.</p>
                        @endforelse

                        <!-- Pagination -->
                        {{ $absents->links() }}
                    </div>
                </div>
            </div>

            <!-- Card Logbook -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-warning text-white mb-4">
                        Logbook Siswa
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($logbooks as $logbook)
                                <div class="col-md-4 mb-4"> <!-- Setiap logbook ditampilkan dalam kolom -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Judul: {{ $logbook->judul }}</h6>
                                            <p class="card-text">Tanggal:
                                                {{ Carbon::parse($logbook->tanggal)->format('d M Y') }}</p>
                                            <p class="card-text">Bentuk Kegiatan: {{ $logbook->bentuk_kegiatan }}</p>
                                            <p class="card-text">Keterangan: {{ $logbook->keterangan }}</p>
                                            @if ($logbook->foto_kegiatan)
                                                <p class="card-text">Foto Kegiatan:</p>
                                                <img src="{{ asset('storage/public/foto-kegiatan/' . $logbook->foto_kegiatan) }}"
                                                    height="80" width="80" alt="Foto Kegiatan"
                                                    class="img-fluid rounded" style="cursor: pointer;"
                                                    data-bs-toggle="modal" data-bs-target="#fotoModal"
                                                    onclick="showImageInModal(this)">
                                            @endif
                                            <div class="d-flex justify-content-end mt-3">
                                                <a href="{{ route('instructor/detailLogbook', $logbook->id) }}"
                                                    class="btn btn-primary btn-sm">Lihat</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Belum ada logbook yang ditambahkan.</p>
                            @endforelse
                        </div>
                        <!-- Pagination -->
                        {{ $logbooks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


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
