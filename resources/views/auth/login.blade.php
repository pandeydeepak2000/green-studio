@extends('layouts.auth')

@section('title', 'Sign in - GST Invoice')

@section('content')

<style>

.auth-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:6px;
}

.auth-subtitle{
    font-size:14px;
    color:#64748b;
    line-height:1.7;
    margin-bottom:28px;
}

.auth-form .form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.auth-form .form-control{
    min-height:52px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
    padding-left:16px;
}

.auth-form .form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.12) !important;
}

.auth-form .btn-primary{
    min-height:52px;
    border-radius:16px;
    font-weight:700;
    font-size:15px;
}

.auth-link{
    color:#2563eb;
    text-decoration:none;
    font-weight:600;
}

.auth-link:hover{
    text-decoration:underline;
}

.auth-alert{
    border:none;
    border-radius:16px;
}

</style>

<div class="auth-wrapper">

    <div class="auth-title">

        Welcome Back 👋

    </div>

    <div class="auth-subtitle">

        Sign in to access your GST billing dashboard,
        invoices, reports and customer management panel.

    </div>

    @if ($errors->any())

        <div class="alert alert-danger auth-alert mb-4">

            @foreach ($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif

    <form method="POST"
          action="{{ route('login') }}"
          class="auth-form">

        @csrf

        {{-- EMAIL --}}
        <div class="mb-3">

            <label class="form-label">

                Email Address

            </label>

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter your email"
                   required
                   autofocus>

        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">

            <label class="form-label">

                Password

            </label>

            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Enter your password"
                   required>

        </div>

        {{-- OPTIONS --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

            <div class="form-check">

                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       id="remember">

                <label class="form-check-label small"
                       for="remember">

                    Remember me

                </label>

            </div>

            <a href="{{ route('password.request') }}"
               class="auth-link small">

                Forgot Password?

            </a>

        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-primary w-100 mb-4">

            Sign In

        </button>

        {{-- FOOTER --}}
        <div class="text-center small text-muted">

            Don’t have an account?

            <a href="{{ route('register') }}"
               class="auth-link">

                Create Account

            </a>

        </div>

    </form>

</div>

@endsection