@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Data PKL</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/internship.update', $internship) }}" autocomplete="off"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="row mb-3" hidden>
                    <label for="student_id" class="form-label col-sm-2 mt-2">Siswa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="student_id" name="student_id" readonly
                            value="{{ $internship->student->id }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="student_id" class="form-label col-sm-2 mt-2">Siswa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly value="{{ $internship->student->nama }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="corporation_id" class="form-label col-sm-2 mt-2">Perusahaan</label>
                    <div class="col-sm-10">
                        <select class="select2 form-select" id="corporation_id" name="corporation_id">
                            <option disabled>Pilih</option>
                            @foreach ($corporations as $corporation)
                                <option value="{{ $corporation->id }}"
                                    {{ $corporation->id == $internship->corporation_id ? 'selected' : '' }}>
                                    {{ $corporation->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="teacher_id" class="form-label col-sm-2 mt-2">Guru Pembimbing</label>
                    <div class="col-sm-10">
                        <select class="select2 form-select" id="teacher_id" name="teacher_id">
                            <option disabled>Pilih</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ $teacher->id == $internship->teacher_id ? 'selected' : '' }}>
                                    {{ $teacher->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tahun_ajaran" class="form-label col-sm-2 mt-2">Tahun Ajaran</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="tahun_ajaran">
                            <option>Pilih</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2016;
                                $selectedYear = explode('/', $internship->tahun_ajaran)[0];
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                <option value="{{ $year }}/{{ $year + 1 }}"
                                    {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}/{{ $year + 1 }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_mulai">Tanggal Mulai</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required
                            value="{{ $internship->tanggal_mulai }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_berakhir">Tanggal Berakhir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" required
                            value="{{ $internship->tanggal_berakhir }}">
                    </div>
                </div>

                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-sm btn-success mt-3">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const periodeSelect = document.getElementById('periode');
            const tahunSelect = document.getElementById('tahun');
            const tahunAjaranInput = document.getElementById('tahun_ajaran');

            function updateTahunAjaran() {
                const periode = periodeSelect.value;
                const tahun = tahunSelect.value;
                if (periode && tahun) {
                    tahunAjaranInput.value = `${periode} ${tahun}`;
                } else {
                    tahunAjaranInput.value = '';
                }
            }

            periodeSelect.addEventListener('change', updateTahunAjaran);
            tahunSelect.addEventListener('change', updateTahunAjaran);
        });
    </script>
@endsection
