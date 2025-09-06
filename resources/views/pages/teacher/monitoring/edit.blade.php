@extends('layouts.teacher.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Penilaian Monitoring</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('teacher/assessment.update', $assessment->id) }}" autocomplete="off">
                @csrf
                @method('PUT') {{-- Method spoofing untuk update data --}}

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama Penilaian</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ $assessment->nama }}" placeholder="Penilaian Ke-1" />
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">1. Menerapkan <i>soft skills</i> yang dibutuhkan dalam dunia
                        kerja
                        (tempat PKL)</label>
                    <div class="col-sm-5">
                        <input type="number" name="softskill" id="softskill" min="0" max="100"
                            class="form-control" value="{{ $assessment->softskill }}" />
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="deskripsi_softskill" id="deskripsi_softskill" class="form-control"
                            value="{{ $assessment->deskripsi_softskill }}"
                            placeholder="(Dipindah dari lembar observasi PKL peserta didik)" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">2. Menerapkan norma, POS dan K3LH yang ada pada dunia kerja
                        (tempat PKL)</label>
                    <div class="col-sm-5">
                        <input type="number" name="norma" id="norma" min="0" max="100"
                            class="form-control" value="{{ $assessment->norma }}" />
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="deskripsi_norma" id="deskripsi_norma" class="form-control"
                            value="{{ $assessment->deskripsi_norma }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">3. Menerapkan kompetensi teknis yang sudah dipelajari di sekolah
                        dan/atau baru dipelajari pada dunia kerja (tempat PKL)</label>
                    <div class="col-sm-5">
                        <input type="number" name="teknis" id="teknis" min="0" max="100"
                            class="form-control" value="{{ $assessment->teknis }}" />
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="deskripsi_teknis" id="deskripsi_teknis" class="form-control"
                            value="{{ $assessment->deskripsi_teknis }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">4. Memahami alur bisnis dunia kerja tempat PKL</label>
                    <div class="col-sm-5">
                        <input type="number" name="pemahaman" id="pemahaman" min="0" max="100"
                            class="form-control" value="{{ $assessment->pemahaman }}" />
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="deskripsi_pemahaman" id="deskripsi_pemahaman" class="form-control"
                            value="{{ $assessment->deskripsi_pemahaman }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">5. Catatan</label>
                    <div class="col-sm-5">
                        <input type="text" name="catatan" id="catatan" class="form-control"
                            value="{{ $assessment->catatan }}" />
                    </div>
                    <div class="col-sm-2">
                        <input type="number" name="score" id="score" min="0" max="100"
                            class="form-control" value="{{ $assessment->score }}" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="deskripsi_catatan" id="deskripsi_catatan" class="form-control"
                            value="{{ $assessment->deskripsi_catatan }}" />
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
@endsection
