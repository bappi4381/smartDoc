@extends('layouts.patient')

@section('title', 'Find Doctors · '.config('app.name', 'SmartDoc'))

@section('page-title', 'Doctor Discovery & Selection')
@section('page-subtitle', 'Compare specialists inside '.$selectedCenterName.' and book with confidence')

@php
    /** @var \App\DataTransferObjects\Patient\DoctorDiscoveryFilterData $filters */
    /** @var \App\DataTransferObjects\Patient\DoctorDiscoveryResult $result */
    $recommendedSpecializations = $recommendedSpecializations ?? [];
    $aiPrediction = $aiPrediction ?? null;
    $aiGeneratedAt = $aiGeneratedAt ?? null;
@endphp

@section('content')
    <div class="space-y-8">
        <section class="rounded-2xl border border-emerald-100 bg-white/95 p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide text-emerald-500">Diagnostic center</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $selectedCenterName }}</p>
                    @if ($aiPrediction)
                        <p class="mt-1 text-sm text-slate-500">
                            Based on AI insight: <span class="font-semibold text-slate-700">{{ $aiPrediction }}</span>
                            @if($aiGeneratedAt)
                                · <span class="text-slate-400">{{ \Carbon\Carbon::parse($aiGeneratedAt)->diffForHumans() }}</span>
                            @endif
                        </p>
                    @else
                        <p class="mt-1 text-sm text-slate-500">
                            Run <a href="{{ route('patient.symptoms.create') }}" class="font-medium text-emerald-600 underline-offset-2 hover:underline">AI symptom analysis</a> for tailored matches.
                        </p>
                    @endif
                </div>
                @if (! empty($recommendedSpecializations))
                    <div class="flex flex-wrap gap-2 text-xs">
                        @foreach ($recommendedSpecializations as $specialization)
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $specialization }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            <form method="GET" action="{{ route('patient.doctors.index') }}" class="mt-6 space-y-5" id="doctor-filter-form">
                <div class="grid gap-4 md:grid-cols-4">
                    <label class="flex flex-col">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Specialization</span>
                        <input
                            type="text"
                            name="specialization"
                            list="specialization-hints"
                            value="{{ $filters->specialization ?? '' }}"
                            placeholder="e.g., Cardiologist"
                            class="mt-1 rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                            data-auto-submit
                        />
                        <datalist id="specialization-hints">
                            @foreach ($recommendedSpecializations as $specialization)
                                <option value="{{ $specialization }}"></option>
                            @endforeach
                        </datalist>
                    </label>

                    <label class="flex flex-col">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Availability</span>
                        <select
                            name="availability"
                            class="mt-1 rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                            data-auto-submit
                        >
                            <option value="">Any time</option>
                            <option value="available_now" @selected($filters->availability === 'available_now')>Open slots</option>
                            <option value="limited" @selected($filters->availability === 'limited')>Limited slots</option>
                        </select>
                    </label>

                    <label class="flex flex-col">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Minimum rating</span>
                        <div class="mt-2 flex items-center gap-3">
                            <input
                                type="range"
                                name="min_rating"
                                min="0"
                                max="5"
                                step="0.5"
                                value="{{ $filters->minRating ?? 0 }}"
                                class="flex-1 accent-emerald-500"
                                data-range-display="#rating-display"
                            />
                            <span id="rating-display" class="text-sm font-semibold text-slate-700">
                                {{ number_format($filters->minRating ?? 0, 1) }}★
                            </span>
                        </div>
                    </label>

                    <label class="flex flex-col">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Consultation fee (৳)</span>
                        <div class="mt-1 grid grid-cols-2 gap-2">
                            <input
                                type="number"
                                name="min_fee"
                                min="0"
                                max="5000"
                                step="50"
                                value="{{ $filters->minConsultationFee ?? '' }}"
                                placeholder="Min"
                                class="rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                                data-auto-submit
                            />
                            <input
                                type="number"
                                name="max_fee"
                                min="0"
                                max="5000"
                                step="50"
                                value="{{ $filters->maxConsultationFee ?? '' }}"
                                placeholder="Max"
                                class="rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                                data-auto-submit
                            />
                        </div>
                    </label>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <label class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-emerald-300 hover:text-emerald-600">
                        <input type="checkbox" name="only_recommended" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" @checked($filters->onlyRecommended)>
                        Prioritize AI matches
                    </label>

                    <select
                        name="sort"
                        class="rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                        data-auto-submit
                    >
                        <option value="recommended" @selected($filters->sort === 'recommended')>Recommended first</option>
                        <option value="rating" @selected($filters->sort === 'rating')>Rating (high → low)</option>
                        <option value="experience" @selected($filters->sort === 'experience')>Experience</option>
                        <option value="fee_low_high" @selected($filters->sort === 'fee_low_high')>Fee (low → high)</option>
                        <option value="fee_high_low" @selected($filters->sort === 'fee_high_low')>Fee (high → low)</option>
                        <option value="availability" @selected($filters->sort === 'availability')>Availability</option>
                    </select>

                    <select
                        name="per_page"
                        class="rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                        data-auto-submit
                    >
                        @foreach ([6, 9, 12, 15] as $size)
                            <option value="{{ $size }}" @selected($filters->perPage === $size)>Show {{ $size }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Apply filters
                    </button>

                    <a href="{{ route('patient.doctors.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="space-y-4">
            <div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Showing {{ $result->doctors->firstItem() ?? 0 }}-{{ $result->doctors->lastItem() ?? 0 }} of {{ $result->doctors->total() }} doctors
                    </h2>
                    <p class="text-sm text-slate-500">
                        {{ $result->recommendedMatches }} match your AI-recommended specialties.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                    @forelse ($result->activeFilters as $badge)
                        <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-3 py-1 font-semibold text-slate-600">
                            {{ $badge }}
                        </span>
                    @empty
                        <span class="text-slate-400">No filters applied.</span>
                    @endforelse
                </div>
            </div>

            @if ($result->doctors->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white/90 px-6 py-10 text-center text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8m-8 4h5m-5 4h8M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2h-3.382a2 2 0 01-1.894-1.316L13.618 2.316A2 2 0 0011.724 1H5a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    <p class="font-semibold text-slate-700">No doctors found</p>
                    <p class="mt-1 text-sm">Adjust filters or explore a different specialization.</p>
                    <a href="{{ route('patient.symptoms.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-full border border-emerald-300 px-4 py-2 text-sm font-semibold text-emerald-600 hover:bg-emerald-50">
                        Rerun AI analysis
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 8a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v7m-3-3h6" />
                        </svg>
                    </a>
                </div>
            @else
                <div class="grid gap-4 lg:grid-cols-2">
                    @foreach ($result->doctors as $card)
                        <article class="rounded-2xl border border-slate-200 bg-white/95 p-5 shadow-sm transition hover:border-emerald-200">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-xl font-semibold text-slate-800">{{ $card->name }}</h3>
                                            @if ($card->isRecommended)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                                    AI recommended
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-slate-500">{{ $card->specialization }}</p>
                                        @if ($card->qualifications)
                                            <p class="text-xs text-slate-400">{{ $card->qualifications }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        @if ($card->rating)
                                            <div class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-sm font-semibold text-amber-600">
                                                ★ {{ number_format($card->rating, 1) }}
                                                <span class="text-xs text-amber-500">({{ $card->ratingCount }})</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">No ratings yet</span>
                                        @endif
                                        <p class="mt-2 text-xs text-slate-400">{{ $card->experienceYears }} yrs experience</p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold
                                        @class([
                                            'bg-emerald-50 text-emerald-600' => $card->availabilityTone === 'positive',
                                            'bg-amber-50 text-amber-600' => $card->availabilityTone === 'warning',
                                            'bg-rose-50 text-rose-600' => $card->availabilityTone === 'danger',
                                        ])
                                    ">
                                        <span class="inline-block h-2 w-2 rounded-full
                                            @class([
                                                'bg-emerald-500' => $card->availabilityTone === 'positive',
                                                'bg-amber-500' => $card->availabilityTone === 'warning',
                                                'bg-rose-500' => $card->availabilityTone === 'danger',
                                            ])
                                        "></span>
                                        {{ $card->availabilityLabel }}
                                    </span>
                                    <span>Fee: {{ $card->consultationFee ? '৳'.number_format($card->consultationFee, 0) : 'Contact center' }}</span>
                                    @if ($card->nextAvailableSlot)
                                        <span>Next slot: {{ $card->nextAvailableSlot->format('M d · g:i A') }}</span>
                                    @endif
                                </div>

                                <div class="rounded-2xl border border-slate-100 bg-slate-50/80 px-4 py-3 text-sm text-slate-600">
                                    {{ $card->bio ? \Illuminate\Support\Str::limit($card->bio, 180) : __('This doctor will add a profile summary soon.') }}
                                </div>

                                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                                    @if ($card->contactPhone)
                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h2l3 7-1 2a2 2 0 002 3h7" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 5h2v14h-2" />
                                            </svg>
                                            {{ $card->contactPhone }}
                                        </span>
                                    @endif
                                    @if ($card->contactEmail)
                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $card->contactEmail }}
                                        </span>
                                    @endif
                                </div>

                                <button
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-300 hover:text-emerald-600"
                                    data-toggle-details
                                    aria-expanded="false"
                                    aria-controls="doctor-details-{{ $card->id }}"
                                >
                                    View profile details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div id="doctor-details-{{ $card->id }}" class="hidden rounded-2xl border border-dashed border-slate-200/80 px-4 py-3 text-sm text-slate-600">
                                    <p class="font-semibold text-slate-700">Profile overview</p>
                                    <ul class="mt-2 list-disc space-y-1 pl-4 text-slate-500">
                                        <li>Experience: {{ $card->experienceYears }} years in {{ $card->specialization }}</li>
                                        <li>Average response time: under 4 hours</li>
                                        <li>Consultation includes digital prescription & follow-up guidance</li>
                                    </ul>
                                </div>

                                <a href="{{ route('patient.symptoms.create') }}"
                                   class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-500">
                                    Proceed to appointment booking
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div>
                    {{ $result->doctors->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const filterForm = document.getElementById('doctor-filter-form');
        const autoSubmitFields = filterForm?.querySelectorAll('[data-auto-submit]');

        if (autoSubmitFields) {
            autoSubmitFields.forEach((field) => {
                field.addEventListener('change', () => {
                    filterForm.requestSubmit();
                });
            });
        }

        document.querySelectorAll('[data-range-display]').forEach((range) => {
            const target = document.querySelector(range.dataset.rangeDisplay);
            const updateDisplay = () => {
                if (target) {
                    target.textContent = parseFloat(range.value).toFixed(1) + '★';
                }
            };
            range.addEventListener('input', updateDisplay);
            updateDisplay();
        });

        document.querySelectorAll('[data-toggle-details]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('aria-controls');
                const target = document.getElementById(targetId);
                if (! target) {
                    return;
                }
                const isOpen = target.classList.toggle('hidden') === false;
                button.setAttribute('aria-expanded', String(isOpen));
                button.querySelector('svg')?.classList.toggle('rotate-180', isOpen);
            });
        });
    </script>
@endpush

