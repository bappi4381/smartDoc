@extends('layouts.auth')

@section('badge', 'Verification Required')
@section('title', 'Verify your email · '.config('app.name', 'SmartDoc'))
@section('heading', 'Secure your SmartDoc account')
@section('subheading', 'Confirm your email address to start using all SmartDoc services.')

@section('content')
    <div class="text-muted">
        <div class="rounded-4 border border-primary-subtle bg-primary-subtle bg-opacity-25 p-4 mb-4">
            <h6 class="fw-semibold text-primary mb-2">
                <i class="bi bi-envelope-check me-2"></i>Action required: verify your email
            </h6>
            <p class="small text-primary mb-2">
                We sent a secure link to <strong>{{ auth()->user()->email }}</strong>. Please click the link in your inbox to activate your account. The verification link expires in 60 minutes.
            </p>
            <p class="small mb-0 text-primary">
                Didn’t receive anything? Check your spam folder or request a new link below.
            </p>
        </div>

        <div class="d-grid gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-4">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    Resend verification email
                </button>
            </form>
            <p class="text-center small mb-0">
                Need help? <a href="mailto:support@smartdoc.health" class="fw-semibold text-decoration-none text-primary">Contact SmartDoc support</a>
            </p>
            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none text-danger small fw-semibold">
                    <i class="bi bi-box-arrow-left me-1"></i>
                    Log out and use a different email
                </button>
            </form>
        </div>
    </div>
@endsection

