@extends('layouts.admin')

@section('title', 'Admin Dashboard · '.config('app.name'))
@section('page-title', 'Operational Intelligence')
@section('page-subtitle', 'Real-time overview of patient flow, provider capacity, and engagement.')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="space-y-10">
        <section>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @php
                    $overviewCards = [
                        ['label' => 'Active Patients', 'value' => number_format($overview['total_patients']), 'icon' => 'M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z'],
                        ['label' => 'Licensed Doctors', 'value' => number_format($overview['total_doctors']), 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['label' => 'Diagnostic Centers', 'value' => number_format($overview['total_centers']), 'icon' => 'M4 6h16M4 12h16M4 18h16'],
                        ['label' => 'Upcoming Appointments', 'value' => number_format($overview['upcoming_appointments']), 'icon' => 'M8 7V3m8 4V3M5 11h14M5 19h14'],
                    ];
                @endphp

                @foreach ($overviewCards as $card)
                    <article class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-sm backdrop-blur">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-400">{{ $card['label'] }}</p>
                                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $card['value'] }}</p>
                            </div>
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}" />
                                </svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-5">
            <div class="rounded-2xl border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur xl:col-span-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">14-day appointment velocity</h2>
                        <p class="text-sm text-slate-500">Monitor volume trends to forecast capacity.</p>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    @foreach ($appointmentTrends as $trend)
                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-24 text-xs font-medium text-slate-500">{{ \Carbon\CarbonImmutable::parse($trend['date'])->format('M d') }}</span>
                            <div class="relative h-2 flex-1 rounded-full bg-slate-100">
                                <span class="absolute left-0 top-0 h-2 rounded-full bg-emerald-500/80" style="width: {{ min($trend['total'] * 4, 100) }}%"></span>
                            </div>
                            <span class="w-10 text-right text-xs font-semibold text-slate-600">{{ $trend['total'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur xl:col-span-2">
                <h2 class="text-lg font-semibold text-slate-800">Appointment status mix</h2>
                <ul class="mt-6 space-y-3 text-sm text-slate-600">
                    @foreach ($statusSummary as $status => $total)
                        <li class="flex items-center justify-between rounded-xl border border-slate-200 px-4 py-2">
                            <span class="font-medium text-slate-700">{{ Str::headline($status) }}</span>
                            <span class="text-xs font-semibold text-emerald-600">{{ number_format($total) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800">Specialization coverage</h2>
                <p class="text-sm text-slate-500">Ensure patient predictions can map to available expertise.</p>
                <div class="mt-6 space-y-3">
                    @foreach ($specializations as $specialization)
                        <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-2 text-sm text-slate-600">
                            <span class="font-medium text-slate-700">{{ $specialization->specialization ?: 'General Practice' }}</span>
                            <span class="text-xs font-semibold text-emerald-600">{{ number_format($specialization->total) }} doctors</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800">Top-performing centers</h2>
                <p class="text-sm text-slate-500">Breakdown by appointment volume.</p>
                <div class="mt-6 space-y-3">
                    @foreach ($topCenters as $centerStat)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-slate-800">{{ $centerStat->diagnosticCenter->name ?? 'Unknown Center' }}</span>
                                <span class="text-xs font-semibold text-emerald-600">{{ number_format($centerStat->total) }} appointments</span>
                            </div>
                            @if ($centerStat->diagnosticCenter?->city)
                                <p class="mt-1 text-xs text-slate-500">{{ $centerStat->diagnosticCenter->city }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

