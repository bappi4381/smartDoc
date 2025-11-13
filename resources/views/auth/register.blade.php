@extends('layouts.auth')

@section('badge', 'New Patient')
@section('title', 'Create Patient Account · '.config('app.name', 'SmartDoc'))
@section('heading', 'Create your SmartDoc account')
@section('subheading', 'Unlock AI-guided insights, priority appointments, and secure digital prescriptions.')

@section('content')
    <form method="POST" action="{{ route('register.store') }}" class="needs-validation" novalidate>
        @csrf
        <div class="rounded-4 border border-success-subtle bg-success-subtle bg-opacity-25 p-4 mb-4">
            <h6 class="fw-semibold text-success mb-3">
                <i class="bi bi-stars me-2"></i>Why patients choose SmartDoc
            </h6>
            <div class="row g-2 text-success">
                <div class="col-12 col-sm-6">
                    <div class="d-flex align-items-center small gap-2">
                        <i class="bi bi-robot text-success"></i>
                        AI-guided symptom insights
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="d-flex align-items-center small gap-2">
                        <i class="bi bi-calendar2-check text-success"></i>
                        Priority appointment booking
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="d-flex align-items-center small gap-2">
                        <i class="bi bi-prescription text-success"></i>
                        Secure digital prescriptions
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="d-flex align-items-center small gap-2">
                        <i class="bi bi-bell text-success"></i>
                        Personalized care reminders
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-6">
                <label for="name" class="form-label fw-semibold text-secondary">Full name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                    placeholder="Your full name"
                >
                <div class="invalid-feedback">
                    @error('name') {{ $message }} @else Please enter your name. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="email" class="form-label fw-semibold text-secondary">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                    placeholder="you@email.com"
                >
                <div class="invalid-feedback">
                    @error('email') {{ $message }} @else Please provide a valid email address. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="phone" class="form-label fw-semibold text-secondary">Phone number</label>
                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    placeholder="01XXXXXXXXX"
                    class="form-control form-control-lg rounded-3 @error('phone') is-invalid @enderror"
                >
                <div class="invalid-feedback">
                    @error('phone') {{ $message }} @else Please enter a valid phone number. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="date_of_birth" class="form-label fw-semibold text-secondary">Date of birth</label>
                <input
                    id="date_of_birth"
                    type="date"
                    name="date_of_birth"
                    value="{{ old('date_of_birth') }}"
                    required
                    class="form-control form-control-lg rounded-3 @error('date_of_birth') is-invalid @enderror"
                >
                <div class="invalid-feedback">
                    @error('date_of_birth') {{ $message }} @else Please choose your date of birth. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="gender" class="form-label fw-semibold text-secondary">Gender</label>
                <select
                    id="gender"
                    name="gender"
                    required
                    class="form-select form-select-lg rounded-3 @error('gender') is-invalid @enderror"
                >
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender</option>
                    @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('gender') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    @error('gender') {{ $message }} @else Please select a gender. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="address" class="form-label fw-semibold text-secondary">Address</label>
                <input
                    id="address"
                    type="text"
                    name="address"
                    value="{{ old('address') }}"
                    required
                    placeholder="House, street, city"
                    class="form-control form-control-lg rounded-3 @error('address') is-invalid @enderror"
                >
                <div class="invalid-feedback">
                    @error('address') {{ $message }} @else Please enter your address. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
                <label for="password" class="form-label fw-semibold text-secondary">Password</label>
                <div class="input-group input-group-lg">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="At least 8 characters, letters & numbers"
                        class="form-control border-end-0 rounded-start-3 form-control-lg @error('password') is-invalid @enderror"
                    >
                    <button
                        class="btn btn-outline-secondary border-start-0 rounded-end-3"
                        type="button"
                        data-toggle-password="password"
                        aria-label="Toggle password visibility"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="invalid-feedback d-block">
                    @error('password') {{ $message }} @else Use at least 8 characters with letters and numbers. @enderror
                </div>
            </div>

            <div class="col-12 col-md-6">
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
                    <button
                        class="btn btn-outline-secondary border-start-0 rounded-end-3"
                        type="button"
                        data-toggle-password="password_confirmation"
                        aria-label="Toggle password confirmation visibility"
                    >
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="d-grid gap-3 mt-4">
            <button type="submit" class="btn btn-primary btn-lg rounded-4">
                <i class="bi bi-person-plus-fill me-2"></i>
                Create SmartDoc account
            </button>
            <p class="small text-muted mb-0">
                By continuing, you agree to SmartDoc’s terms of service and acknowledge our privacy practices for sensitive medical data.
            </p>
        </div>
    </form>
@endsection

@section('footer')
    Already have an account?
    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none text-primary">Sign in</a>
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
