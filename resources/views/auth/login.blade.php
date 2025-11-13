@extends('layouts.auth')

@section('title', 'Sign in · '.config('app.name', 'SmartDoc'))
@section('badge', 'Secure Access')
@section('heading', 'Welcome back')
@section('subheading', 'Sign in to manage appointments, prescriptions, and your SmartDoc care experience.')

@section('content')
    <form method="POST" action="{{ route('login.store') }}" class="needs-validation" novalidate>
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <label for="email" class="form-label fw-semibold text-secondary">Email address</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope"></i></span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control border-start-0 form-control-lg @error('email') is-invalid @enderror"
                        placeholder="you@email.com"
                        autocomplete="email"
                        required
                        autofocus
                    >
                    <div class="invalid-feedback">
                        @error('email') {{ $message }} @else Please enter your email address. @enderror
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="form-label fw-semibold text-secondary mb-0">Password</label>
                    <a href="{{ route('password.request') }}" class="small fw-semibold text-decoration-none text-primary">Forgot password?</a>
                </div>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock"></i></span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control border-start-0 form-control-lg @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                    <button
                        class="btn btn-outline-secondary border-start-0"
                        type="button"
                        data-toggle-password="password"
                        aria-label="Toggle password visibility"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                    <div class="invalid-feedback">
                        @error('password') {{ $message }} @else Please provide your password. @enderror
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="remember">
                        Keep me signed in
                    </label>
                </div>
                <span class="badge rounded-pill text-bg-light text-muted">
                    <i class="bi bi-shield-check me-2 text-success"></i>
                    Secure session enabled
                </span>
            </div>
        </div>

        <div class="d-grid gap-3 mt-4">
            <button type="submit" class="btn btn-primary btn-lg rounded-4">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Sign in to SmartDoc
            </button>
            <p class="text-center text-muted small mb-0">
                Need assistance? <a href="mailto:support@smartdoc.health" class="fw-semibold text-decoration-none text-primary">Contact the SmartDoc care team</a>
            </p>
        </div>
    </form>
@endsection

@section('footer')
    New to SmartDoc?
    <a href="{{ route('register') }}" class="fw-semibold text-decoration-none text-primary">Create an account</a>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-toggle-password');
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isHidden = input.getAttribute('type') === 'password';
                input.setAttribute('type', isHidden ? 'text' : 'password');

                const icon = button.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                }
            });
        });
    </script>
@endpush
