@extends('layouts.admin')

@section('title', 'Edit Diagnostic Center · Admin')
@section('page-title', 'Update Diagnostic Center')
@section('page-subtitle', 'Keep facility information current for accurate matching and scheduling.')

@section('content')
    <form method="POST" action="{{ route('admin.centers.update', $center->id) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            @include('admin.centers._form', ['center' => $center])
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                Update center
            </button>
            <a href="{{ route('admin.centers.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Back to list</a>
        </div>
    </form>
@endsection

