@extends('layouts.auth')

@section('title', 'Create Patient Account · '.config('app.name', 'SmartDoc'))
@section('heading', 'Create your SmartDoc account')
@section('subheading', 'Get personalized insights, book appointments, and stay ahead of your health journey.')

@section('content')
    <form method="POST" action="{{ route('register.store') }}" class="space-y-8">
        @csrf
        <div class="space-y-3 rounded-2xl bg-emerald-50/70 px-4 py-3 text-sm text-emerald-700">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">Why register?</span>
            </div>
            <ul class="grid gap-2 text-xs text-emerald-600 md:grid-cols-2">
                <li class="flex items-center gap-2">
                    <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    AI-guided symptom insights
                </li>
                <li class="flex items-center gap-2">
                    <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Priority appointment booking
                </li>
                <li class="flex items-center gap-2">
                    <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Secure digital prescriptions
                </li>
                <li class="flex items-center gap-2">
                    <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Personalized care reminders
                </li>
            </ul>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-slate-700">Full name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                    placeholder="Your full name"
                >
                @error('name')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                    placeholder="you@email.com"
                >
                @error('email')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="phone" class="text-sm font-medium text-slate-700">Phone number</label>
                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    placeholder="01XXXXXXXXX"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                >
                @error('phone')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="date_of_birth" class="text-sm font-medium text-slate-700">Date of birth</label>
                <input
                    id="date_of_birth"
                    type="date"
                    name="date_of_birth"
                    value="{{ old('date_of_birth') }}"
                    required
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                >
                @error('date_of_birth')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="gender" class="text-sm font-medium text-slate-700">Gender</label>
                <select
                    id="gender"
                    name="gender"
                    required
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                >
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender</option>
                    @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('gender') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('gender')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="address" class="text-sm font-medium text-slate-700">Address</label>
                <input
                    id="address"
                    type="text"
                    name="address"
                    value="{{ old('address') }}"
                    required
                    placeholder="House, street, city"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                >
                @error('address')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                <div class="group relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="At least 8 characters, letters & numbers"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                    >
                    <button
                        type="button"
                        class="absolute inset-y-0 right-4 flex items-center text-slate-300 transition hover:text-emerald-500"
                        data-toggle-password="password"
                        aria-label="Toggle password visibility"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c1.118 0 2.197.182 3.2.518m3.573 2.215C20.29 8.756 21.336 10.278 21.542 12c-.514 3.214-3.742 7-9.542 7a9.995 9.995 0 01-3.2-.518M15 12a3 3 0 00-3-3m0 0c-.512 0-1.005.122-1.436.338M12 9l-9 9" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-medium text-slate-700">Confirm password</label>
                <div class="group relative">
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                        placeholder="Re-enter password"
                    >
                    <button
                        type="button"
                        class="absolute inset-y-0 right-4 flex items-center text-slate-300 transition hover:text-emerald-500"
                        data-toggle-password="password_confirmation"
                        aria-label="Toggle password confirmation visibility"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c1.118 0 2.197.182 3.2.518m3.573 2.215C20.29 8.756 21.336 10.278 21.542 12c-.514 3.214-3.742 7-9.542 7a9.995 9.995 0 01-3.2-.518M15 12a3 3 0 00-3-3m0 0c-.512 0-1.005.122-1.436.338M12 9l-9 9" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200/60 transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                </svg>
                Create SmartDoc account
            </button>
            <p class="flex items-start gap-2 text-xs text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                By creating an account, you agree to SmartDoc’s terms of service and acknowledge our privacy practices for sensitive medical data.
            </p>
        </div>
    </form>
@endsection

@section('footer')
    Already have an account?
    <a href="{{ route('login') }}" class="font-semibold text-emerald-600 transition hover:text-emerald-500">Sign in</a>
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

                button.classList.toggle('text-emerald-500', isHidden);
                button.classList.toggle('text-slate-300', !isHidden);
            });
        });
    </script>
@endpush

