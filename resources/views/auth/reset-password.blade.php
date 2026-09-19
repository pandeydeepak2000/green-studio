@extends('layouts.auth')

@section('title', 'Reset Password - Green Studio GST Portal')

@section('content')

<div class="auth-wrapper">

    <div class="auth-title">
        Set New Password 🔑
    </div>

    <div class="auth-subtitle">
        Please enter your email and choose a secure new password.
    </div>

    @if (session('status'))
        <div class="alert alert-success auth-alert mb-2">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger auth-alert mb-2">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
        @csrf

        {{-- TOKEN --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- EMAIL --}}
        <div class="mb-2">
            <label class="form-label">Email Address</label>
            <input type="email"
                   name="email"
                   value="{{ old('email', $request->email) }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter your email"
                   required
                   autofocus>
        </div>

        <div class="row g-2 mb-2">
            {{-- NEW PASSWORD --}}
            <div class="col-6">
                <label class="form-label">New Password</label>
                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 chars"
                       required>
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="col-6">
                <label class="form-label">Confirm</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm"
                       required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2.5 mt-2 fw-bold">
            Update Password & Sign In
        </button>

        <div class="text-center" style="font-size: 12px;">
            <span class="text-muted">Remember your credentials?</span>
            <a href="{{ route('login') }}" class="auth-link ms-1">Sign In</a>
        </div>

    </form>

</div>

@endsection
