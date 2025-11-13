@extends('layouts.auth')

@section('title', 'Verify your email · '.config('app.name', 'SmartDoc'))
@section('heading', 'Secure your SmartDoc account')
@section('subheading', 'Confirm your email so we know it’s really you.')

@section('content')
    <div class="space-y-6 text-sm text-slate-600">
        <div class="space-y-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-emerald-700">
            <div class="flex items-center gap-2 font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12H8m8 0l-3-3m3 3l-3 3" />
                </svg>
                Action required: verify your email
            </div>
            <p class="text-xs leading-relaxed">
                We sent a verification link to <span class="font-semibold text-emerald-800">{{ auth()->user()->email }}</span>.
                Click the link in your inbox to activate your account. The link expires in 60 minutes.
            </p>
        </div>

        <p class="leading-relaxed">
            Verifying your email helps keep your medical records, prescriptions, and appointment updates secure. If you don’t see the message, check your spam folder or resend the email below.
        </p>

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}" class="space-y-2">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200/60 transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M4 20v-5h.582m15.356-2a8.003 8.003 0 01-15.356 2" />
                    </svg>
                    Resend verification email
                </button>
                <p class="text-center text-xs text-slate-400">
                    Need assistance? <a href="mailto:support@smartdoc.health" class="font-medium text-emerald-600 hover:text-emerald-500">Contact SmartDoc support</a>
                </p>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center text-xs text-slate-500">
                @csrf
                <button type="submit" class="font-semibold text-emerald-600 transition hover:text-emerald-500">
                    Log out and use a different email
                </button>
            </form>
        </div>
    </div>
@endsection

