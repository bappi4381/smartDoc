@extends('layouts.admin')

@section('title', 'Create Diagnostic Center · Admin')
@section('page-title', 'Create Diagnostic Center')
@section('page-subtitle', 'Onboard a new partner facility and publish it to patient workflows.')

@section('content')
    <form method="POST" action="{{ route('admin.centers.store') }}" class="space-y-8">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            @include('admin.centers._form')
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                Save center
            </button>
            <a href="{{ route('admin.centers.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
        </div>
    </form>
@endsection

