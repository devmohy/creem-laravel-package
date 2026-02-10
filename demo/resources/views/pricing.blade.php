<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - CREEM Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #fb7185;
            --primary-hover: #f43f5e;
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
            max-width: 1000px;
            width: 100%;
            padding: 4rem 2rem;
            text-align: center;
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #fb7185, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            color: var(--text-dim);
            font-size: 1.25rem;
            margin-bottom: 4rem;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .price-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem 2rem;
            transition: transform 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .price-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
        }

        .price-card.featured {
            border-color: var(--primary);
            box-shadow: 0 0 40px rgba(251, 113, 133, 0.2);
        }

        .price-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .price-desc {
            color: var(--text-dim);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .price-amount {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .price-interval {
            color: var(--text-dim);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .features {
            list-style: none;
            padding: 0;
            margin: 0 0 3rem 0;
            text-align: left;
            flex-grow: 1;
        }

        .features li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            color: #cbd5e1;
        }

        .features li::before {
            content: "✓";
            color: var(--primary);
            margin-right: 0.75rem;
            font-weight: bold;
        }

        .btn {
            background-color: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        .btn:hover {
            background-color: var(--primary-hover);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #fca5a5;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CREEM Laravel Demo</h1>
        <p class="subtitle">Experience the smoothest payment integration for Laravel builders.</p>

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="pricing-grid">
            @foreach($plans as $plan)
                <div class="price-card {{ $loop->index === 1 ? 'featured' : '' }}">
                    <div class="price-name">{{ $plan['name'] }}</div>
                    <div class="price-desc">{{ $plan['description'] }}</div>
                    <div class="price-amount">{{ $plan['price'] }}</div>
                    <div class="price-interval">per {{ $plan['interval'] }}</div>
                    
                    <ul class="features">
                        @foreach($plan['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $plan['id'] }}">
                        <button type="submit" class="btn">Choose Plan</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
