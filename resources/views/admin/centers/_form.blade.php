@php
    $center = $center ?? null;
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Center name<span class="text-rose-500">*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name', $center->name ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('name')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="slug" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $center->slug ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('slug')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $center->email ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('email')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="phone" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Phone</label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $center->phone ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('phone')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label for="address_line1" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Address line 1<span class="text-rose-500">*</span></label>
        <input id="address_line1" name="address_line1" type="text" value="{{ old('address_line1', $center->address_line1 ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('address_line1')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label for="address_line2" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Address line 2</label>
        <input id="address_line2" name="address_line2" type="text" value="{{ old('address_line2', $center->address_line2 ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('address_line2')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="city" class="text-xs font-semibold uppercase tracking-wide text-slate-500">City<span class="text-rose-500">*</span></label>
        <input id="city" name="city" type="text" value="{{ old('city', $center->city ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('city')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="state" class="text-xs font-semibold uppercase tracking-wide text-slate-500">State</label>
        <input id="state" name="state" type="text" value="{{ old('state', $center->state ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('state')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="postal_code" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Postal code</label>
        <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $center->postal_code ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('postal_code')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="country" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Country</label>
        <input id="country" name="country" type="text" value="{{ old('country', $center->country ?? 'Bangladesh') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('country')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="latitude" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Latitude</label>
        <input id="latitude" name="latitude" type="number" step="0.000001" value="{{ old('latitude', $center->latitude ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('latitude')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="longitude" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Longitude</label>
        <input id="longitude" name="longitude" type="number" step="0.000001" value="{{ old('longitude', $center->longitude ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('longitude')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Specializations</label>
        <textarea name="specializations[]" rows="3" placeholder="Comma separated (e.g., Cardiology, Orthopedics)"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">{{ old('specializations.0', $center ? implode(', ', (array) $center->specializations) : '') }}</textarea>
        @error('specializations.*')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
        <p class="mt-1 text-xs text-slate-400">Separate values with commas. They help match AI predictions with doctors.</p>
    </div>
</div>

<div class="mt-6 grid gap-6 md:grid-cols-2">
    <label class="flex items-center gap-3 text-sm text-slate-600">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $center->is_active ?? true))
            class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-400">
        <span class="font-medium text-slate-700">Center is active</span>
    </label>
    <label class="flex items-center gap-3 text-sm text-slate-600">
        <input type="checkbox" name="has_available_slots" value="1" @checked(old('has_available_slots', $center->has_available_slots ?? true))
            class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-400">
        <span class="font-medium text-slate-700">Accepting new appointments</span>
    </label>
</div>

