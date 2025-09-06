@extends('layouts.corporation.main')

@section('content')
    <!-- Welcome Card -->
    <div class="col-lg-8 mb-4 order-0">
        <div class="card shadow-sm border-0">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat datang {{ auth()->user()->name }}!</h5>
                        <p class="mb-4">
                            Di sini Anda dapat melihat dan mengelola siswa yang Anda bimbing. Tetap ikuti perkembangan
                            mereka.
                        </p>
                        <a href="{{ route('instructor/profile.index') }}" class="btn btn-sm btn-outline-primary">View
                            Profile</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('/assets/img/illustrations/teacher-welcome.png') }}" height="140"
                            alt="Welcome Image" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
