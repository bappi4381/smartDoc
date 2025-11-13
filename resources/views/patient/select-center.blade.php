@extends('layouts.patient')

@section('title', 'Select Diagnostic Center · '.config('app.name', 'SmartDoc'))

@section('page-title', 'Select a Diagnostic Center')
@section('page-subtitle', 'Browse trusted centers to continue your consultation journey')

@php
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $centers */
    $selectedCenterId = session()->has('patient.selected_center_id')
        ? (int) session('patient.selected_center_id')
        : null;
    $filters = $filters ?? null;
@endphp

@section('content')
    <div class="space-y-8">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" action="{{ route('patient.diagnostic-centers.index') }}" class="space-y-6" id="center-filter-form">
                <div class="grid gap-4 md:grid-cols-5">
                    <label class="flex flex-col">
                        <span class="text-sm font-medium text-slate-600">Search</span>
                        <div class="mt-1 flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 focus-within:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M12 17a5 5 0 100-10 5 5 0 000 10z" />
                            </svg>
                            <input
                                type="text"
                                name="search"
                                placeholder="Center name or city"
                                value="{{ $filters?->search }}"
                                class="w-full border-none bg-transparent text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-0"
                            />
                        </div>
                    </label>

                    <label class="flex flex-col">
                        <span class="text-sm font-medium text-slate-600">City</span>
                        <input
                            type="text"
                            name="city"
                            value="{{ $filters?->city }}"
                            placeholder="e.g., Dhaka"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                        />
                    </label>

                    <label class="flex flex-col">
                        <span class="text-sm font-medium text-slate-600">Specialization</span>
                        <input
                            type="text"
                            name="specialization"
                            value="{{ $filters?->specialization }}"
                            placeholder="e.g., Cardiology"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                        />
                    </label>

                    <label class="flex flex-col">
                        <span class="text-sm font-medium text-slate-600">Sort by</span>
                        <select
                            name="sort"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                        >
                            @php
                                $currentSort = $filters?->sortBy ?? 'name';
                            @endphp
                            <option value="name" @selected($currentSort === 'name')>Name (A-Z)</option>
                            <option value="rating" @selected($currentSort === 'rating')>Rating (High → Low)</option>
                            <option value="distance" @selected($currentSort === 'distance')>Distance (Near → Far)</option>
                            <option value="availability" @selected($currentSort === 'availability')>Availability</option>
                        </select>
                    </label>

                    <label class="flex flex-col">
                        <span class="text-sm font-medium text-slate-600">Max distance (km)</span>
                        <input
                            type="number"
                            name="max_distance"
                            value="{{ $filters?->maxDistance }}"
                            min="1"
                            max="200"
                            step="1"
                            placeholder="Optional"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                        />
                    </label>
                </div>

                <input type="hidden" name="latitude" value="{{ $filters?->latitude }}" id="latitude-field">
                <input type="hidden" name="longitude" value="{{ $filters?->longitude }}" id="longitude-field">

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Apply filters
                    </button>

                    <a href="{{ route('patient.diagnostic-centers.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Reset
                    </a>

                    <button type="button" id="use-location" class="inline-flex items-center gap-2 rounded-xl border border-emerald-400/50 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600 transition hover:border-emerald-400 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22c4.418 0 8-5.373 8-10s-3.582-10-8-10-8 5.373-8 10 3.582 10 8 10z" />
                        </svg>
                        Use my location
                    </button>

                    @if (! $filters?->latitude || ! $filters?->longitude)
                        <p class="text-sm text-slate-500">Tip: enable location to see centers sorted by distance.</p>
                    @endif
                </div>
            </form>
        </section>

        <section class="space-y-4">
            <div class="flex flex-col justify-between gap-2 md:flex-row md:items-end">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">
                        Showing {{ $centers->firstItem() ?? 0 }}-{{ $centers->lastItem() ?? 0 }} of {{ $centers->total() }} centers
                    </h2>
                    @if ($filters?->search || $filters?->city || $filters?->specialization)
                        <p class="text-sm text-slate-500">
                            Filters applied:
                            @if($filters?->search) <span class="font-medium">Search:</span> "{{ $filters->search }}" @endif
                            @if($filters?->city) <span class="font-medium">City:</span> {{ $filters->city }} @endif
                            @if($filters?->specialization) <span class="font-medium">Specialization:</span> {{ $filters->specialization }} @endif
                        </p>
                    @else
                        <p class="text-sm text-slate-500">Choose a center to continue with symptom analysis and booking.</p>
                    @endif
                </div>

                <div class="text-sm text-slate-500">
                    Page {{ $centers->currentPage() }} of {{ $centers->lastPage() }}
                </div>
            </div>

            @if ($errors->has('center_id'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                        </svg>
                        <span>{{ $errors->first('center_id') }}</span>
                    </div>
                </div>
            @endif

            @if ($centers->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m1 4H8a2 2 0 01-2-2V7a2 2 0 012-2h1l1-2h4l1 2h1a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                    <p class="font-semibold">No diagnostic centers found</p>
                    <p class="mt-1 text-sm">Try adjusting your filters or search radius.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($centers as $center)
                        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-200 @if($selectedCenterId === $center->id) ring-2 ring-emerald-300 @endif">
                            <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                                <div class="flex-1 space-y-4">
                                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                        <div>
                                            <h3 class="text-xl font-semibold text-slate-800">{{ $center->name }}</h3>
                                            <p class="text-sm text-slate-500">{{ $center->full_address }}</p>
                                        </div>
                                        <div class="inline-flex items-center gap-2 rounded-xl bg-amber-50 px-3 py-1 text-amber-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.066 3.287a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.036a1 1 0 00-.364 1.118l1.067 3.287c.3.921-.755 1.688-1.54 1.118l-2.802-2.036a1 1 0 00-1.176 0l-2.802 2.036c-.784.57-1.838-.197-1.539-1.118l1.067-3.287a1 1 0 00-.364-1.118L2.98 8.714c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.067-3.287z" />
                                            </svg>
                                            <span class="text-sm font-semibold">{{ number_format($center->average_rating, 1) }}</span>
                                            <span class="text-xs text-amber-500">({{ $center->rating_count }} reviews)</span>
                                        </div>
                                    </div>

                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                            <p class="font-medium text-slate-700">Contact</p>
                                            <p class="mt-1 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h2l3.6 7.59-1.35 2.45A2 2 0 009 17h10" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 5h2m-1 0v14" />
                                                </svg>
                                                <span>{{ $center->phone ?? 'Not provided' }}</span>
                                            </p>
                                            @if ($center->email)
                                                <p class="mt-1 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $center->email }}</span>
                                                </p>
                                            @endif
                                        </div>

                                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                            <p class="font-medium text-slate-700">Availability</p>
                                            <p class="mt-1 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $center->has_available_slots ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                                <span class="inline-flex h-2.5 w-2.5 rounded-full {{ $center->has_available_slots ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                                {{ $center->has_available_slots ? 'Accepting appointments' : 'Limited availability' }}
                                            </p>
                                            @if (isset($center->distance_km))
                                                <p class="mt-2 text-sm text-slate-500">
                                                    Distance: <span class="font-medium text-slate-700">{{ number_format($center->distance_km, 1) }} km</span>
                                                </p>
                                            @elseif($filters?->latitude && $filters?->longitude)
                                                <p class="mt-2 text-sm text-slate-400">Distance unavailable for this center.</p>
                                            @else
                                                <p class="mt-2 text-sm text-slate-400">Enable location to calculate distance.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @forelse ($center->specializationLabels() as $tag)
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                                {{ $tag }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400">Specializations coming soon.</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="flex w-full flex-col justify-between gap-4 md:w-56">
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                        <p class="font-medium text-slate-700">Operating hours</p>
                                        <p class="mt-1 text-slate-500">Mon - Sun · 8:00 AM - 10:00 PM</p>
                                        <p class="text-xs text-slate-400">*Confirm availability during booking</p>
                                    </div>

                                    <form method="POST" action="{{ route('patient.diagnostic-centers.select') }}" class="flex flex-col gap-2">
                                        @csrf
                                        <input type="hidden" name="center_id" value="{{ $center->id }}">
                                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                            @if($selectedCenterId === $center->id)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Selected
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8" />
                                                </svg>
                                                Select center
                                            @endif
                                        </button>
                                        <p class="text-center text-xs text-slate-400">You can change your selection anytime before booking.</p>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div>
                    {{ $centers->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        const useLocationButton = document.getElementById('use-location');
        const latitudeField = document.getElementById('latitude-field');
        const longitudeField = document.getElementById('longitude-field');
        const filterForm = document.getElementById('center-filter-form');

        if (useLocationButton) {
            const originalLocationButtonHtml = useLocationButton.innerHTML;

            useLocationButton.addEventListener('click', () => {
                if (! navigator.geolocation) {
                    alert('Geolocation is not supported by your browser.');
                    return;
                }

                useLocationButton.disabled = true;
                useLocationButton.classList.add('opacity-60');
                useLocationButton.innerHTML = '<span class="text-xs font-semibold">Detecting location...</span>';

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        latitudeField.value = position.coords.latitude.toFixed(6);
                        longitudeField.value = position.coords.longitude.toFixed(6);
                        filterForm.submit();
                    },
                    (error) => {
                        console.error(error);
                        alert('Unable to fetch your location. Please check browser permissions.');
                        useLocationButton.disabled = false;
                        useLocationButton.classList.remove('opacity-60');
                        useLocationButton.innerHTML = originalLocationButtonHtml;
                    },
                    { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
                );
            });
        }
    </script>
@endpush

