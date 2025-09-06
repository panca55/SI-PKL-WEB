@extends('layouts.corporation.main')

@section('content')
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-white">Selamat datang, {{ auth()->user()->name }}!</h5>
                            <p class="mb-4">
                                Di sini Anda dapat mengelola magang, melihat kemajuan siswa, dan menginformasikan lowongan
                                pekerjaan.
                            </p>
                            <a href="{{ route('corporation/profile.index') }}" class="btn btn-sm btn-outline-light">View
                                Profile</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('/assets/img/illustrations/corporation-welcome.png') }}" height="140"
                                alt="Welcome Image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($internships && count($internships) > 0)
        <!-- Cards for Internship Students and Instructors -->
        <div class="row">
            <!-- Internship Students -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Siswa PKL</h5>
                        <i class="bx bx-user-circle fs-2 text-primary"></i>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="fw-bold list-group-item">
                                <div class="row">
                                    <div class="col">Nama Siswa</div>
                                    <div class="col">Jurusan</div>
                                    <div class="col">Instruktur</div>
                                </div>
                            </li>
                            @foreach ($internships as $internship)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            {{ $internship->student->nama }}
                                        </div>
                                        <div class="col">
                                            @if (!$internship->instructor)
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#assignInstructorModal"
                                                    data-student-id="{{ $internship->id }}">
                                                    Tugaskan Instruktur
                                                </button>
                                            @else
                                                <span>{{ $internship->student->mayor->department->nama }}</span>
                                            @endif
                                        </div>
                                        <div class="col">
                                            @if ($internship->instructor)
                                                <span class="badge bg-success">{{ $internship->instructor->nama }}</span>
                                                <div class="dropdown d-inline">
                                                    <button class="btn p-0" type="button" id="transactionID"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="transactionID">
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            data-bs-toggle="modal" data-bs-target="#editInstructorModal"
                                                            data-internship-id="{{ $internship->id }}"
                                                            data-instructor-id="{{ $internship->instructor->id }}">Edit
                                                            Instruktur</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('corporation/dashboard.show', $internship->id) }}">Lihat</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Instructors -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Instruktur</h5>
                        <i class="bx bx-chalkboard fs-2 text-primary"></i>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($instructors as $instructor)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $instructor->nama }}
                                    <span class="badge bg-success">Siswa: {{ $instructor->students_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="assignInstructorModal" tabindex="-1" aria-labelledby="assignInstructorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('corporation/dashboard.assignInstructor') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignInstructorModalLabel">Tugaskan Instruktur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="student_id" id="student_id">
                            <div class="mb-3">
                                <label for="instructor_id" class="form-label">Pilih Instruktur</label>
                                <select name="instructor_id" id="instructor_id" class="form-select">
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tugaskan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editInstructorModal" tabindex="-1" aria-labelledby="editInstructorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('corporation/dashboard.update', $internship->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editInstructorModalLabel">Edit Instruktur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="internship_id" id="edit_internship_id">
                            <div class="mb-3">
                                <label for="edit_instructor_id" class="form-label">Pilih Instruktur</label>
                                <select name="instructor_id" id="edit_instructor_id" class="form-select">
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            var assignInstructorModal = document.getElementById('assignInstructorModal');
            assignInstructorModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var studentId = button.getAttribute('data-student-id');
                var modalStudentIdInput = assignInstructorModal.querySelector('#student_id');

                modalStudentIdInput.value = studentId;
            });

            var editInstructorModal = document.getElementById('editInstructorModal');
            editInstructorModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var internshipId = button.getAttribute('data-internship-id');
                var instructorId = button.getAttribute('data-instructor-id');
                var modalInternshipIdInput = editInstructorModal.querySelector('#edit_internship_id');
                var modalInstructorIdSelect = editInstructorModal.querySelector('#edit_instructor_id');

                modalInternshipIdInput.value = internshipId;
                modalInstructorIdSelect.value = instructorId;
            });
        </script>
    @endif
@endsection
