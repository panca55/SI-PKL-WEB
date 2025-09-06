@extends('layouts.guest')

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <a href="/" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/favicon/SMKN2.png') }}" alt="Logo" width="50">
                    </span>
                    <span class="app-brand-text demo text-body fw-bold">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Lupa Password?</h4>
            <p class="mb-4">Silahkan cek email untuk mendapatkan link reset password</p>
            <form method="POST" class="mb-3" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Enter your email" required autofocus />
                </div>
                <button class="btn btn-primary d-grid w-100">{{ __('Email Password Reset Link') }}</button>
            </form>
            <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                    <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                    Kembali ke login
                </a>
            </div>
        </div>
    </div>
@endsection
