@extends('layouts.admin')

@section('title', 'Appointments · Admin')
@section('page-title', 'Appointment Control')
@section('page-subtitle', 'Coordinate schedules, resolve conflicts, and ensure timely follow-ups.')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="space-y-8">
        <section class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Status overview</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($statusSummary as $status => $total)
                    <article class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-400">{{ Str::headline($status) }}</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-800">{{ number_format($total) }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            <form method="GET" class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                <input type="text" name="patient_name" value="{{ $filters['patient_name'] ?? '' }}" placeholder="Patient name"
                    class="w-48 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <select name="status"
                    class="w-44 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <option value="">Any status</option>
                    @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'no_show'] as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ Str::headline($status) }}</option>
                    @endforeach
                </select>
                <select name="diagnostic_center_id"
                    class="w-48 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <option value="">Any center</option>
                    @foreach ($centers as $center)
                        <option value="{{ $center->id }}" @selected(($filters['diagnostic_center_id'] ?? '') == $center->id)>
                            {{ $center->name }}
                        </option>
                    @endforeach
                </select>
                <select name="doctor_id"
                    class="w-48 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <option value="">Any doctor</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" @selected(($filters['doctor_id'] ?? '') == $doctor->id)>
                            {{ $doctor->user->name }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                    class="w-40 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                    class="w-40 rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                <button type="submit"
                    class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">Filter</button>
                <a href="{{ route('admin.appointments.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Reset</a>
            </form>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Appointment</th>
                            <th class="px-6 py-3 font-medium">Doctor</th>
                            <th class="px-6 py-3 font-medium">Center</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                        @foreach ($appointments as $appointment)
                            <tr class="transition hover:bg-emerald-50/60">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">{{ $appointment->patient->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ optional($appointment->scheduled_at)->format('M d, Y · h:i A') }}</div>
                                    <div class="text-xs text-slate-400">AI: {{ $appointment->predicted_illness ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-700">{{ $appointment->doctor->user->name ?? 'Unassigned' }}</div>
                                    <div class="text-xs text-slate-500">{{ $appointment->doctor->specialization ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-700">{{ $appointment->diagnosticCenter->name ?? '—' }}</div>
                                    <div class="text-xs text-slate-500">{{ $appointment->diagnosticCenter->city ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-500">
                                        {{ Str::headline($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.appointments.show', $appointment->id) }}"
                                        class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $appointments->withQueryString()->links() }}
            </div>
        </section>
    </div>
@endsection

