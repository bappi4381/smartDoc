@extends('layouts.auth')

@section('badge', 'Account Security')
@section('title', 'Choose a new password · '.config('app.name', 'SmartDoc'))
@section('heading', 'Secure your SmartDoc account')
@section('subheading', 'Choose a strong password to protect your health information.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="rounded-4 border border-info-subtle bg-info-subtle bg-opacity-25 p-4 mb-4">
            <h6 class="fw-semibold text-info mb-2">
                <i class="bi bi-shield-lock me-2"></i>Password guidance
            </h6>
            <p class="small text-info mb-0">
                Use at least 8 characters, mixing uppercase and lowercase letters, numbers, and symbols. Avoid reusing passwords from other services.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <label for="email" class="form-label fw-semibold text-secondary">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autocomplete="email"
                    class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                    placeholder="you@email.com"
                >
                <div class="invalid-feedback">
                    @error('email') {{ $message }} @else Please confirm your account email. @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="password" class="form-label fw-semibold text-secondary">New password</label>
                <div class="input-group input-group-lg">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="form-control border-end-0 rounded-start-3 form-control-lg @error('password') is-invalid @enderror"
                        placeholder="Create a strong password"
                    >
                    <button class="btn btn-outline-secondary border-start-0 rounded-end-3" type="button" data-toggle-password="password" aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="invalid-feedback d-block">
                    @error('password') {{ $message }} @else Password must contain at least 8 characters, including letters and numbers. @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="password_confirmation" class="form-label fw-semibold text-secondary">Confirm password</label>
                <div class="input-group input-group-lg">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="form-control border-end-0 rounded-start-3 form-control-lg"
                        placeholder="Re-enter password"
                    >
                    <button class="btn btn-outline-secondary border-start-0 rounded-end-3" type="button" data-toggle-password="password_confirmation" aria-label="Toggle password confirmation visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="d-grid gap-3 mt-4">
            <button type="submit" class="btn btn-primary btn-lg rounded-4">
                <i class="bi bi-check2-circle me-2"></i>
                Update password
            </button>
            <p class="text-center text-muted small mb-0">
                Didn’t request this change? Contact <a href="mailto:security@smartdoc.health" class="fw-semibold text-decoration-none text-primary">security@smartdoc.health</a>.
            </p>
        </div>
    </form>
@endsection

@section('footer')
    Changed your mind?
    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none text-primary">Back to sign in</a>
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

