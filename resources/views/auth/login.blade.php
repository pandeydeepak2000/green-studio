@extends('layouts.auth')

@section('title', 'Sign In - Green Studio GST Portal')

@section('content')

<div class="auth-wrapper">

    <div class="auth-title">
        Welcome Back 👋
    </div>

    <div class="auth-subtitle">
        Sign in to Green Studio GST billing portal. Secure role access for Admin & Support teams.
    </div>

    @if (session('status'))
        <div class="alert alert-success auth-alert mb-3">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger auth-alert mb-3">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        {{-- EMAIL --}}
        <div class="mb-2.5 mb-2">
            <label class="form-label" for="loginEmail">Email Address</label>
            <input type="email"
                   id="loginEmail"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="name@greenstudio.com"
                   required
                   autofocus>
        </div>

        {{-- PASSWORD --}}
        <div class="mb-2.5 mb-2">
            <label class="form-label" for="loginPassword">Password</label>
            <input type="password"
                   id="loginPassword"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Enter your password"
                   required>
        </div>

        {{-- OPTIONS --}}
        <div class="d-flex justify-content-between align-items-center mb-3 mt-1 flex-wrap gap-1">
            <div class="form-check" style="margin-bottom: 0;">
                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       id="remember"
                       style="cursor: pointer;">
                <label class="form-check-label small text-muted"
                       for="remember"
                       style="font-size: 12px; cursor: pointer;">
                    Remember me
                </label>
            </div>

            <a href="{{ route('password.request') }}" class="auth-link small" style="font-size: 12px;">
                Forgot Password?
            </a>
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-primary w-100 mb-2.5 mb-2 fw-bold">
            Sign In to Green Studio
        </button>

        {{-- CREATE ACCOUNT LINK --}}
        <div class="text-center mb-2" style="font-size: 12px;">
            <span class="text-muted">Don't have an account?</span>
            <a href="{{ route('register') }}" class="auth-link ms-1">Create Account</a>
        </div>

        {{-- SECURITY NOTE --}}
        <div class="text-center text-muted" style="font-size: 11px; opacity: 0.85;">
            🔒 Protected Portal • Bihar GSTIN: 10DYFPA2189J1ZO
        </div>

    </form>

</div>

@endsection