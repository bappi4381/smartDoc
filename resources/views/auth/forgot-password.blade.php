@extends('layouts.auth')

@section('badge', 'Account Recovery')
@section('title', 'Reset password · '.config('app.name', 'SmartDoc'))
@section('heading', 'Let’s get you back in')
@section('subheading', 'Enter your email and we’ll send a secure recovery link.')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
        @csrf
        <div class="rounded-4 border border-warning-subtle bg-warning-subtle bg-opacity-25 p-4 mb-4">
            <h6 class="fw-semibold text-warning mb-2">
                <i class="bi bi-shield-lock-fill me-2"></i>Security reminder
            </h6>
            <p class="small text-warning mb-0">
                We’ll email a one-time recovery link to <strong>{{ old('email') ?: 'your account email' }}</strong>. It expires within 30 minutes and can only be used once.
            </p>
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-secondary">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                placeholder="you@email.com"
            >
            <div class="invalid-feedback">
                @error('email') {{ $message }} @else Please enter the email associated with your account. @enderror
            </div>
        </div>

        <div class="d-grid gap-3">
            <button type="submit" class="btn btn-primary btn-lg rounded-4">
                <i class="bi bi-envelope-arrow-up me-2"></i>
                Email password reset link
            </button>
            <p class="text-center text-muted small mb-0">
                Need assistance? <a href="mailto:support@smartdoc.health" class="fw-semibold text-decoration-none text-primary">Contact SmartDoc support</a>
            </p>
        </div>
    </form>
@endsection

@section('footer')
    Remembered your password?
    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none text-primary">Back to sign in</a>
@endsection

