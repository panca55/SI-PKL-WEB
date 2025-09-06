@extends('layouts.student.main')

@section('content')
    <div class="col-lg-8 mb-4 order-0">
        <div class="card shadow-sm border-0">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold">Selamat datang, {{ auth()->user()->name }}!</h5>
                        <p class="mb-4">
                            Tetap semangat dan teruslah berkarya! Ingat, setiap langkah kecilmu membawa
                            perubahan besar. 😊
                        </p>

                        <a href="{{ route('student/profile.index') }}" class="btn btn-sm btn-outline-primary">Lihat
                            Profil</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('/assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                            alt="Welcome Student" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($student->internship)
        <div class="row">
            <!-- Guru Pembimbing Card -->
            <div class="col-md-6 col-lg-4 mb-4 order-1">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header text-center bg-primary text-white">
                        <h5 class="card-title m-0 text-white">Guru Pembimbing</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mt-3 mb-2">
                            @if (empty($student->internship->teacher->foto))
                                <img src="{{ asset('assets/img/avatars/1.png') }}"
                                    alt="{{ $student->internship->teacher->nama }}" class="rounded-circle"
                                    style="width: 100px; height: 100px;" />
                            @else
                                <img src="{{ asset('storage/public/teachers-images/' . $student->internship->teacher->foto) }}"
                                    alt="{{ $student->internship->teacher->nama }}" class="rounded-circle"
                                    style="width: 100px; height: 100px;" />
                            @endif

                        </div>
                        <hr class="my-0" />
                        <ul class="list-unstyled mt-4">
                            <li class="mb-2">
                                <strong>NIP:</strong> {{ $student->internship->teacher->nip }}
                            </li>
                            <li class="mb-2">
                                <strong>Nama:</strong> {{ $student->internship->teacher->nama }}
                            </li>
                            <li class="mb-2">
                                <strong>Bidang Studi:</strong> {{ $student->internship->teacher->bidang_studi }}
                            </li>
                            <li class="mb-2">
                                <strong>Jabatan:</strong> {{ $student->internship->teacher->jabatan }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Instruktur Card -->
            <div class="col-md-6 col-lg-4 mb-4 order-2">
                <div class="card shadow-sm border-0 h-100">
                    @if (empty($student->internship->instructor))
                        <div class="card-header text-center bg-secondary text-white">
                            <h5 class="card-title m-0 text-white">Belum ada Instruktur</h5>
                        </div>
                    @else
                        <div class="card-header text-center bg-info text-white">
                            <h5 class="card-title m-0 text-white">Instruktur</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mt-3 mb-2">
                                @if (empty($student->internship->instructor->foto))
                                    <img src="{{ asset('assets/img/avatars/1.png') }}"
                                        alt="{{ $student->internship->instructor->nama }}" class="rounded-circle"
                                        style="width: 100px; height: 100px;" />
                                @else
                                    <img src="{{ asset('storage/public/instructors-images/' . $student->internship->instructor->foto) }}"
                                        alt="{{ $student->internship->instructor->nama }}" class="rounded-circle"
                                        style="width: 100px; height: 100px;" />
                                @endif
                            </div>
                            <hr class="my-0" />
                            <ul class="list-unstyled mt-4">
                                <li class="mb-2">
                                    <strong>NIP:</strong> {{ $student->internship->instructor->nip }}
                                </li>
                                <li class="mb-2">
                                    <strong>Nama:</strong> {{ $student->internship->instructor->nama }}
                                </li>
                                <li class="mb-2">
                                    <strong>No Hp:</strong> {{ $student->internship->instructor->hp }}
                                </li>
                                <li class="mb-2">
                                    <strong>Alamat:</strong> {{ $student->internship->instructor->alamat }}
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mitra Card -->
            <div class="col-md-6 col-lg-4 mb-4 order-3">
                <div class="card shadow-sm border-0 h-100">
                    @if (empty($student->internship->corporation))
                        <div class="card-header text-center bg-danger text-white">
                            <h5 class="card-title m-0 text-white">Belum ada Mitra</h5>
                        </div>
                    @else
                        <div class="card-header text-center bg-success text-white">
                            <h5 class="card-title m-0 text-white">Mitra</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mt-3 mb-2">
                                @if (empty($student->internship->corporation->foto))
                                    <img src="{{ asset('assets/img/avatars/1.png') }}"
                                        alt="{{ $student->internship->corporation->nama }}" class="rounded-circle"
                                        style="width: 100px; height: 100px;" />
                                @else
                                    <img src="{{ asset('storage/public/corporations-images/' . $student->internship->corporation->foto) }}"
                                        alt="{{ $student->internship->corporation->nama }}" class="rounded-circle"
                                        style="width: 100px; height: 100px;" />
                                @endif
                            </div>
                            <hr class="my-0" />
                            <ul class="list-unstyled mt-4">
                                <li class="mb-2">
                                    <strong>Nama Perusahaan:</strong> {{ $student->internship->corporation->nama }}
                                </li>
                                <li class="mb-2">
                                    <strong>No Hp:</strong> {{ $student->internship->corporation->hp }}
                                </li>
                                <li class="mb-2">
                                    <strong>Alamat:</strong> {{ $student->internship->corporation->alamat }}
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
