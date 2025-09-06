@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah Data PKL</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/internship.store') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="kelas" class="form-label col-sm-2 mt-2">Kelas</label>
                    <div class="col-sm-10">
                        <select name="kelas" id="kelas" class="form-select" onchange="filterStudentsByClass()">
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="student_id" class="form-label col-sm-2 mt-2">Siswa</label>
                    <div class="col-sm-10">
                        <select name="student_id" id="student_id" class="form-select select2">
                            <option value="">Pilih Siswa</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" data-class="{{ $student->mayor_id }}">
                                    {{ $student->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="corporation_id" class="form-label col-sm-2 mt-2">Perusahaan</label>
                    <div class="col-sm-10">
                        <select class="form-select select2" id="corporation_id" name="corporation_id">
                            <option value="">Pilih Perusahaan</option>
                            @foreach ($corporations as $corporation)
                                <option value="{{ $corporation->id }}">{{ $corporation->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="teacher_id" class="form-label col-sm-2 mt-2">Guru Pembimbing</label>
                    <div class="col-sm-10">
                        <select class="form-select select2" id="teacher_id" name="teacher_id">
                            <option value="">Pilih Guru Pembimbing</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tahun_ajaran" class="form-label col-sm-2 mt-2">Periode</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example"
                            name="tahun_ajaran">
                            <option selected>Pilih</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2020;
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                <option value="{{ $year }}/{{ $year + 1 }}">
                                    {{ $year }}/{{ $year + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_mulai">Tanggal Mulai</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder=""
                            required value="{{ old('tanggal_mulai') }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_berakhir">Tanggal Berakhir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir"
                            placeholder="" required value="{{ old('tanggal_berakhir') }}" />
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
        function filterStudentsByClass() {
            var selectedClass = document.getElementById('kelas').value;
            var studentSelect = document.getElementById('student_id');
            var students = studentSelect.querySelectorAll('option');

            students.forEach(function(student) {
                if (student.getAttribute('data-class') == selectedClass || student.value == '') {
                    student.style.display = 'block';
                } else {
                    student.style.display = 'none';
                }
            });

            studentSelect.value = '';
        }

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih...",
                allowClear: true
            });
        });
    </script>
@endsection
