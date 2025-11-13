@extends('layouts.patient')

@section('title', 'Enter Symptoms · '.config('app.name', 'SmartDoc'))

@section('page-title', 'Symptom Input')
@section('page-subtitle', 'This workspace will guide you through AI-powered symptom analysis soon')

@section('content')
    <div class="rounded-2xl border border-dashed border-emerald-200 bg-white/60 p-10 text-center shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-12 w-12 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 9l4 4 4-4m0 6l-4 4-4-4" />
        </svg>
        <h2 class="text-2xl font-semibold text-slate-800">Symptom analysis is on the way</h2>
        <p class="mt-2 text-sm text-slate-500">
            You have successfully selected your diagnostic center. The AI-powered symptom intake experience will be available in an upcoming iteration.
            In the meantime, you can review your profile or explore other areas of the patient portal.
        </p>
        <div class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-600">
            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
            Center selected: {{ session('patient.selected_center_name', 'Not set') }}
        </div>
    </div>
@endsection

