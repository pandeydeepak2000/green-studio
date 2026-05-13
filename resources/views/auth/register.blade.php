@extends('layouts.auth')

@section('title', 'Create Account - GST Invoice')

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

        Create Admin Account 🚀

    </div>

    <div class="auth-subtitle">

        Create your GST Invoice admin account to manage
        invoices, customers, GST reports and billing operations.

    </div>

    @if ($errors->any())

        <div class="alert alert-danger auth-alert mb-4">

            @foreach ($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif

    <form method="POST"
          action="{{ route('register') }}"
          class="auth-form">

        @csrf

        {{-- NAME --}}
        <div class="mb-3">

            <label class="form-label">

                Full Name

            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter full name"
                   required
                   autofocus>

        </div>

        {{-- EMAIL --}}
        <div class="mb-3">

            <label class="form-label">

                Email Address

            </label>

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter email address"
                   required>

        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">

            <label class="form-label">

                Password

            </label>

            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Create password"
                   required>

        </div>

        {{-- CONFIRM --}}
        <div class="mb-4">

            <label class="form-label">

                Confirm Password

            </label>

            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Confirm password"
                   required>

        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="btn btn-primary w-100 mb-4">

            Create Account

        </button>

        {{-- FOOTER --}}
        <div class="text-center small text-muted">

            Already have an account?

            <a href="{{ route('login') }}"
               class="auth-link">

                Sign In

            </a>

        </div>

    </form>

</div>

@endsection