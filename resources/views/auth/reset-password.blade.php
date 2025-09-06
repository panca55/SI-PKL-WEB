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
            <h4 class="mb-2">Reset Password</h4>
            <form id="formAuthentication" class="mb-3" action="{{ route('password.store') }}" method="POST">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" name="email"
                        value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- New Password -->
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">New Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password" required
                            autocomplete="new-password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password">
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @if ($errors->has('password'))
                        <div class="text-danger mt-2">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="confirm-password">Confirm Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="confirm-password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password">
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="text-danger mt-2">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <button class="btn btn-primary d-grid w-100 mb-3">
                    Set new password
                </button>
                <div class="text-center">
                    <a href="{{ route('login') }}">
                        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                        Back to login
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
