<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Africoders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        :root {
            --color-primary: #1a73e8;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--color-primary) !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('africoders.home') }}">Africoders</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('africoders.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('africoders.account') }}">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://{{ config('domains.africoders.id') }}/logout?return={{ urlencode(request()->fullUrl()) }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="mb-4">Account Settings</h1>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Name:</div>
                            <div class="col-sm-9">{{ $user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Email:</div>
                            <div class="col-sm-9">{{ $user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Username:</div>
                            <div class="col-sm-9">{{ $user->username ?? 'Not set' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Member since:</div>
                            <div class="col-sm-9">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                        <hr>
                        <a href="https://{{ config('domains.africoders.id') }}/profile/edit" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Profile on ID Service
                        </a>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Security</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            For security settings including password changes, two-factor authentication, and session management,
                            please visit your ID Service dashboard.
                        </p>
                        <a href="https://{{ config('domains.africoders.id') }}/dashboard" class="btn btn-outline-primary">
                            <i class="bi bi-shield-check me-2"></i>Go to ID Service
                        </a>
                    </div>
                </div>

                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Account Actions</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Log out from all Africoders services or manage your account preferences.
                        </p>
                        <a href="https://{{ config('domains.africoders.id') }}/logout?return={{ urlencode(request()->fullUrl()) }}" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
