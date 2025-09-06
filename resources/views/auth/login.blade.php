@extends('layouts.guest')

@section('content')
    <!-- Register -->
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <a href="/" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/favicon/SMKN2.png') }}" alt="Logo" width="50">
                    </span>
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/favicon/SIGAPKL.png') }}" alt="Logo" width="50">
                    </span>
                    {{-- <span class="app-brand-text demo text-body fw-bold">{{ config('app.name', 'Laravel') }}</span> --}}
                </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2 text-center">Selamat Datang</h4>
            <p class='text-center fw-bold'>Sistem Informasi dan Manajemen PKL <br>SMK NEGERI 2 PADANG
            </p>
            <form method="POST" action="{{ route('login') }}" id="formAuthentication" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                        value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                <small>{{ __('Forgot your password?') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required
                            aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                        <label class="form-check-label" for="remember-me"> {{ __('Remember Me') }} </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
                </div>
            </form>

        </div>
    </div>
    <!-- /Register -->
@endsection
