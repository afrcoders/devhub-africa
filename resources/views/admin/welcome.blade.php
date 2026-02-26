<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Africoders Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .welcome-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1.5rem;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: #718096;
            margin-bottom: 2rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 0.875rem 2.5rem;
            border-radius: 50px;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-login i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <div class="welcome-icon">
            <i class="bi bi-shield-lock"></i>
        </div>

        <h1 class="welcome-title">Welcome to Admin Portal</h1>

        <p class="welcome-subtitle">
            This area is reserved for administrators. Please log in with your Africoders ID to continue.
        </p>

        <a href="{{ $loginUrl }}" class="btn-login">
            <i class="bi bi-box-arrow-in-right"></i>
            Login To Continue
        </a>
    </div>
</body>
</html>
