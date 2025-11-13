@extends('layouts.admin')

@section('title', 'Doctors · Admin')
@section('page-title', 'Doctor Profiles')
@section('page-subtitle', 'Manage provider rosters, expertise, and activation status.')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <form method="GET" class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name / email / phone"
                    class="w-56 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <input type="text" name="specialization" value="{{ $filters['specialization'] ?? '' }}" placeholder="Specialization"
                    class="w-48 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <select name="diagnostic_center_id"
                    class="w-48 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <option value="">Any center</option>
                    @foreach ($centers as $center)
                        <option value="{{ $center->id }}" @selected(($filters['diagnostic_center_id'] ?? '') == $center->id)>
                            {{ $center->name }}
                        </option>
                    @endforeach
                </select>
                <select name="is_active"
                    class="w-36 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <option value="">Status</option>
                    <option value="1" @selected(($filters['is_active'] ?? '') === '1')>Active</option>
                    <option value="0" @selected(($filters['is_active'] ?? '') === '0')>Inactive</option>
                </select>
                <button type="submit"
                    class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">Filter</button>
                <a href="{{ route('admin.doctors.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Reset</a>
            </form>
            <a href="{{ route('admin.doctors.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Add Doctor
            </a>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Doctor</th>
                        <th class="px-6 py-3 font-medium">Specialization</th>
                        <th class="px-6 py-3 font-medium">Center</th>
                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                    @foreach ($doctors as $doctor)
                        <tr class="transition hover:bg-emerald-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $doctor->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $doctor->user->email }}</div>
                                <div class="text-xs text-slate-400">{{ $doctor->user->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-700">{{ $doctor->specialization }}</div>
                                <div class="text-xs text-slate-500">{{ $doctor->qualifications ?? '—' }}</div>
                                <div class="text-xs text-slate-400">Experience: {{ $doctor->experience_years ?? 0 }} yrs</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-700">{{ $doctor->diagnosticCenter->name ?? 'Unassigned' }}</div>
                                <span class="mt-1 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $doctor->is_active ? 'bg-emerald-500/10 text-emerald-600' : 'bg-rose-500/10 text-rose-500' }}">
                                    {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                        class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.doctors.destroy', $doctor->id) }}"
                                        onsubmit="return confirm('Remove this doctor profile?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-xl border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-500 transition hover:bg-rose-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $doctors->withQueryString()->links() }}
        </div>
    </div>
@endsection

