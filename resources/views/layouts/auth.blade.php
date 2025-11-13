<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'SmartDoc'))</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <div class="flex min-h-screen flex-col lg:flex-row">
            <aside class="relative hidden w-full flex-col justify-between overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-slate-900 px-12 py-14 text-emerald-50 lg:flex lg:w-[46%]">
                <div class="pointer-events-none absolute inset-0">
                    <div class="absolute -top-20 -left-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute bottom-10 right-0 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>
                </div>
                <div class="relative z-10 space-y-8">
                    <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-100/80">
                        SmartDoc Platform
                    </div>
                    <div class="space-y-3">
                        <h1 class="text-4xl font-semibold leading-tight text-white">@yield('heading', 'AI-Powered Healthcare, Simplified')</h1>
                        <p class="text-base text-emerald-100/80">
                            @yield('subheading', 'Seamlessly manage appointments, analyze symptoms, and deliver care faster with our intelligent patient experience platform.')
                        </p>
                    </div>
                </div>
                <div class="relative z-10 space-y-3 text-sm text-emerald-100/80">
                    <p class="font-medium text-white">We protect your data.</p>
                    <ul class="space-y-1">
                        <li class="flex items-center gap-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                            HIPAA-ready security controls
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                            End-to-end encryption for all sessions
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                            Role-based access for every practitioner
                        </li>
                    </ul>
                    <p class="pt-4 text-xs uppercase tracking-[0.3em] text-emerald-100/60">&copy; {{ date('Y') }} SmartDoc Health</p>
                </div>
            </aside>

            <main class="flex w-full items-center justify-center px-6 py-12 lg:w-[54%] lg:px-16 lg:py-16">
                <div class="w-full max-w-md space-y-8">
                    <div class="space-y-3 text-center lg:text-left">
                        <div class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 lg:justify-start">
                            <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            Secure patient login
                        </div>
                        <h2 class="text-3xl font-semibold text-slate-900">@yield('heading', 'Welcome to SmartDoc')</h2>
                        <p class="text-sm text-slate-500">@yield('subheading', 'Access your personalized care experience')</p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white/90 p-8 shadow-2xl shadow-emerald-100/60 backdrop-blur">
                        @if (session('status'))
                            <div class="mb-4 inline-flex w-full items-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ session('status') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
                                <strong class="font-semibold">We found some issues:</strong>
                                <ul class="mt-2 list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')
                    </div>

                    @hasSection('footer')
                        <div class="text-center text-sm text-slate-500 lg:text-left">
                            @yield('footer')
                        </div>
                    @endif
                </div>
            </main>
        </div>
        @stack('scripts')
    </body>
</html>

