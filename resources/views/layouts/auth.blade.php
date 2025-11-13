<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'SmartDoc'))</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <style>
            :root {
                color-scheme: light;
            }

            .auth-wrapper {
                background: #f4f6fb;
            }

            .auth-hero {
                background: radial-gradient(circle at top left, rgba(22, 201, 154, 0.25), transparent 60%),
                    radial-gradient(circle at bottom right, rgba(22, 201, 154, 0.3), transparent 65%),
                    linear-gradient(135deg, #0f766e 0%, #111827 100%);
                color: #ffffff;
            }

            .auth-hero .badge {
                background-color: rgba(255, 255, 255, 0.15);
                letter-spacing: 0.25em;
            }

            .auth-card {
                border: none;
                border-radius: 1.5rem;
                box-shadow: 0 30px 60px -25px rgba(15, 118, 110, 0.25);
                backdrop-filter: blur(12px);
            }

            .auth-card .form-control {
                border-radius: 1rem;
                padding: 0.75rem 1rem;
            }

            .auth-card .form-control:focus {
                box-shadow: 0 0 0 0.25rem rgba(15, 118, 110, 0.15);
                border-color: #0f766e;
            }

            .auth-card .btn-primary {
                background: linear-gradient(135deg, #0f766e, #14b8a6);
                border: none;
            }

            .auth-card .btn-primary:hover {
                background: linear-gradient(135deg, #115e59, #0f766e);
            }
        </style>
    </head>
    <body class="auth-wrapper">
        <div class="d-flex flex-column flex-lg-row min-vh-100">
            <aside class="auth-hero d-none d-lg-flex flex-column justify-between w-100 p-5 p-xl-6" style="max-width: 480px;">
                <div>
                    <span class="badge rounded-pill px-4 py-2 text-uppercase text-white-50">SmartDoc Platform</span>
                    <h1 class="mt-4 display-5 fw-semibold">@yield('heading', 'AI-Powered Healthcare, Simplified')</h1>
                    <p class="lead text-white-50 mt-3">
                        @yield('subheading', 'Seamlessly manage appointments, analyze symptoms, and deliver care faster with our intelligent patient experience platform.')
                    </p>
                </div>
                <div class="pt-4">
                    <p class="fw-semibold text-white mb-3">Enterprise-grade security</p>
                    <div class="row row-cols-1 gy-2 text-white-50">
                        <div class="col d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill text-white"></i>
                            HIPAA-ready safeguards
                        </div>
                        <div class="col d-flex align-items-center gap-2">
                            <i class="bi bi-fingerprint text-white"></i>
                            Adaptive authentication
                        </div>
                        <div class="col d-flex align-items-center gap-2">
                            <i class="bi bi-diagram-3-fill text-white"></i>
                            Role-based access workflows
                        </div>
                    </div>
                    <p class="text-uppercase text-white-50 small letter-spacing pt-4 mb-0">&copy; {{ date('Y') }} SmartDoc Health</p>
                </div>
            </aside>

            <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5 py-lg-0 px-3 px-lg-5">
                <div class="container" style="max-width: 520px;">
                    <div class="mb-4 text-center text-lg-start">
                        <span class="badge rounded-pill bg-light text-secondary px-3 py-2 text-uppercase fw-semibold">
                            @yield('badge', 'Patient Access')
                        </span>
                        <h2 class="mt-3 fw-semibold text-dark">@yield('heading', 'Welcome to SmartDoc')</h2>
                        <p class="text-muted mb-0">@yield('subheading', 'Access your personalized care experience')</p>
                    </div>

                    <div class="card auth-card">
                        <div class="card-body p-4 p-lg-5">
                            @if (session('status'))
                                <div class="alert alert-success d-flex align-items-center gap-2 rounded-4" role="alert">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <div>{{ session('status') }}</div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger rounded-4" role="alert">
                                    <h6 class="fw-semibold mb-2">We noticed a few issues:</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @yield('content')
                        </div>
                    </div>

                    @hasSection('footer')
                        <div class="text-center text-muted mt-4">
                            @yield('footer')
                        </div>
                    @endif
                </div>
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>

