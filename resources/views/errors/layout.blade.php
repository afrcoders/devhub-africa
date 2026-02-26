<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Africoders</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <style>
        :root {
            --color-primary: #1a73e8;
            --color-secondary: #5f6368;
            --color-error: #d32f2f;
            --color-warning: #f57c00;
            --color-info: #1976d2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            width: 100%;
            max-width: 600px;
            padding: 2rem;
        }

        .error-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-header {
            background: linear-gradient(135deg, var(--color-primary) 0%, #1557b0 100%);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
        }

        .error-code {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .error-icon {
            font-size: 3.5rem;
            opacity: 0.9;
        }

        .error-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .error-body {
            padding: 3rem 2rem;
            text-align: center;
        }

        .error-message {
            font-size: 1.1rem;
            color: var(--color-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .error-description {
            font-size: 0.95rem;
            color: #9e9e9e;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-error {
            padding: 0.75rem 2rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-error {
            background: var(--color-primary);
            color: white;
            border: 2px solid var(--color-primary);
        }

        .btn-primary-error:hover {
            background: #1557b0;
            border-color: #1557b0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-secondary-error {
            background: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
        }

        .btn-secondary-error:hover {
            background: var(--color-primary);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.2);
        }

        .error-footer {
            background: #f5f5f5;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e0e0e0;
            font-size: 0.85rem;
            color: #9e9e9e;
        }

        .error-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .error-logo i {
            font-size: 1.5rem;
            color: var(--color-primary);
        }

        .error-logo span {
            font-weight: 600;
            color: var(--color-primary);
            font-size: 1rem;
        }

        /* Error-specific styles */
        .error-404 .error-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        }

        .error-500 .error-header {
            background: linear-gradient(135deg, #ff6b6b 0%, #c92a2a 100%);
        }

        .error-503 .error-header {
            background: linear-gradient(135deg, #f57c00 0%, #e65100 100%);
        }

        .error-429 .error-header {
            background: linear-gradient(135deg, #fbc02d 0%, #f57f17 100%);
        }

        .error-403 .error-header {
            background: linear-gradient(135deg, #d32f2f 0%, #c62828 100%);
        }

        .error-419 .error-header {
            background: linear-gradient(135deg, #1976d2 0%, #0d47a1 100%);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .error-container {
                padding: 1rem;
            }

            .error-header {
                padding: 2rem 1.5rem;
            }

            .error-code {
                font-size: 3rem;
            }

            .error-title {
                font-size: 1.4rem;
            }

            .error-body {
                padding: 2rem 1.5rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn-error {
                width: 100%;
                justify-content: center;
            }
        }

        /* Loading animation for spinner */
        .spinner {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: currentColor;
            margin: 0 2px;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .spinner:nth-child(1) {
            animation-delay: -0.32s;
        }

        .spinner:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounce {
            0%, 80%, 100% {
                opacity: 0.3;
                transform: scale(0.8);
            }
            40% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

    @yield('extra-styles')
</head>
<body>
    <div class="error-container error-@yield('code')">
        <div class="error-card">
            <!-- Header -->
            <div class="error-header">
                <div class="error-code">
                    <span class="error-icon">@yield('icon')</span>
                    <span>@yield('code')</span>
                </div>
                <h1 class="error-title">@yield('title')</h1>
            </div>

            <!-- Body -->
            <div class="error-body">
                <div class="error-logo">
                    <i class="bi bi-shield-check"></i>
                    <span>Africoders</span>
                </div>

                <p class="error-message">@yield('message')</p>

                <p class="error-description">@yield('description')</p>

                <div class="error-actions">
                    <a href="/" class="btn-error btn-primary-error">
                        <i class="bi bi-house"></i>
                        Go Home
                    </a>
                    <a href="javascript:history.back()" class="btn-error btn-secondary-error">
                        <i class="bi bi-arrow-left"></i>
                        Go Back
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="error-footer">
                <p>
                    <i class="bi bi-info-circle"></i>
                    If you need help, contact us at
                    <a href="mailto:support@africoders.com" style="color: var(--color-primary); text-decoration: none;">support@africoders.com</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
