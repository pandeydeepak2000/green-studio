@extends('layouts.auth')

@section('title', 'Forgot Password - Green Studio GST Portal')

@section('content')

<div class="auth-wrapper">

    <div class="auth-title">
        Forgot Password 🔐
    </div>

    <div class="auth-subtitle">
        Enter your email address and we’ll send you a password reset link.
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

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter registered email"
                   required
                   autofocus>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold">
            Send Reset Link
        </button>

        <div class="text-center" style="font-size: 12px;">
            <span class="text-muted">Remember your password?</span>
            <a href="{{ route('login') }}" class="auth-link ms-1">Back to Sign In</a>
        </div>

    </form>

</div>

@endsection