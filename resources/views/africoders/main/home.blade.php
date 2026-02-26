<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Africoders Portal</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .portal-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .portal-header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
            animation: fadeInDown 0.6s ease;
        }

        .portal-header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .portal-header p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        .environment-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .environment-badge.local {
            background-color: rgba(76, 175, 80, 0.6);
        }

        .environment-badge.production {
            background-color: rgba(244, 67, 54, 0.6);
        }

        .category-section {
            margin-bottom: 40px;
            animation: fadeInUp 0.8s ease;
        }

        .category-title {
            font-size: 1.8rem;
            color: white;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
        }

        .domains-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .domain-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 5px solid #667eea;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .domain-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
            border-left-color: #764ba2;
        }

        .domain-card h3 {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .domain-card p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .domain-card .domain-url {
            background-color: #f5f5f5;
            padding: 10px 12px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: #667eea;
            word-break: break-all;
            margin-bottom: 12px;
        }

        .domain-card .btn {
            align-self: flex-start;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-visit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .btn-visit:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 60px;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .portal-header h1 {
                font-size: 2rem;
            }

            .category-title {
                font-size: 1.4rem;
            }

            .domains-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="portal-container">
        <div class="portal-header">
            <div class="environment-badge {{ $environment === 'local' ? 'local' : 'production' }}">
                {{ $environment }} Environment
            </div>
            <h1>🌍 Africoders Portal</h1>
            <p>Access all services and platforms from one place</p>
        </div>

        @foreach($domains as $category => $domainList)
            <div class="category-section">
                <h2 class="category-title">{{ $category }}</h2>
                <div class="domains-grid">
                    @foreach($domainList as $domain)
                        <a href="{{ $domain['url'] }}" target="_blank" rel="noopener noreferrer" class="domain-card">
                            <h3>{{ $domain['name'] }}</h3>
                            <p>{{ $domain['description'] }}</p>
                            <div class="domain-url">{{ $domain['url'] }}</div>
                            <button class="btn btn-visit btn-sm">
                                Visit &rarr;
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="footer">
            <p>&copy; {{ date('Y') }} Africoders. All rights reserved. | Running in <strong>{{ $environment }}</strong> environment</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
