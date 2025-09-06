@extends('layouts.teacher.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="container my-5">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Detail Logbook</h5>
                <a href="javascript:history.back()" class="btn btn-light">Kembali</a>
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
                            <img src="{{ asset('storage/public/foto-kegiatan/' . $logbook->foto_kegiatan) }}" height="200"
                                width="200" class="img-fluid rounded" alt="Foto Kegiatan" style="cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="showImageInModal(this)">
                        @else
                            <p class="text-muted">Tidak ada foto kegiatan</p>
                        @endif
                    </div>
                </div>
                <hr class="my-0 mt-4" />
                <h6 class="fw-bold mt-2 text-center">Komentar Logbook</h6>
                <!-- Komentar Pembimbing (GURU) -->
                <div class="row mb-3 mt-2">
                    <div class="col-md-4"><strong>Komentar Pembimbing</strong></div>
                    <div class="col-md-8">
                        {{ $noteGuru->catatan ?? 'Belum diisi' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Penilaian Pembimbing</strong></div>
                    <div class="col-md-8">
                        {{ $noteGuru ? $noteGuru->penilaian : 'Belum diisi' }}
                    </div>
                </div>

                <!-- Komentar Instruktur (INSTRUKTUR) -->
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Komentar Instruktur</strong></div>
                    <div class="col-md-8">
                        {{ $noteInstruktur ? $noteInstruktur->catatan : 'Belum diisi' }}
                    </div>
                </div>
            </div>
            @if (empty($noteGuru->catatan))
                <div class="card-footer text-center">
                    <button id="commentButton" class="btn btn-warning">Beri Komentar</button>
                </div>
            @else
                <div class="card-footer text-center">
                    <button id="EditcommentButton" class="btn btn-warning">Edit Komentar</button>
                </div>
            @endif
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



    @if (empty($noteGuru->catatan))
        <!-- New Comment Form -->
        <div id="commentForm" class="card mx-auto mt-4" style="max-width: 800px; display: none;">
            <div class="card-body">
                <form action="{{ route('teacher/bimbingan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="logbook_id" value="{{ $logbook->id }}">
                    <input type="hidden" name="note_type" value="GURU">

                    <div class="mb-3">
                        <label for="catatan" class="form-label"><strong>Komentar</strong></label>
                        <textarea name="catatan" id="newCatatan" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="penilaian" class="form-label"><strong>Penilaian</strong></label>
                        <select name="penilaian" id="newPenilaian" class="form-select">
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}">{{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan Komentar</button>
                        <button type="button" id="cancelNewComment" class="btn btn-secondary">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <!-- Edit Comment Form -->
        <div id="EditcommentForm" class="card mx-auto mt-4" style="max-width: 800px; display: none;">
            <div class="card-body">
                <form action="{{ route('teacher/bimbingan.update', $noteGuru->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="catatan" class="form-label"><strong>Komentar</strong></label>
                        <textarea name="catatan" id="editCatatan" class="form-control" rows="4">{{ old('catatan', $noteGuru->catatan) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="penilaian" class="form-label"><strong>Penilaian</strong></label>
                        <select name="penilaian" id="editPenilaian" class="form-select">
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}"
                                    {{ $noteGuru->penilaian == $grade ? 'selected' : '' }}>
                                    {{ $grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan Komentar</button>
                        <button type="button" id="cancelEditComment" class="btn btn-secondary">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        const commentButton = document.getElementById('commentButton');
        const editCommentButton = document.getElementById('EditcommentButton');
        const commentForm = document.getElementById('commentForm');
        const editCommentForm = document.getElementById('EditcommentForm');
        const cancelNewComment = document.getElementById('cancelNewComment');
        const cancelEditComment = document.getElementById('cancelEditComment');

        if (commentButton) {
            commentButton.addEventListener('click', () => {
                commentForm.style.display = 'block';
                editCommentForm.style.display = 'none';
            });
        }

        if (editCommentButton) {
            editCommentButton.addEventListener('click', () => {
                editCommentForm.style.display = 'block';
                commentForm.style.display = 'none';
            });
        }

        if (cancelNewComment) {
            cancelNewComment.addEventListener('click', () => {
                commentForm.style.display = 'none';
            });
        }

        if (cancelEditComment) {
            cancelEditComment.addEventListener('click', () => {
                editCommentForm.style.display = 'none';
            });
        }

        function showImageInModal(image) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = image.src;
        }
    </script>
@endsection
