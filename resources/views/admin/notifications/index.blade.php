@extends('layouts.admin')

@section('title', 'Notifications · Admin')
@section('page-title', 'Engagement & Alerts')
@section('page-subtitle', 'Broadcast updates, monitor delivery, and maintain clinical awareness.')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="space-y-8">
        <section class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-800">Broadcast notification</h2>
            <p class="text-sm text-slate-500">Send AI-assisted reminders, policy updates, or critical alerts across the network.</p>

            <form method="POST" action="{{ route('admin.notifications.broadcast') }}" class="mt-6 grid gap-6 md:grid-cols-2">
                @csrf

                <div>
                    <label for="title" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Title<span class="text-rose-500">*</span></label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required
                        class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    @error('title')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="action_url" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Action URL</label>
                    <input id="action_url" name="action_url" type="url" value="{{ old('action_url') }}"
                        class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                    @error('action_url')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="message" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Message<span class="text-rose-500">*</span></label>
                    <textarea id="message" name="message" rows="4" required
                        class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Audience<span class="text-rose-500">*</span></label>
                    <select name="scope" id="scope" required
                        class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                        <option value="all">All users</option>
                        <option value="role" @selected(old('scope') === 'role')>By role</option>
                        <option value="users" @selected(old('scope') === 'users')>Specific users (IDs)</option>
                    </select>
                    @error('scope')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Role</label>
                    <select name="role"
                        class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">
                        <option value="">Select role</option>
                        @foreach (['patient' => 'Patients', 'doctor' => 'Doctors', 'diagnostic_center' => 'Diagnostic centers'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('role') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">User IDs</label>
                    <textarea name="user_ids[]" rows="2" placeholder="Comma separated user IDs (only when targeting specific users)"
                        class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-emerald-100">{{ old('user_ids.0') }}</textarea>
                    @error('user_ids.*')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2 flex items-center gap-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-600">
                        Broadcast notification
                    </button>
                    <p class="text-xs text-slate-400">Messages are delivered via email and in-app inbox.</p>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white/95 p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-slate-800">Notification inbox</h2>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-emerald-600">Unread: {{ number_format($unreadCount) }}</span>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Notification</th>
                            <th class="px-6 py-3 font-medium">Audience</th>
                            <th class="px-6 py-3 font-medium">Created</th>
                            <th class="px-6 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                        @foreach ($notifications as $notification)
                            @php
                                $data = $notification->data ?? [];
                            @endphp
                            <tr class="transition hover:bg-emerald-50/60">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">{{ $data['title'] ?? 'Untitled notification' }}</div>
                                    <div class="text-xs text-slate-500">{{ $data['message'] ?? 'No message body' }}</div>
                                    @if (! empty($data['action_url']))
                                        <a href="{{ $data['action_url'] }}" target="_blank" rel="noopener"
                                            class="mt-1 inline-block text-xs font-semibold text-emerald-600 hover:underline">
                                            View action link
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-slate-500">Notifiable: {{ class_basename($notification->notifiable_type) }}</div>
                                    <div class="text-xs text-slate-400">ID: {{ $notification->notifiable_id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</div>
                                    <div class="text-xs text-slate-400">
                                        {{ $notification->read_at ? 'Read '.$notification->read_at->diffForHumans() : 'Unread' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if (! $notification->read_at)
                                            <form method="POST" action="{{ route('admin.notifications.read') }}">
                                                @csrf
                                                <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
                                                <button type="submit"
                                                    class="rounded-xl border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:text-emerald-600">
                                                    Mark read
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.notifications.destroy') }}"
                                            onsubmit="return confirm('Delete this notification entry?')">
                                            @csrf
                                            <input type="hidden" name="notification_ids[]" value="{{ $notification->id }}">
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
                {{ $notifications->withQueryString()->links() }}
            </div>
        </section>
    </div>
@endsection

