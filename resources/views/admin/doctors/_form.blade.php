@php
    $doctor = $doctor ?? null;
    $user = $doctor?->user;
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Full name<span class="text-rose-500">*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('name')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email<span class="text-rose-500">*</span></label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('email')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="phone" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Phone<span class="text-rose-500">*</span></label>
        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('phone')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="date_of_birth" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Date of birth<span class="text-rose-500">*</span></label>
        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', optional($user?->date_of_birth)->format('Y-m-d')) }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('date_of_birth')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="gender" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Gender<span class="text-rose-500">*</span></label>
        <select id="gender" name="gender" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
            @foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                <option value="{{ $value }}" @selected(old('gender', $user->gender ?? 'male') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('gender')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="address" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Address<span class="text-rose-500">*</span></label>
        <input id="address" name="address" type="text" value="{{ old('address', $user->address ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('address')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Password{{ $doctor ? '' : ' (set & share securely)' }}</label>
        <input id="password" name="password" type="password"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100"
            @if(! $doctor) required @endif>
        @error('password')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
        @if($doctor)
            <p class="mt-1 text-xs text-slate-400">Leave blank to keep existing password.</p>
        @endif
    </div>
    <div>
        <label for="diagnostic_center_id" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Primary diagnostic center<span class="text-rose-500">*</span></label>
        <select id="diagnostic_center_id" name="diagnostic_center_id" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
            @foreach ($centers as $center)
                <option value="{{ $center->id }}" @selected(old('diagnostic_center_id', $doctor->diagnostic_center_id ?? '') == $center->id)>
                    {{ $center->name }}
                </option>
            @endforeach
        </select>
        @error('diagnostic_center_id')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="specialization" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Specialization<span class="text-rose-500">*</span></label>
        <input id="specialization" name="specialization" type="text" value="{{ old('specialization', $doctor->specialization ?? '') }}" required
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('specialization')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="qualifications" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Qualifications</label>
        <input id="qualifications" name="qualifications" type="text" value="{{ old('qualifications', $doctor->qualifications ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('qualifications')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="experience_years" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Experience (years)</label>
        <input id="experience_years" name="experience_years" type="number" min="0" max="60" value="{{ old('experience_years', $doctor->experience_years ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('experience_years')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="consultation_fee" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Consultation fee (BDT)</label>
        <input id="consultation_fee" name="consultation_fee" type="number" step="0.01" value="{{ old('consultation_fee', $doctor->consultation_fee ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('consultation_fee')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="registration_number" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Registration number</label>
        <input id="registration_number" name="registration_number" type="text" value="{{ old('registration_number', $doctor->registration_number ?? '') }}"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
        @error('registration_number')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label for="bio" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Bio</label>
        <textarea id="bio" name="bio" rows="3"
            class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">{{ old('bio', $doctor->bio ?? '') }}</textarea>
        @error('bio')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6">
    <label class="flex items-center gap-3 text-sm text-slate-600">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $doctor->is_active ?? true))
            class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-400">
        <span class="font-medium text-slate-700">Doctor is currently active and visible for scheduling</span>
    </label>
</div>

