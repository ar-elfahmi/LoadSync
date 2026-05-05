<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LoadSync</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            color-scheme: dark;
            --bg: #0f172a;
            --panel: #1e293b;
            --panel-2: #111827;
            --line: rgba(51, 65, 85, 0.9);
            --line-soft: rgba(51, 65, 85, 0.55);
            --text: #e2e8f0;
            --muted: #94a3b8;
            --blue: #3b82f6;
            --blue-soft: rgba(59, 130, 246, 0.14);
            --green: #22c55e;
        }

        html, body { min-height: 100%; }

        body {
            margin: 0;
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.18), transparent 36%),
                radial-gradient(circle at top right, rgba(34, 197, 94, 0.12), transparent 32%),
                var(--bg);
            color: var(--text);
        }

        a { color: inherit; text-decoration: none; }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px 44px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .brand-mark {
            width: 72px;
            height: 72px;
            object-fit: contain;
            padding: 10px;
            border-radius: 18px;
            background: #1e293b;
            border: 1px solid var(--line-soft);
            flex: 0 0 auto;
        }

        .kicker {
            margin: 0 0 6px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(2rem, 5vw, 3.5rem);
            line-height: 1;
            color: #f8fafc;
        }

        .lede {
            margin: 10px 0 0;
            max-width: 760px;
            color: #cbd5e1;
            font-size: 16px;
            line-height: 1.65;
        }

        .status {
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid rgba(34, 197, 94, 0.22);
            background: rgba(34, 197, 94, 0.1);
            color: #86efac;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 250px;
            padding: 24px;
            border-radius: 20px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.98), rgba(15, 23, 42, 0.98));
            box-shadow: 0 22px 60px rgba(2, 6, 23, 0.35);
            transition: transform 160ms ease, border-color 160ms ease, box-shadow 160ms ease;
        }

        .card:hover {
            transform: translateY(-4px);
            border-color: rgba(59, 130, 246, 0.55);
            box-shadow: 0 26px 70px rgba(2, 6, 23, 0.48);
        }

        .card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .card-badge {
            margin: 0 0 12px;
            color: #93c5fd;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .card-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(59, 130, 246, 0.25);
            background: var(--blue-soft);
            color: #dbeafe;
            font-size: 24px;
            flex: 0 0 auto;
        }

        .card h2 {
            margin: 0 0 8px;
            color: #f8fafc;
            font-size: 24px;
            line-height: 1.15;
        }

        .card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: auto;
            padding-top: 18px;
        }

        .pill {
            padding: 7px 10px;
            border-radius: 999px;
            border: 1px solid var(--line-soft);
            background: rgba(15, 23, 42, 0.8);
            color: #cbd5e1;
            font-size: 12px;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: #bfdbfe;
            font-size: 14px;
            font-weight: 700;
        }

        .card-link span { color: #60a5fa; }

        .footer {
            margin-top: 22px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .topbar { flex-direction: column; align-items: flex-start; }
            .cards { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div class="brand">
                <img src="{{ asset('image/brand%20logo.svg') }}" alt="LoadSync logo" class="brand-mark">
                <div>
                    <p class="kicker">Industrial energy control</p>
                    <h1>LoadSync</h1>
                    <p class="lede">Pilih layar kerja untuk memantau sistem, mengelola mesin, atau menjalankan simulasi energi dalam tampilan yang konsisten.</p>
                </div>
            </div>
            <div class="status">System online</div>
        </header>

        <section class="cards" aria-label="LoadSync navigation cards">
            <a class="card" href="{{ url('/dashboard') }}">
                <div class="card-top">
                    <div>
                        <p class="card-badge">Monitor</p>
                        <h2>Dashboard</h2>
                    </div>
                    <div class="card-icon">1</div>
                </div>
                <p>Ringkasan PLTS, battery, PLN, dan rekomendasi sistem dalam satu layar utama.</p>
                <div class="pill-row">
                    <span class="pill">PLTS</span>
                    <span class="pill">Battery</span>
                    <span class="pill">PLN</span>
                </div>
                <div class="card-link">Open screen <span>></span></div>
            </a>

            <a class="card" href="{{ url('/energy_simulation') }}">
                <div class="card-top">
                    <div>
                        <p class="card-badge">Forecast</p>
                        <h2>Energy Simulation</h2>
                    </div>
                    <div class="card-icon">2</div>
                </div>
                <p>Uji pengaruh cuaca dan level baterai untuk melihat dampaknya ke suplai energi.</p>
                <div class="pill-row">
                    <span class="pill">Weather</span>
                    <span class="pill">Battery</span>
                    <span class="pill">What-if</span>
                </div>
                <div class="card-link">Open screen <span>></span></div>
            </a>

            <a class="card" href="{{ url('/machines') }}">
                <div class="card-top">
                    <div>
                        <p class="card-badge">Control</p>
                        <h2>Machine Management</h2>
                    </div>
                    <div class="card-icon">3</div>
                </div>
                <p>Kelola prioritas, status, dan kontrol mesin dengan UI list-based yang cepat.</p>
                <div class="pill-row">
                    <span class="pill">Priority</span>
                    <span class="pill">Status</span>
                    <span class="pill">Auto-approve</span>
                </div>
                <div class="card-link">Open screen <span>></span></div>
            </a>
        </section>

        <div class="footer">LoadSync - monitoring, control, and simulation for industrial energy flow.</div>
    </main>
</body>
</html>
