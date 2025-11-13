@extends('layouts.admin')

@section('title', 'Manage Appointment · Admin')
@section('page-title', 'Appointment Detail')
@section('page-subtitle', 'Review context, adjust ownership, and keep patient experience seamless.')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    <div class="space-y-8">
        <section class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">{{ $appointment->patient->user->name }}</h2>
                    <p class="text-sm text-slate-500">Appointment ID: {{ $appointment->uuid }}</p>
                </div>
                <span class="inline-flex rounded-full bg-slate-100 px-4 py-1 text-xs font-semibold text-slate-600">
                    {{ Str::headline($appointment->status) }}
                </span>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Scheduled for</p>
                    <p class="mt-2 text-base font-semibold text-slate-800">{{ optional($appointment->scheduled_at)->format('M d, Y · h:i A') }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Assigned doctor</p>
                    <p class="mt-2 text-base font-semibold text-slate-800">{{ $appointment->doctor->user->name ?? 'Unassigned' }}</p>
                    <p class="text-xs text-slate-500">{{ $appointment->doctor->specialization ?? '—' }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Diagnostic center</p>
                    <p class="mt-2 text-base font-semibold text-slate-800">{{ $appointment->diagnosticCenter->name ?? '—' }}</p>
                    <p class="text-xs text-slate-500">{{ $appointment->diagnosticCenter?->city }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-600">
                    <p class="text-xs uppercase tracking-wide text-slate-400">AI predicted illness</p>
                    <p class="mt-2 font-semibold text-slate-800">{{ $appointment->predicted_illness ?? '—' }}</p>
                    @if ($appointment->ai_confidence)
                        <p class="text-xs text-slate-500">Confidence {{ number_format($appointment->ai_confidence * 100, 1) }}%</p>
                    @endif
                </div>
                <div class="rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-600">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Chief complaint</p>
                    <p class="mt-2 text-slate-700">{{ $appointment->chief_complaint ?? 'Not specified' }}</p>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm lg:col-span-1">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Update status</h2>
                <form method="POST" action="{{ route('admin.appointments.status', $appointment->id) }}" class="mt-4 space-y-4 text-sm text-slate-600">
                    @csrf
                    <select name="status" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                        @foreach (['pending', 'confirmed', 'completed', 'cancelled', 'no_show'] as $status)
                            <option value="{{ $status }}" @selected($appointment->status === $status)>{{ Str::headline($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="w-full rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                        Save status
                    </button>
                </form>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm lg:col-span-1">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Reschedule</h2>
                <form method="POST" action="{{ route('admin.appointments.reschedule', $appointment->id) }}" class="mt-4 space-y-4 text-sm text-slate-600">
                    @csrf
                    <input type="datetime-local" name="scheduled_at" value="{{ optional($appointment->scheduled_at)->format('Y-m-d\TH:i') }}" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    <button type="submit"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                        Reschedule
                    </button>
                </form>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm lg:col-span-1">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Reassign doctor</h2>
                <form method="POST" action="{{ route('admin.appointments.reassign', $appointment->id) }}" class="mt-4 space-y-4 text-sm text-slate-600">
                    @csrf
                    <select name="doctor_id" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                        @foreach ($doctors as $doctorOption)
                            <option value="{{ $doctorOption->id }}" @selected($appointment->doctor_id === $doctorOption->id)>
                                {{ $doctorOption->user->name }} — {{ $doctorOption->diagnosticCenter->name ?? 'No center' }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                        Assign doctor
                    </button>
                </form>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Symptoms log</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    @forelse ($appointment->symptoms ?? [] as $symptom)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <p class="font-semibold text-slate-800">{{ Str::headline($symptom['name'] ?? '') }}</p>
                            <p class="text-xs text-slate-500">Severity {{ $symptom['severity'] ?? '—' }}/10 · Duration {{ $symptom['duration'] ?? '—' }}</p>
                            @if (! empty($symptom['notes']))
                                <p class="mt-1 text-xs text-slate-500">{{ $symptom['notes'] }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="rounded-xl border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">No symptom data captured.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Clinical documentation</h2>
                <div class="mt-4 space-y-4 text-sm text-slate-600">
                    @if ($appointment->diagnosis)
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                            <p class="text-xs uppercase tracking-wide text-emerald-600">Diagnosis</p>
                            <p class="mt-2 font-semibold text-emerald-800">{{ $appointment->diagnosis->final_diagnosis }}</p>
                            <p class="mt-1 text-xs text-emerald-700">{{ $appointment->diagnosis->clinical_notes }}</p>
                        </div>
                    @else
                        <p class="rounded-xl border border-dashed border-slate-200 px-4 py-6 text-center text-sm text-slate-500">No diagnosis recorded yet.</p>
                    @endif

                    @if ($appointment->prescription)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Prescription</p>
                            <ul class="mt-2 space-y-2 text-sm text-slate-600">
                                @foreach ($appointment->prescription->medicines as $medicine)
                                    <li class="rounded-lg border border-slate-200 bg-white px-3 py-2">
                                        <span class="font-semibold text-slate-800">{{ $medicine->medicine_name }}</span>
                                        <span class="block text-xs text-slate-500">{{ $medicine->dosage }} · {{ $medicine->frequency }} · {{ $medicine->duration }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($appointment->prescription->general_instructions)
                                <p class="mt-3 text-xs text-slate-500">{{ $appointment->prescription->general_instructions }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

