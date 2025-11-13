@extends('layouts.admin')

@section('title', 'Diagnostic Centers · Admin')
@section('page-title', 'Diagnostic Centers')
@section('page-subtitle', 'Curate facility data, availability, and specialization coverage.')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <form method="GET" class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search centers"
                    class="w-52 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <input type="text" name="city" value="{{ $filters['city'] ?? '' }}" placeholder="City"
                    class="w-40 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <input type="text" name="specialization" value="{{ $filters['specialization'] ?? '' }}" placeholder="Specialization"
                    class="w-48 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <select name="is_active"
                    class="w-36 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <option value="">Status</option>
                    <option value="1" @selected(($filters['is_active'] ?? '') === '1')>Active</option>
                    <option value="0" @selected(($filters['is_active'] ?? '') === '0')>Inactive</option>
                </select>
                <button type="submit"
                    class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">Filter</button>
                <a href="{{ route('admin.centers.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Reset</a>
            </form>
            <a href="{{ route('admin.centers.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                </svg>
                Add Center
            </a>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-medium">Center</th>
                        <th class="px-6 py-3 font-medium">Specializations</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                    @foreach ($centers as $center)
                        <tr class="transition hover:bg-emerald-50/60">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $center->name }}</div>
                                <div class="text-xs text-slate-500">{{ $center->city }}, {{ $center->country }}</div>
                                <div class="text-xs text-slate-400">{{ $center->email ?? 'No email' }} · {{ $center->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ((array) $center->specializations as $spec)
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $spec }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1 text-xs font-semibold">
                                    <span class="inline-flex rounded-full px-3 py-1 {{ $center->is_active ? 'bg-emerald-500/10 text-emerald-600' : 'bg-rose-500/10 text-rose-500' }}">
                                        {{ $center->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="block rounded-full bg-slate-100 px-3 py-1 text-slate-500">
                                        {{ $center->has_available_slots ? 'Accepting bookings' : 'Fully booked' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.centers.edit', $center->id) }}"
                                        class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.centers.destroy', $center->id) }}"
                                        onsubmit="return confirm('Delete this diagnostic center?')">
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
            {{ $centers->withQueryString()->links() }}
        </div>
    </div>
@endsection

