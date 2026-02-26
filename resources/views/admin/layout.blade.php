<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="id-service-url" content="{{ request()->secure() ? 'https://' : 'http://' }}{{ config('domains.africoders.id') }}">
    <title>@yield('title', 'Admin Panel') - Africoders Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- Custom Admin Styles -->
    <style>
        :root {
            --color-primary: #1a73e8;
            --color-secondary: #5f6368;
            --sidebar-width: 250px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--color-primary) !important;
        }

        .nav-link {
            color: var(--color-secondary);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.125rem 0;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #f1f3f4;
            color: var(--color-primary);
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: #1557b0;
            border-color: #1557b0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: var(--color-secondary);
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
        }

        .sidebar-header {
            flex-shrink: 0;
            padding-bottom: 1rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 0.5rem;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        .accordion-button {
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--color-secondary);
            background-color: transparent;
            border: none;
            border-radius: 0.375rem;
            margin: 0.125rem 0;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f1f3f4;
            color: var(--color-primary);
            box-shadow: none;
        }

        .accordion-button:hover {
            background-color: #f1f3f4;
            color: var(--color-primary);
        }

        .accordion-button:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
        }

        .accordion-button::after {
            filter: invert(0.5);
        }

        .accordion-item {
            border: none;
            background-color: transparent;
            margin-bottom: 0.5rem;
        }

        .accordion-body {
            padding: 0 0 0 1rem;
        }

        .accordion-nav-item {
            padding: 0.5rem 1rem;
            margin: 0.125rem 0;
            border-radius: 0.375rem;
            color: var(--color-secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .accordion-nav-item:hover {
            background-color: #f1f3f4;
            color: var(--color-primary);
            text-decoration: none;
        }

        .accordion-nav-item.active {
            background-color: #e8f0fe;
            color: var(--color-primary);
            font-weight: 500;
        }

        .accordion-nav-item i {
            margin-right: 0.75rem;
            width: 1rem;
            text-align: center;
        }

        .sidebar-footer {
            flex-shrink: 0;
            border-top: 1px solid #e2e8f0;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar p-3">
        <div class="sidebar-header">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-shield-check text-primary me-2" style="font-size: 1.5rem;"></i>
                <span class="navbar-brand mb-0">Admin Panel</span>
            </div>
        </div>

        <div class="sidebar-nav">
            <!-- Quick Links -->
            <div class="d-grid gap-2 mb-3">
                <a class="btn btn-sm {{ request()->routeIs('admin.dashboard*') && !request()->routeIs('admin.help.*') ? 'btn-primary' : 'btn-outline-secondary' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a class="btn btn-sm {{ request()->routeIs('admin.users.*') ? 'btn-primary' : 'btn-outline-secondary' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people me-2"></i>Users
                </a>
            </div>

            <!-- Accordion Menu -->
            <div class="accordion accordion-flush" id="sidebarAccordion">
                <!-- Verification Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#verificationCollapse" aria-expanded="false" aria-controls="verificationCollapse">
                            <i class="bi bi-check-circle me-2"></i>Verification
                        </button>
                    </h2>
                    <div id="verificationCollapse" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('admin.verifications.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.verifications.index') ? 'active' : '' }}">
                                <i class="bi bi-check-circle-fill"></i>
                                <span class="flex-grow-1">All Verifications</span>
                                @if(isset($pendingVerificationsCount) && $pendingVerificationsCount > 0)
                                    <span class="badge bg-warning rounded-pill">{{ $pendingVerificationsCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Audit & Security Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#auditCollapse" aria-expanded="false" aria-controls="auditCollapse">
                            <i class="bi bi-shield-lock me-2"></i>Security
                        </button>
                    </h2>
                    <div id="auditCollapse" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('admin.audit-logs.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.audit-logs.index') ? 'active' : '' }}">
                                <i class="bi bi-journal-text"></i>
                                <span>Audit Logs</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Help Center Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#helpCollapse" aria-expanded="false" aria-controls="helpCollapse">
                            <i class="bi bi-question-circle me-2"></i>Help Center
                        </button>
                    </h2>
                    <div id="helpCollapse" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('admin.help.dashboard') }}" class="accordion-nav-item {{ request()->routeIs('admin.help.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.help.messages.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.help.messages.*') ? 'active' : '' }}">
                                <i class="bi bi-envelope"></i>
                                <span class="flex-grow-1">Messages</span>
                                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                    <span class="badge bg-warning rounded-pill ms-2">{{ $unreadMessagesCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('admin.help.articles.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.help.articles.*') ? 'active' : '' }}">
                                <i class="bi bi-file-text"></i>
                                <span>Articles</span>
                            </a>
                            <a href="{{ route('admin.help.faqs.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.help.faqs.*') ? 'active' : '' }}">
                                <i class="bi bi-patch-question"></i>
                                <span>FAQs</span>
                            </a>
                            <a href="{{ route('admin.help.legal.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.help.legal.*') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Legal</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- KortexTools Section -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kortextoolsCollapse" aria-expanded="false" aria-controls="kortextoolsCollapse">
                            <i class="bi bi-tools me-2"></i>KortexTools
                        </button>
                    </h2>
                    <div id="kortextoolsCollapse" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <a href="{{ route('admin.kortextools.dashboard') }}" class="accordion-nav-item {{ request()->routeIs('admin.kortextools.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.kortextools.tools.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.kortextools.tools.*') ? 'active' : '' }}">
                                <i class="bi bi-wrench"></i>
                                <span>Tools</span>
                            </a>
                            <a href="{{ route('admin.kortextools.ratings.index') }}" class="accordion-nav-item {{ request()->routeIs('admin.kortextools.ratings.*') ? 'active' : '' }}">
                                <i class="bi bi-star"></i>
                                <span>Ratings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <!-- User Info Footer -->
        <div class="sidebar-footer pt-3">
            <hr>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ auth()->user()->name ?? auth()->user()->username }}</div>
                    <small class="text-muted">Administrator</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-muted" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('id.dashboard') }}">
                            <i class="bi bi-person me-2"></i>Profile
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="https://{{ config('domains.africoders.id') }}/logout?return={{ urlencode(request()->getScheme() . '://' . request()->getHost() . '/') }}">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mobile Menu Toggle -->
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success')) {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) closeBtn.click();
                }
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
