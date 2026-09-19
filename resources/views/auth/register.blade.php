@extends('layouts.auth')

@section('title', 'Create Account - Green Studio GST Portal')

@section('content')

<div class="auth-wrapper">

    <div class="auth-title">
        Create Account 🚀
    </div>

    <div class="auth-subtitle">
        Register for Green Studio portal. Account activates upon Admin approval.
    </div>

    @if ($errors->any())
        <div class="alert alert-danger auth-alert mb-2">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        {{-- NAME --}}
        <div class="mb-2">
            <label class="form-label">Full Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Enter full name"
                   required
                   autofocus>
        </div>

        {{-- EMAIL --}}
        <div class="mb-2">
            <label class="form-label">Email Address</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Enter email address"
                   required>
        </div>

        <div class="row g-2 mb-2">
            {{-- PASSWORD --}}
            <div class="col-6">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 chars"
                       required>
            </div>

            {{-- CONFIRM --}}
            <div class="col-6">
                <label class="form-label">Confirm</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm"
                       required>
            </div>
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-primary w-100 mb-2.5 mt-2 fw-bold">
            Create Account
        </button>

        {{-- FOOTER --}}
        <div class="text-center" style="font-size: 12px;">
            <span class="text-muted">Already have an account?</span>
            <a href="{{ route('login') }}" class="auth-link ms-1">Sign In</a>
        </div>

    </form>

</div>

@endsection