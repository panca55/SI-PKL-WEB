@extends('layouts.teacher.main')

@section('content')
    <div class="card p-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Penilaian Akhir Siswa</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('teacher/evaluation.store') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="internship_id" id="internship_id" value="{{ $internship->id }}">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">1. Penilaian Monitoring</label>
                    <div class="col-sm-5">
                        <input type="number" name="monitoring" id="monitoring" min="0" max="100"
                            class="form-control" placeholder="0-100" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">2. rata-rata nilai sertifikat pkl</label>
                    <div class="col-sm-5">
                        <input type="number" name="sertifikat" id="sertifikat" min="0" max="100"
                            class="form-control" placeholder="0-100" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">3. Laporan PKL</label>
                    <div class="col-sm-5">
                        <input type="number" name="logbook" id="logbook" min="0" max="100"
                            class="form-control" placeholder="0-100" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">4. Presentasi</label>
                    <div class="col-sm-5">
                        <input type="number" name="presentasi" id="presentasi" min="0" max="100"
                            class="form-control" placeholder="0-100" />
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
@endsection
