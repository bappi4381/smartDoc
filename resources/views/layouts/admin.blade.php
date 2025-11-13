<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'SmartDoc Admin')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-sans text-slate-900">
        <div class="min-h-screen">
            <div class="flex">
                <aside class="hidden w-72 flex-col justify-between bg-slate-950 px-6 py-8 text-slate-200 xl:flex">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-lg font-semibold">SmartDoc Admin</p>
                                <p class="text-xs text-slate-400">Control &amp; intelligence</p>
                            </div>
                        </div>

                        @php
                            $navLinks = [
                                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7m-9 13V5m0 0L5 10m14 0l-7-7'],
                                ['label' => 'Diagnostic Centers', 'route' => 'admin.centers.index', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                                ['label' => 'Doctors', 'route' => 'admin.doctors.index', 'icon' => 'M16 14a4 4 0 10-8 0v4h8v-4zm6 4v-4a6 6 0 10-12 0v4'],
                                ['label' => 'Appointments', 'route' => 'admin.appointments.index', 'icon' => 'M8 7V3m8 4V3M5 11h14M5 19h14M7 11v8m10-8v8'],
                                ['label' => 'Notifications', 'route' => 'admin.notifications.index', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z'],
                            ];
                        @endphp

                        <nav class="mt-10 space-y-2 text-sm">
                            @foreach ($navLinks as $link)
                                <a
                                    href="{{ route($link['route']) }}"
                                    class="flex items-center gap-3 rounded-xl px-4 py-2 transition @if(request()->routeIs($link['route'].'*')) bg-emerald-500/10 text-emerald-300 @else text-slate-300 hover:bg-slate-800/60 @endif"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $link['icon'] }}" />
                                    </svg>
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="space-y-2 text-xs text-slate-500">
                        <p class="font-medium text-slate-300">{{ auth()->user()->name }}</p>
                        <p>&copy; {{ date('Y') }} SmartDoc. Admin Console.</p>
                    </div>
                </aside>

                <div class="flex min-h-screen flex-1 flex-col">
                    <header class="border-b border-slate-200 bg-white/80 backdrop-blur">
                        <div class="flex flex-wrap items-center justify-between gap-4 px-4 py-4 lg:px-8">
                            <div>
                                <h1 class="text-lg font-semibold text-slate-800">@yield('page-title', 'Executive Control Center')</h1>
                                <p class="text-sm text-slate-500">@yield('page-subtitle', 'Monitor operations, optimize resources, and ensure care excellence.')</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="hidden text-right text-sm text-slate-500 sm:block">
                                    <p class="font-medium text-slate-700">{{ auth()->user()->name }}</p>
                                    <p class="text-xs uppercase tracking-wide text-emerald-500">Administrator</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-rose-300 hover:bg-rose-50 hover:text-rose-600"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M12 9l3-3m0 0l3 3m-3-3v12" />
                                        </svg>
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 px-4 py-8 lg:px-10 xl:px-12">
                        @if (session('status'))
                            <div class="mb-6 rounded-xl border border-emerald-400/50 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>

