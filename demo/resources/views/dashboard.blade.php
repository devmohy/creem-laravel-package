<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CREEM Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #fb7185;
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 4rem 2rem;
        }

        .nav {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            max-width: 1200px;
        }

        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem;
            text-align: left;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .info-group {
            margin-bottom: 2rem;
        }

        .info-label {
            color: var(--text-dim);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .btn {
            background-color: transparent;
            color: var(--text);
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            display: inline-block;
        }

        .btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background-color: #f43f5e;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="logo">CREEM Demo</div>
        <a href="{{ route('pricing') }}" class="btn">Logout</a>
    </nav>

    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                <h2>Welcome back, Mohammed!</h2>
                <span class="status-badge">{{ $subscription['status'] }}</span>
            </div>

            <div class="info-group">
                <div class="info-label">Current Plan</div>
                <div class="info-value">{{ $subscription['plan'] }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Customer ID</div>
                <div class="info-value"><code>{{ $subscription['customer_id'] }}</code></div>
            </div>

            <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 3rem 0;">

            <div style="display: flex; gap: 1rem;">
                <form action="{{ route('portal') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Manage Billing</button>
                </form>
                <a href="{{ route('pricing') }}" class="btn">Change Plan</a>
            </div>
        </div>
    </div>
</body>
</html>
