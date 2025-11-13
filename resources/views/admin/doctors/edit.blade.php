@extends('layouts.admin')

@section('title', 'Edit Doctor Profile · Admin')
@section('page-title', 'Update Doctor Profile')
@section('page-subtitle', 'Adjust credentials, assignments, and availability to stay in sync with operations.')

@section('content')
    <div class="space-y-8">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}" class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm space-y-6">
            @csrf
            @method('PUT')

            @include('admin.doctors._form', ['doctor' => $doctor, 'centers' => $centers])

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                    Update doctor
                </button>
                <a href="{{ route('admin.doctors.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Back to list</a>
            </div>
        </form>

        <section class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800">Reassign diagnostic center</h2>
            <p class="text-sm text-slate-500">Move the doctor to a different primary facility. Patients will see the updated association immediately.</p>

            <form method="POST" action="{{ route('admin.doctors.assign', $doctor->id) }}" class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-600">
                @csrf
                <select name="diagnostic_center_id" required
                    class="w-60 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    @foreach ($centers as $center)
                        <option value="{{ $center->id }}" @selected($doctor->diagnostic_center_id === $center->id)>{{ $center->name }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                    Assign center
                </button>
            </form>
        </section>
    </div>
@endsection

