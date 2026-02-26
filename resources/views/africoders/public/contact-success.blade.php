<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent - Africoders</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/android-chrome-512x512.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <style>
        :root {
            --color-primary: #1a73e8;
            --color-secondary: #5f6368;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .navbar {
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--color-primary) !important;
        }

        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .success-card {
            background: white;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }

        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .success-card h2 {
            color: #333;
            margin-bottom: 1rem;
        }

        .success-card p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-home {
            background-color: var(--color-primary);
            color: white;
            padding: 0.75rem 2rem;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-home:hover {
            background-color: #1557b0;
            color: white;
            text-decoration: none;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }

        .footer a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--color-primary);
        }
    </style>
</head>
<body class="d-flex flex-column">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('africoders.home') }}">
                <i class="bi bi-rocket-takeoff"></i> Africoders
            </a>
        </div>
    </nav>

    <!-- Success Message -->
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <h2>Message Sent Successfully!</h2>
            <p>
                Thank you for reaching out to Africoders. We've received your inquiry and will review it shortly.
                Our team will get back to you within 2-3 business days.
            </p>
            <a href="{{ route('africoders.home') }}" class="btn-home">
                <i class="bi bi-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container text-center">
            <p>&copy; {{ now()->year }} Africoders. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
