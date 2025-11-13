@extends('layouts.auth')

@section('title', 'Sign in · '.config('app.name', 'SmartDoc'))
@section('heading', 'Welcome back')
@section('subheading', 'Sign in to manage appointments, prescriptions, and more')

@section('content')
    <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
        @csrf
        <div class="space-y-5">
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
                <div class="group relative">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-300 transition group-focus-within:text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm6 0a9.37 9.37 0 01-.64 3.43 9.5 9.5 0 01-17.72 0A9.37 9.37 0 012 12a9.37 9.37 0 01.64-3.43 9.5 9.5 0 0117.72 0A9.37 9.37 0 0122 12z" />
                        </svg>
                    </span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-12 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                        placeholder="you@email.com"
                    >
                </div>
                @error('email')
                    <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <label for="password" class="font-medium text-slate-700">Password</label>
                    <a href="{{ route('password.request') }}" class="font-semibold text-emerald-600 transition hover:text-emerald-500">Forgot password?</a>
                </div>
                <div class="group relative">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-300 transition group-focus-within:text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-12 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                        placeholder="Enter your password"
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
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 text-sm text-slate-500">
            <label class="inline-flex items-center gap-2 text-slate-600">
                <input
                    type="checkbox"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                    class="h-[18px] w-[18px] rounded border border-slate-300 text-emerald-600 focus:ring-emerald-500/40"
                >
                <span>Keep me signed in</span>
            </label>
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Secure session enabled
            </span>
        </div>

        <div class="space-y-4">
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200/60 transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 12h16m0 0l-4 4m4-4l-4-4" />
                </svg>
                Sign in to SmartDoc
            </button>
            <p class="text-center text-xs text-slate-400">
                Need support? <a href="mailto:support@smartdoc.health" class="font-medium text-emerald-600 hover:text-emerald-500">Contact our care team</a>
            </p>
        </div>
    </form>
@endsection

@section('footer')
    New to SmartDoc?
    <a href="{{ route('register') }}" class="font-semibold text-emerald-600 transition hover:text-emerald-500">Create an account</a>
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

