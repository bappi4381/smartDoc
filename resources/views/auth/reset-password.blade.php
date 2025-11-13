@extends('layouts.auth')

@section('title', 'Choose a new password · '.config('app.name', 'SmartDoc'))
@section('heading', 'Secure your SmartDoc account')
@section('subheading', 'Create a strong password to protect sensitive health information.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-7">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
            <div class="flex items-center gap-2 text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22c4.418 0 8-5.373 8-10s-3.582-10-8-10-8 5.373-8 10 3.582 10 8 10z" />
                </svg>
                <span class="font-semibold">Password guidance</span>
            </div>
            <p class="text-xs leading-relaxed">
                Use at least 8 characters, combining letters, numbers, and symbols. Avoid sharing this password across other services.
            </p>
        </div>

        <div class="space-y-4">
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
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
                <label for="password" class="text-sm font-medium text-slate-700">New password</label>
                <div class="group relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                        placeholder="Create a strong password"
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

        <div class="space-y-3">
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200/60 transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                </svg>
                Update password
            </button>
            <p class="text-center text-xs text-slate-400">
                If you didn’t request this change, please contact <a href="mailto:security@smartdoc.health" class="font-medium text-emerald-600 hover:text-emerald-500">security@smartdoc.health</a>.
            </p>
        </div>
    </form>
@endsection

@section('footer')
    Changed your mind?
    <a href="{{ route('login') }}" class="font-semibold text-emerald-600 transition hover:text-emerald-500">Back to sign in</a>
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

