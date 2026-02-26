<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Under Construction</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2.2rem;
        }
        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .debug-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin: 1rem 0;
            text-align: left;
            font-size: 0.9rem;
        }
        .debug-info ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 0.5rem;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a67d8;
        }
        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }
        .btn-secondary:hover {
            background: #cbd5e0;
        }
        .user-info {
            background: #f7fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚧</div>
        <h1>Admin Panel Under Construction</h1>

        @if(auth()->check())
        <div class="user-info">
            <p><strong>Hello, {{ auth()->user()->full_name ?? auth()->user()->username }}!</strong></p>
            <p>You are logged in, but this admin panel is currently under construction.</p>
        </div>
        @endif

        @if(isset($debug))
        <div class="debug-info">
            <h4>Debug Information:</h4>
            <ul>
                <li><strong>Authenticated:</strong> {{ $debug['authenticated'] ? 'Yes' : 'No' }}</li>
                <li><strong>User Exists:</strong> {{ $debug['user_exists'] ? 'Yes' : 'No' }}</li>
                <li><strong>Has isAdmin Method:</strong> {{ $debug['has_isAdmin_method'] ? 'Yes' : 'No' }}</li>
                <li><strong>Is Admin:</strong> {{ $debug['isAdmin'] }}</li>
                @if($user)
                    <li><strong>User ID:</strong> {{ $user->id ?? 'N/A' }}</li>
                    <li><strong>Username:</strong> {{ $user->username ?? 'N/A' }}</li>
                    <li><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</li>
                @endif
            </ul>
        </div>
        @endif

        <p>We're working hard to bring you an amazing admin experience. The admin panel is currently being developed and will be available soon.</p>

        <p><strong>What to expect:</strong></p>
        <ul style="text-align: left; display: inline-block;">
            <li>User management tools</li>
            <li>Analytics and reports</li>
            <li>System configuration</li>
            <li>Content management</li>
        </ul>

        <div style="margin-top: 2rem;">
            <a href="https://{{ config('domains.africoders.id') }}/dashboard" class="btn">Go to ID Dashboard</a>
            <a href="https://{{ config('domains.africoders.main') }}" class="btn btn-secondary">Back to Main Site</a>
        </div>

        <p style="margin-top: 2rem; font-size: 0.9rem; color: #999;">
            Check back later for updates!
        </p>
    </div>
</body>
</html>
