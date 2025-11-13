@extends('layouts.auth')

@section('title', 'Reset password · '.config('app.name', 'SmartDoc'))
@section('heading', 'Let’s get you back in')
@section('subheading', 'Enter your email and we will send a secure link to restore access.')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="space-y-7">
        @csrf
        <div class="space-y-3 rounded-2xl border border-emerald-100 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold">Security tip</span>
            </div>
            <p class="text-xs leading-relaxed text-emerald-600">
                We’ll email you a one-time recovery link. It expires in 30 minutes and can only be used once.
            </p>
        </div>

        <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-slate-700">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20"
                placeholder="you@email.com"
            >
            @error('email')
                <p class="text-xs font-medium text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-3">
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200/60 transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12H8m8 0l-3-3m3 3l-3 3" />
                </svg>
                Email password reset link
            </button>
            <p class="text-center text-xs text-slate-400">
                Need help? <a href="mailto:support@smartdoc.health" class="font-medium text-emerald-600 hover:text-emerald-500">Contact SmartDoc support</a>
            </p>
        </div>
    </form>
@endsection

@section('footer')
    Remembered your password?
    <a href="{{ route('login') }}" class="font-semibold text-emerald-600 transition hover:text-emerald-500">Back to sign in</a>
@endsection

