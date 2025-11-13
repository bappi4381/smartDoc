@extends('layouts.admin')

@section('title', 'Create Doctor Profile · Admin')
@section('page-title', 'Create Doctor Profile')
@section('page-subtitle', 'Provision credentials and clinical metadata for new practitioners.')

@section('content')
    <form method="POST" action="{{ route('admin.doctors.store') }}" class="space-y-8">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            @include('admin.doctors._form', ['centers' => $centers])
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                Save doctor
            </button>
            <a href="{{ route('admin.doctors.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </form>
@endsection

