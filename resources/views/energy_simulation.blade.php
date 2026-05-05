<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoadSync — Energy Simulation</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0F172A;
            color: #E2E8F0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 80px;
            background: #1E293B;
            border-bottom: 1px solid rgba(51,65,85,0.5);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 27px 0 15px;
            z-index: 100;
        }

        .brand-logo { height: 48px; width: auto; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .weather-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 41px;
            padding: 0 15px;
            border-radius: 8px;
            border: 1px solid rgba(51,65,85,0.5);
            background: rgba(15,23,42,0.5);
            margin-right: 16px;
        }

        .weather-stat {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #CBD5E1;
            font-size: 16px;
            font-weight: 500;
        }

        .weather-divider { width: 1px; height: 32px; background: #334155; margin: 0 4px; }

        .clock-block {
            border-left: 1px solid rgba(51,65,85,0.5);
            padding: 6px 26px;
            text-align: center;
        }

        .clock-time { font-size: 18px; font-weight: 600; color: #E2E8F0; line-height: 20px; }
        .clock-date { font-size: 15px; font-weight: 400; color: #94A3B8; line-height: 16px; }

        .bell-btn {
            position: relative;
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            cursor: pointer; margin-left: 12px;
            background: none; border: none;
        }

        .bell-dot {
            position: absolute; top: 0; right: 0;
            width: 12px; height: 12px;
            border-radius: 50%;
            background: #F59E0B;
            border: 1px solid #1E293B;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 80px; left: 0;
            width: 80px;
            height: calc(100vh - 80px);
            background: #1E293B;
            border-right: 1px solid #334155;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 0;
            gap: 16px;
            z-index: 99;
        }

        .nav-icon-btn {
            width: 48px; height: 48px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }

        .nav-icon-btn:hover { background: rgba(59,130,246,0.1); }
        .nav-icon-btn.is-active { background: #3B82F6; }

        /* ── LAYOUT ── */
        .page-wrapper {
            margin-left: 80px;
            margin-top: 80px;
            padding: 40px;
            min-height: calc(100vh - 80px);
        }

        .page-outer-frame {
            border: 2px solid #6B7280;
            border-radius: 10px;
            padding: 40px;
        }

        /* ── PAGE HEADER ── */
        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .page-title { font-size: 30px; font-weight: 700; color: #FFF; line-height: 36px; }
        .page-subtitle { font-size: 16px; font-weight: 400; color: #94A3B8; line-height: 24px; margin-top: 8px; }

        .header-actions { display: flex; align-items: center; gap: 16px; }

        .btn-reset {
            display: flex; align-items: center; gap: 8px;
            height: 42px; padding: 0 20px;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #1E293B;
            color: #CBD5E1;
            font-size: 16px; font-weight: 500;
            cursor: pointer; transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-reset:hover { background: #334155; }

        .btn-run {
            display: flex; align-items: center; gap: 8px;
            height: 42px; padding: 0 24px;
            border-radius: 8px;
            background: #3B82F6;
            border: none;
            color: #FFF;
            font-size: 16px; font-weight: 500;
            cursor: pointer; transition: background 0.2s, transform 0.1s;
            font-family: 'Inter', sans-serif;
        }

        .btn-run:hover { background: #2563EB; }
        .btn-run:active { transform: scale(0.98); }
        .btn-run.is-running { background: #22C55E; }

        /* ── TWO-COLUMN LAYOUT ── */
        .sim-layout {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 32px;
            align-items: start;
        }

        /* ── INPUT PANEL ── */
        .sim-card {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 6px -4px rgba(0,0,0,.1), 0 10px 15px -3px rgba(0,0,0,.1);
        }

        .sim-card + .sim-card { margin-top: 24px; }

        .sim-card-title {
            font-size: 18px; font-weight: 600; color: #FFF;
            margin-bottom: 24px;
        }

        /* Form Controls */
        .field-group { margin-bottom: 24px; }
        .field-group:last-child { margin-bottom: 0; }

        .field-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .field-label {
            font-size: 14px; font-weight: 500; color: #CBD5E1;
        }

        .field-value {
            font-family: 'Roboto Mono', monospace;
            font-size: 14px; font-weight: 400; color: #3B82F6;
        }

        /* Range Slider */
        .range-slider {
            width: 100%;
            height: 6px;
            -webkit-appearance: none;
            appearance: none;
            background: #334155;
            border-radius: 9999px;
            outline: none;
            cursor: pointer;
        }

        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px; height: 18px;
            border-radius: 50%;
            background: #3B82F6;
            border: 2px solid #1E293B;
            cursor: pointer;
            box-shadow: 0 0 0 2px rgba(59,130,246,0.3);
            transition: box-shadow 0.2s;
        }

        .range-slider::-webkit-slider-thumb:hover {
            box-shadow: 0 0 0 4px rgba(59,130,246,0.25);
        }

        .range-slider::-moz-range-thumb {
            width: 18px; height: 18px;
            border-radius: 50%;
            background: #3B82F6;
            border: 2px solid #1E293B;
            cursor: pointer;
        }

        .slider-track-wrap {
            position: relative;
        }

        /* Select */
        .field-select {
            width: 100%;
            height: 40px;
            padding: 0 16px;
            background: #0F172A;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #E2E8F0;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%2394A3B8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            transition: border-color 0.2s;
        }

        .field-select:focus { border-color: #3B82F6; }
        .field-select option { background: #1E293B; }

        /* ── RESULTS PANEL ── */
        .results-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Ready state */
        .ready-placeholder {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 40px;
            text-align: center;
            min-height: 520px;
        }

        .ready-icon {
            width: 64px; height: 64px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            background: rgba(51,65,85,0.5);
            margin-bottom: 20px;
        }

        .ready-title { font-size: 20px; font-weight: 600; color: #FFF; margin-bottom: 12px; }
        .ready-body { font-size: 16px; font-weight: 400; color: #94A3B8; line-height: 24px; max-width: 400px; }

        /* ── SYSTEM STATUS BADGE ── */
        .system-status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid;
        }

        .system-status-bar.is-stable  { border-color: rgba(34,197,94,0.4); background: rgba(34,197,94,0.08); }
        .system-status-bar.is-warning { border-color: rgba(245,158,11,0.4); background: rgba(245,158,11,0.08); }
        .system-status-bar.is-critical { border-color: rgba(239,68,68,0.4); background: rgba(239,68,68,0.08); }

        .status-badge-text {
            display: flex; align-items: center; gap: 10px;
            font-size: 16px; font-weight: 600;
        }

        .status-badge-text.is-stable  { color: #22C55E; }
        .status-badge-text.is-warning { color: #F59E0B; }
        .status-badge-text.is-critical { color: #EF4444; }

        .status-badge-meta { font-size: 13px; color: #94A3B8; }

        /* ── ENERGY SUPPLY COMPARISON ── */
        .supply-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .supply-half-title {
            font-size: 12px; font-weight: 600;
            letter-spacing: 0.5px; text-transform: uppercase;
            margin-bottom: 12px;
        }

        .supply-half-title.is-before { color: #94A3B8; }
        .supply-half-title.is-after  { color: #3B82F6; }

        .supply-metric {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(51,65,85,0.5);
        }

        .supply-metric:last-child { border-bottom: none; }

        .supply-metric-label { font-size: 13px; color: #94A3B8; }
        .supply-metric-value { font-family: 'Roboto Mono', monospace; font-size: 13px; font-weight: 600; color: #E2E8F0; }
        .supply-metric-value.is-up   { color: #22C55E; }
        .supply-metric-value.is-down { color: #EF4444; }

        .supply-bar-row { margin-top: 12px; }
        .supply-bar-label-row { display: flex; justify-content: space-between; font-size: 11px; color: #94A3B8; margin-bottom: 4px; }

        .supply-stacked-bar { display: flex; height: 20px; border-radius: 4px; overflow: hidden; }
        .supply-bar-seg { display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 700; color: #FFF; transition: width 0.6s ease; overflow: hidden; white-space: nowrap; }
        .supply-bar-seg.plts    { background: #22C55E; }
        .supply-bar-seg.battery { background: #3B82F6; }
        .supply-bar-seg.pln     { background: #8B5CF6; }

        /* ── MACHINE IMPACT TABLE ── */
        .impact-table {
            width: 100%;
            border-collapse: collapse;
        }

        .impact-table thead tr { border-bottom: 1px solid #334155; }

        .impact-table th {
            padding: 10px 14px;
            font-size: 12px; font-weight: 500; color: #94A3B8;
            text-align: left; white-space: nowrap;
        }

        .impact-table tbody tr {
            border-top: 1px solid rgba(51,65,85,0.5);
            transition: background 0.15s;
        }

        .impact-table tbody tr:hover { background: rgba(51,65,85,0.3); }

        .impact-table td {
            padding: 0 14px;
            height: 52px;
            vertical-align: middle;
        }

        .impact-machine-name { font-size: 14px; font-weight: 500; color: #E2E8F0; }

        .eff-bar-wrap { width: 80px; }
        .eff-bar-track { height: 6px; border-radius: 9999px; background: rgba(51,65,85,0.8); overflow: hidden; }
        .eff-bar-fill  { height: 100%; border-radius: 9999px; transition: width 0.6s ease; }
        .eff-bar-fill.is-high   { background: #22C55E; }
        .eff-bar-fill.is-medium { background: #F59E0B; }
        .eff-bar-fill.is-low    { background: #EF4444; }

        .eff-delta { font-size: 12px; font-weight: 500; }
        .eff-delta.is-pos { color: #22C55E; }
        .eff-delta.is-neg { color: #EF4444; }
        .eff-delta.is-zero { color: #94A3B8; }

        .impact-status-chip {
            display: inline-flex; align-items: center; justify-content: center;
            height: 22px; padding: 0 10px;
            border-radius: 4px;
            font-size: 11px; font-weight: 600;
            white-space: nowrap;
        }

        .chip-on      { border: 1px solid #22C55E; background: rgba(34,197,94,0.15); color: #22C55E; }
        .chip-reduced { border: 1px solid #F59E0B; background: rgba(245,158,11,0.15); color: #F59E0B; }
        .chip-off     { border: 1px solid #EF4444; background: rgba(239,68,68,0.15); color: #EF4444; }

        .priority-badge {
            display: inline-flex; align-items: center; justify-content: center;
            height: 22px; padding: 0 8px;
            border-radius: 4px;
            font-size: 11px; font-weight: 500;
        }

        .badge-high { border: 1px solid #EF4444; background: rgba(239,68,68,0.2); color: #EF4444; }
        .badge-med  { border: 1px solid #F59E0B; background: rgba(245,158,11,0.2); color: #F59E0B; }
        .badge-low  { border: 1px solid #3B82F6; background: rgba(59,130,246,0.2); color: #3B82F6; }

        /* ── DSS CARDS ── */
        .dss-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .dss-rec-card {
            padding: 14px;
            border-radius: 10px;
            display: flex; flex-direction: column; gap: 6px;
        }

        .dss-rec-card.is-high   { border: 1px solid rgba(239,68,68,0.4); background: rgba(239,68,68,0.06); }
        .dss-rec-card.is-medium { border: 1px solid rgba(245,158,11,0.4); background: rgba(245,158,11,0.06); }
        .dss-rec-card.is-low    { border: 1px solid rgba(59,130,246,0.4); background: rgba(59,130,246,0.06); }

        .dss-priority-row { display: flex; align-items: center; gap: 6px; }

        .dss-priority-label {
            font-size: 10px; font-weight: 700;
            letter-spacing: 0.25px; text-transform: uppercase;
        }

        .dss-priority-label.is-high   { color: #EF4444; }
        .dss-priority-label.is-medium { color: #F59E0B; }
        .dss-priority-label.is-low    { color: #3B82F6; }

        .dss-rec-title { font-size: 13px; font-weight: 600; color: #FFF; }
        .dss-rec-body  { font-size: 12px; color: #9CA3AF; line-height: 1.5; }
        .dss-rec-action {
            margin-top: 4px;
            font-size: 11px; font-weight: 600;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 4px;
        }

        .dss-rec-action.is-high   { color: #EF4444; }
        .dss-rec-action.is-medium { color: #F59E0B; }
        .dss-rec-action.is-low    { color: #3B82F6; }

        /* ── FLOW INDICATOR ── */
        .flow-steps {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 20px;
        }

        .flow-step {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px; font-weight: 600;
            background: #1E293B;
            border: 1px solid #334155;
            color: #94A3B8;
        }

        .flow-step.is-done  { border-color: #3B82F6; color: #3B82F6; background: rgba(59,130,246,0.1); }

        .flow-arrow {
            width: 20px; height: 2px;
            background: #334155;
            flex-shrink: 0;
        }

        .flow-arrow.is-done { background: #3B82F6; }

        /* ── DASHBOARD LINK BANNER ── */
        .dashboard-link-banner {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 20px;
            border-radius: 10px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.35);
        }

        .banner-left { display: flex; align-items: center; gap: 10px; }
        .banner-text { font-size: 14px; color: #94A3B8; }
        .banner-text strong { color: #22C55E; font-weight: 600; }

        .banner-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 16px;
            border-radius: 6px;
            background: #22C55E;
            border: none;
            color: #FFF;
            font-size: 13px; font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            transition: background 0.2s;
        }

        .banner-btn:hover { background: #16A34A; }
    </style>
</head>
<body x-data="simulationApp()" x-init="init()">

    <!-- ── NAVBAR ── -->
    <nav class="navbar">
        <img class="brand-logo"
             src="https://api.builder.io/api/v1/image/assets/TEMP/65cf4edde248f5ead840168b1dbb51718479d60b?width=192"
             alt="LoadSync">
        <div class="navbar-right">
            <div class="weather-pill">
                <div class="weather-stat">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <circle cx="8" cy="8" r="2.67" stroke="#FBBF24" stroke-width="2"/>
                        <path d="M8 1.33V2.66M8 13.33v1.33M3.29 3.29l.94.94M11.77 11.77l.94.94M1.33 8h1.33M13.33 8h1.33M4.23 11.77l-.94.94M12.71 3.29l-.94.94" stroke="#FBBF24" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span x-text="params.temperature + '°C'">28°C</span>
                </div>
                <div class="weather-divider"></div>
                <div class="weather-stat">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2.28 9.93A4 4 0 0 1 6.11 2c2.02.14 3.74 1.46 4.32 3.33h1.25A2.67 2.67 0 0 1 13.41 10.83" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                        <path d="M10.67 9.33v4M5.34 9.33v4M8 10.67v4" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span x-text="cloudCover + '% Cloud'">12% Cloud</span>
                </div>
            </div>
            <div class="clock-block">
                <div class="clock-time" x-text="currentTime">--:--:--</div>
                <div class="clock-date" x-text="currentDate">---</div>
            </div>
            <button class="bell-btn" aria-label="Notifications">
                <svg width="24" height="24" viewBox="0 0 29 29" fill="none">
                    <path d="M12.41 25.38a4 4 0 0 0 4.19 0" stroke="#94A3B8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.84 18.51c-.33.35-.41.86-.21 1.3.19.44.63.72 1.11.72h19.52c.48 0 .92-.28 1.12-.72.19-.44.11-.95-.19-1.3C23.54 16.85 21.82 15.09 21.82 9.66c0-4-3.28-7.25-7.32-7.25-4.04 0-7.32 3.25-7.32 7.25 0 5.43-1.72 7.19-3.34 8.85Z" stroke="#94A3B8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="bell-dot"></div>
            </button>
        </div>
    </nav>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <a class="nav-icon-btn" href="/dashboard" title="Dashboard">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3.91 14.02a2 2 0 0 1-.93-1.57C2.82 12.1 13.13 2.11 13.13 2.11a.5.5 0 0 1 .75.46l-1.94 6.06c-.11.31-.07.66.12.93.19.27.51.43.84.43H20.08a1 1 0 0 1 .92 1.39L10.86 21.9a.5.5 0 0 1-.83-.46l1.94-6.06c.12-.31.07-.66-.12-.93a1.07 1.07 0 0 0-.84-.43H3.91Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="/machines" title="Machine Management">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="14" y="3" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="14" y="14" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="3" y="14" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn is-active" href="/simulation" title="Energy Simulation">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14.06 2v6c0 .34.09.66.25.96L20 19.04A2 2 0 0 1 18.19 22H5.81A2 2 0 0 1 4 19.04L9.68 8.96A2 2 0 0 0 9.94 8V2" stroke="#E5E7EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.45 15h11.09M8.5 2h7" stroke="#E5E7EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="#" title="Settings">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.23 2h-.46a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.44.25a2 2 0 0 1-2 0l-.16-.08a2 2 0 0 0-2.73.73l-.23.38a2 2 0 0 0 .73 2.73l.15.09a2 2 0 0 1 1 1.73v.5a2 2 0 0 1-1 1.73l-.15.09a2 2 0 0 0-.73 2.73l.23.38a2 2 0 0 0 2.73.73l.16-.08a2 2 0 0 1 2 0l.44.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.46a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.44-.25a2 2 0 0 1 2 0l.16.08a2 2 0 0 0 2.73-.73l.23-.38a2 2 0 0 0-.73-2.73l-.15-.09A2 2 0 0 1 19.08 12.25v-.5a2 2 0 0 1 1-1.73l.15-.09a2 2 0 0 0 .73-2.73l-.23-.38a2 2 0 0 0-2.73-.73l-.16.08a2 2 0 0 1-2 0l-.44-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </aside>

    <!-- ── MAIN ── -->
    <main class="page-wrapper">
        <div class="page-outer-frame">

            <!-- Page Header -->
            <div class="page-head">
                <div>
                    <h1 class="page-title">Energy Simulation</h1>
                    <p class="page-subtitle">Simulate weather and battery impact on machine performance</p>
                </div>
                <div class="header-actions">
                    <button class="btn-reset" @click="resetSimulation()">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 8C2 11.31 4.69 14 8 14s6-2.69 6-6-2.69-6-6-6c-1.68.01-3.28.66-4.49 1.83L2 5.33" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 2v3.33h3.33" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Reset
                    </button>
                    <button class="btn-run" :class="hasRun ? 'is-running' : ''" @click="runSimulation()">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 2l9.33 6L4 14V2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span x-text="hasRun ? 'Re-Run Simulation' : 'Run Simulation'"></span>
                    </button>
                </div>
            </div>

            <!-- Flow Steps -->
            <div class="flow-steps" x-show="hasRun">
                <div class="flow-step is-done">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="6" fill="#3B82F6"/><path d="M3.5 6L5.5 8L8.5 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Input
                </div>
                <div class="flow-arrow is-done"></div>
                <div class="flow-step is-done">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="6" fill="#3B82F6"/><path d="M3.5 6L5.5 8L8.5 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Simulation
                </div>
                <div class="flow-arrow is-done"></div>
                <div class="flow-step is-done">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="6" fill="#3B82F6"/><path d="M3.5 6L5.5 8L8.5 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Impact Analysis
                </div>
                <div class="flow-arrow is-done"></div>
                <div class="flow-step is-done">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="6" fill="#3B82F6"/><path d="M3.5 6L5.5 8L8.5 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Decision
                </div>
            </div>

            <!-- Two-column layout -->
            <div class="sim-layout">

                <!-- ── LEFT: Input Panels ── -->
                <div>
                    <!-- Weather Simulation -->
                    <div class="sim-card">
                        <div class="sim-card-title">Weather Simulation</div>

                        <!-- Sunlight Intensity -->
                        <div class="field-group">
                            <div class="field-label-row">
                                <span class="field-label">Sunlight Intensity</span>
                                <span class="field-value" x-text="params.sunlight + '%'">80%</span>
                            </div>
                            <input class="range-slider" type="range" min="0" max="100" step="1"
                                   x-model="params.sunlight">
                        </div>

                        <!-- Weather Condition -->
                        <div class="field-group">
                            <div class="field-label-row">
                                <span class="field-label">Weather Condition</span>
                            </div>
                            <select class="field-select" x-model="params.condition">
                                <option value="sunny">☀️ Sunny</option>
                                <option value="partly_cloudy">⛅ Partly Cloudy</option>
                                <option value="cloudy">☁️ Cloudy</option>
                                <option value="rainy">🌧️ Rainy</option>
                                <option value="stormy">⛈️ Stormy</option>
                            </select>
                        </div>

                        <!-- Temperature -->
                        <div class="field-group">
                            <div class="field-label-row">
                                <span class="field-label">Temperature</span>
                                <span class="field-value" x-text="params.temperature + '°C'">28°C</span>
                            </div>
                            <input class="range-slider" type="range" min="-10" max="50" step="1"
                                   x-model="params.temperature">
                        </div>
                    </div>

                    <!-- Battery Simulation -->
                    <div class="sim-card">
                        <div class="sim-card-title">Battery Simulation</div>

                        <!-- Battery Level -->
                        <div class="field-group">
                            <div class="field-label-row">
                                <span class="field-label">Battery Level</span>
                                <span class="field-value" x-text="params.batteryLevel + '%'">75%</span>
                            </div>
                            <input class="range-slider" type="range" min="0" max="100" step="1"
                                   x-model="params.batteryLevel">
                        </div>

                        <!-- Battery Mode -->
                        <div class="field-group">
                            <div class="field-label-row">
                                <span class="field-label">Battery Mode</span>
                            </div>
                            <select class="field-select" x-model="params.batteryMode">
                                <option value="normal">Normal — Balanced charging/discharging</option>
                                <option value="saving">Power Saving — Preserve charge</option>
                                <option value="emergency">Emergency — Prioritize supply</option>
                            </select>
                        </div>

                        <!-- Quick presets -->
                        <div style="margin-top:16px;padding-top:16px;border-top:1px solid #334155;">
                            <div class="field-label" style="margin-bottom:10px;">Quick Scenarios</div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <button style="padding:6px 12px;border-radius:6px;border:1px solid #334155;background:#0F172A;color:#94A3B8;font-size:12px;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.2s;"
                                        @click="loadPreset('peak')"
                                        @mouseover="$event.target.style.borderColor='#F59E0B';$event.target.style.color='#F59E0B'"
                                        @mouseout="$event.target.style.borderColor='#334155';$event.target.style.color='#94A3B8'">
                                    ☀️ Peak Solar
                                </button>
                                <button style="padding:6px 12px;border-radius:6px;border:1px solid #334155;background:#0F172A;color:#94A3B8;font-size:12px;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.2s;"
                                        @click="loadPreset('storm')"
                                        @mouseover="$event.target.style.borderColor='#EF4444';$event.target.style.color='#EF4444'"
                                        @mouseout="$event.target.style.borderColor='#334155';$event.target.style.color='#94A3B8'">
                                    ⛈️ Storm Scenario
                                </button>
                                <button style="padding:6px 12px;border-radius:6px;border:1px solid #334155;background:#0F172A;color:#94A3B8;font-size:12px;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.2s;"
                                        @click="loadPreset('low_battery')"
                                        @mouseover="$event.target.style.borderColor='#3B82F6';$event.target.style.color='#3B82F6'"
                                        @mouseout="$event.target.style.borderColor='#334155';$event.target.style.color='#94A3B8'">
                                    🔋 Low Battery
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── RIGHT: Results Panel ── -->
                <div class="results-panel">

                    <!-- Ready to simulate placeholder -->
                    <div class="ready-placeholder" x-show="!hasRun">
                        <div class="ready-icon">
                            <svg width="32" height="32" viewBox="0 0 52 52" fill="none">
                                <path d="M12 6L40 26L12 46V6Z" stroke="#334155" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="ready-title">Ready to Simulate</div>
                        <p class="ready-body">Adjust the parameters on the left and click "Run Simulation" to see how changes affect energy supply and machine performance.</p>
                    </div>

                    <!-- Simulation Results -->
                    <template x-if="hasRun">
                        <div style="display:flex;flex-direction:column;gap:20px;">

                            <!-- Dashboard updated banner -->
                            <div class="dashboard-link-banner">
                                <div class="banner-left">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <circle cx="8" cy="8" r="7" stroke="#22C55E" stroke-width="2"/>
                                        <path d="M5 8L7 10L11 6" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="banner-text">
                                        <strong>Simulation applied to dashboard.</strong> Real-time view updated with projected values.
                                    </span>
                                </div>
                                <a class="banner-btn" href="/dashboard">
                                    View Dashboard
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                        <path d="M2 6h8M6 2l4 4-4 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- System Status -->
                            <div class="sim-card" style="padding:16px 20px;">
                                <div class="system-status-bar"
                                     :class="results.status === 'Stable' ? 'is-stable' : results.status === 'Warning' ? 'is-warning' : 'is-critical'">
                                    <div class="status-badge-text"
                                         :class="results.status === 'Stable' ? 'is-stable' : results.status === 'Warning' ? 'is-warning' : 'is-critical'">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <template x-if="results.status === 'Stable'">
                                                <path d="M9 1a8 8 0 1 0 0 16A8 8 0 0 0 9 1ZM6 9l2 2 4-4" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </template>
                                            <template x-if="results.status === 'Warning'">
                                                <path d="M9 2L16.5 15H1.5L9 2ZM9 7v3M9 12h.01" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </template>
                                            <template x-if="results.status === 'Critical'">
                                                <path d="M9 2L16.5 15H1.5L9 2ZM9 7v3M9 12h.01" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </template>
                                        </svg>
                                        System Status: <span x-text="results.status"></span>
                                    </div>
                                    <div class="status-badge-meta">
                                        Supply/Demand ratio: <strong x-text="results.ratio + '%'" style="color:#E2E8F0;font-weight:600;"></strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Energy Supply Change -->
                            <div class="sim-card">
                                <div class="sim-card-title" style="margin-bottom:16px;">Energy Supply Change</div>
                                <div class="supply-grid">
                                    <!-- Before -->
                                    <div>
                                        <div class="supply-half-title is-before">Before (Baseline)</div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">PLTS Output</span>
                                            <span class="supply-metric-value" x-text="baseline.plts.toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">Battery Supply</span>
                                            <span class="supply-metric-value" x-text="baseline.battery.toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">PLN Dependency</span>
                                            <span class="supply-metric-value" x-text="baseline.pln.toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">Total Supply</span>
                                            <span class="supply-metric-value" style="color:#FFF;font-weight:700;" x-text="(baseline.plts+baseline.battery+baseline.pln).toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-bar-row">
                                            <div class="supply-bar-label-row">
                                                <span>Supply mix</span>
                                            </div>
                                            <div class="supply-stacked-bar">
                                                <div class="supply-bar-seg plts" :style="'width:' + barPct(baseline.plts, baseline.plts+baseline.battery+baseline.pln) + '%'">PLTS</div>
                                                <div class="supply-bar-seg battery" :style="'width:' + barPct(baseline.battery, baseline.plts+baseline.battery+baseline.pln) + '%'">Bat</div>
                                                <div class="supply-bar-seg pln" :style="'width:' + barPct(baseline.pln, baseline.plts+baseline.battery+baseline.pln) + '%'">PLN</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- After -->
                                    <div>
                                        <div class="supply-half-title is-after">After (Simulated)</div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">PLTS Output</span>
                                            <span class="supply-metric-value"
                                                  :class="results.plts > baseline.plts ? 'is-up' : results.plts < baseline.plts ? 'is-down' : ''"
                                                  x-text="results.plts.toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">Battery Supply</span>
                                            <span class="supply-metric-value"
                                                  :class="results.battery > baseline.battery ? 'is-up' : results.battery < baseline.battery ? 'is-down' : ''"
                                                  x-text="results.battery.toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">PLN Dependency</span>
                                            <span class="supply-metric-value"
                                                  :class="results.pln < baseline.pln ? 'is-up' : results.pln > baseline.pln ? 'is-down' : ''"
                                                  x-text="results.pln.toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-metric">
                                            <span class="supply-metric-label">Total Supply</span>
                                            <span class="supply-metric-value" style="color:#3B82F6;font-weight:700;" x-text="(results.plts+results.battery+results.pln).toFixed(1) + ' kW'"></span>
                                        </div>
                                        <div class="supply-bar-row">
                                            <div class="supply-bar-label-row">
                                                <span>Supply mix</span>
                                            </div>
                                            <div class="supply-stacked-bar">
                                                <div class="supply-bar-seg plts" :style="'width:' + barPct(results.plts, results.plts+results.battery+results.pln) + '%'">PLTS</div>
                                                <div class="supply-bar-seg battery" :style="'width:' + barPct(results.battery, results.plts+results.battery+results.pln) + '%'">Bat</div>
                                                <div class="supply-bar-seg pln" :style="'width:' + barPct(results.pln, results.plts+results.battery+results.pln) + '%'">PLN</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Machine Impact List -->
                            <div class="sim-card" style="padding:0;overflow:hidden;">
                                <div style="padding:20px 20px 12px;">
                                    <div class="sim-card-title" style="margin-bottom:4px;">Machine Impact Analysis</div>
                                    <p style="font-size:13px;color:#94A3B8;">Predicted efficiency and status changes based on simulated energy supply.</p>
                                </div>
                                <table class="impact-table">
                                    <thead>
                                        <tr>
                                            <th>Machine</th>
                                            <th>Current Eff.</th>
                                            <th>Predicted Eff.</th>
                                            <th>Change</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="m in results.machines" :key="m.id">
                                            <tr>
                                                <td><span class="impact-machine-name" x-text="m.name"></span></td>
                                                <td>
                                                    <div style="display:flex;align-items:center;gap:8px;">
                                                        <div class="eff-bar-wrap">
                                                            <div class="eff-bar-track">
                                                                <div class="eff-bar-fill"
                                                                     :class="m.currentEff >= 80 ? 'is-high' : m.currentEff >= 50 ? 'is-medium' : 'is-low'"
                                                                     :style="'width:' + m.currentEff + '%'"></div>
                                                            </div>
                                                        </div>
                                                        <span style="font-size:12px;color:#94A3B8;font-family:'Roboto Mono',monospace;" x-text="m.currentEff + '%'"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="display:flex;align-items:center;gap:8px;">
                                                        <div class="eff-bar-wrap">
                                                            <div class="eff-bar-track">
                                                                <div class="eff-bar-fill"
                                                                     :class="m.predictedEff >= 80 ? 'is-high' : m.predictedEff >= 50 ? 'is-medium' : 'is-low'"
                                                                     :style="'width:' + m.predictedEff + '%'"></div>
                                                            </div>
                                                        </div>
                                                        <span style="font-size:12px;font-family:'Roboto Mono',monospace;"
                                                              :style="m.predictedEff >= 80 ? 'color:#22C55E' : m.predictedEff >= 50 ? 'color:#F59E0B' : 'color:#EF4444'"
                                                              x-text="m.predictedEff + '%'"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="eff-delta"
                                                          :class="(m.predictedEff - m.currentEff) > 0 ? 'is-pos' : (m.predictedEff - m.currentEff) < 0 ? 'is-neg' : 'is-zero'"
                                                          x-text="(m.predictedEff - m.currentEff) > 0 ? '+' + (m.predictedEff - m.currentEff) + '%' : (m.predictedEff - m.currentEff) + '%'">
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="impact-status-chip"
                                                          :class="m.statusChange === 'On' ? 'chip-on' : m.statusChange === 'Reduced' ? 'chip-reduced' : 'chip-off'"
                                                          x-text="m.statusChange"></span>
                                                </td>
                                                <td>
                                                    <span class="priority-badge"
                                                          :class="m.priority === 'HIGH' ? 'badge-high' : m.priority === 'MED' ? 'badge-med' : 'badge-low'"
                                                          x-text="m.priority"></span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Decision Support Output -->
                            <div class="sim-card">
                                <div class="sim-card-title" style="margin-bottom:16px;">Decision Support Recommendations</div>
                                <div class="dss-grid">
                                    <template x-for="rec in results.recommendations" :key="rec.title">
                                        <div class="dss-rec-card"
                                             :class="rec.level === 'high' ? 'is-high' : rec.level === 'medium' ? 'is-medium' : 'is-low'">
                                            <div class="dss-priority-row">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                    <template x-if="rec.level === 'high'">
                                                        <path d="M5 .63a.78.78 0 0 1 .68.38l4.22 7.19a.78.78 0 0 1-.68 1.18H.78A.78.78 0 0 1 .1 8.2L4.32 1a.78.78 0 0 1 .68-.38Z" fill="#EF4444"/>
                                                    </template>
                                                    <template x-if="rec.level === 'medium'">
                                                        <rect x="0" y="2" width="10" height="6" rx="1" fill="#F59E0B"/>
                                                    </template>
                                                    <template x-if="rec.level === 'low'">
                                                        <circle cx="5" cy="5" r="5" fill="#3B82F6"/>
                                                    </template>
                                                </svg>
                                                <span class="dss-priority-label"
                                                      :class="rec.level === 'high' ? 'is-high' : rec.level === 'medium' ? 'is-medium' : 'is-low'"
                                                      x-text="rec.level.toUpperCase() + ' PRIORITY'"></span>
                                            </div>
                                            <div class="dss-rec-title" x-text="rec.title"></div>
                                            <div class="dss-rec-body" x-text="rec.body"></div>
                                            <span class="dss-rec-action"
                                                  :class="rec.level === 'high' ? 'is-high' : rec.level === 'medium' ? 'is-medium' : 'is-low'"
                                                  x-text="rec.action + ' →'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>
                    </template>

                </div><!-- /results-panel -->
            </div><!-- /sim-layout -->

        </div><!-- /page-outer-frame -->
    </main>

    <script>
        function simulationApp() {
            return {
                currentTime: '--:--:--',
                currentDate: '---',
                hasRun: false,

                params: {
                    sunlight: 80,
                    condition: 'sunny',
                    temperature: 28,
                    batteryLevel: 75,
                    batteryMode: 'normal',
                },

                // Baseline reference (what dashboard currently shows)
                baseline: {
                    plts: 284.7,
                    battery: 85.0,
                    pln: 142.3,
                },

                results: {
                    plts: 0,
                    battery: 0,
                    pln: 0,
                    status: 'Stable',
                    ratio: 100,
                    machines: [],
                    recommendations: [],
                },

                machineList: [
                    { id: 1, name: 'Compressor Unit A',    priority: 'HIGH', currentEff: 92, basePower: 85.4 },
                    { id: 2, name: 'CNC Milling M-01',     priority: 'HIGH', currentEff: 88, basePower: 72.1 },
                    { id: 3, name: 'Conveyor Belt C-03',   priority: 'MED',  currentEff: 85, basePower: 45.8 },
                    { id: 4, name: 'Hydraulic Press P-02', priority: 'HIGH', currentEff: 0,  basePower: 62.0 },
                    { id: 5, name: 'Cooling Tower CT-1',   priority: 'MED',  currentEff: 79, basePower: 38.6 },
                    { id: 6, name: 'Welding Station W-4',  priority: 'LOW',  currentEff: 0,  basePower: 28.0 },
                    { id: 7, name: 'Pump Station PS-2',    priority: 'MED',  currentEff: 83, basePower: 31.2 },
                    { id: 8, name: 'Lighting Circuit L-1', priority: 'LOW',  currentEff: 95, basePower: 14.3 },
                ],

                get cloudCover() {
                    const map = { sunny: 5, partly_cloudy: 35, cloudy: 65, rainy: 85, stormy: 95 };
                    return map[this.params.condition] ?? 12;
                },

                computeSimulation() {
                    const s = this.params;

                    // Weather factor on PLTS output
                    const weatherMultiplier = {
                        sunny: 1.0,
                        partly_cloudy: 0.65,
                        cloudy: 0.35,
                        rainy: 0.15,
                        stormy: 0.05,
                    }[s.condition] ?? 1.0;

                    // Temperature derating: panels lose ~0.5% per °C above 25°C
                    const tempDerate = s.temperature > 25
                        ? 1 - ((s.temperature - 25) * 0.005)
                        : 1 + ((25 - Math.max(s.temperature, -10)) * 0.001);
                    const tempFactor = Math.max(0.5, Math.min(tempDerate, 1.1));

                    // Sunlight + weather + temp combined PLTS output (max 350 kW at 100% sunny 25°C)
                    const simPlts = parseFloat(((s.sunlight / 100) * 350 * weatherMultiplier * tempFactor).toFixed(1));

                    // Battery output: depends on level and mode
                    const batteryModeMultiplier = { normal: 1.0, saving: 0.5, emergency: 1.4 }[s.batteryMode] ?? 1.0;
                    const simBattery = parseFloat(((s.batteryLevel / 100) * 120 * batteryModeMultiplier).toFixed(1));

                    // Total demand stays constant (machines don't change without action)
                    const totalDemand = 436.0;

                    // PLN picks up the slack
                    const supplyAvailable = simPlts + simBattery;
                    const simPln = parseFloat(Math.max(0, totalDemand - supplyAvailable).toFixed(1));
                    const totalSupply = parseFloat((simPlts + simBattery + simPln).toFixed(1));

                    // Ratio
                    const ratio = Math.min(100, Math.round((totalSupply / totalDemand) * 100));

                    // Status
                    let status = 'Stable';
                    if (ratio < 70) status = 'Critical';
                    else if (ratio < 90) status = 'Warning';

                    // Machine impact: distribute available supply across machines by priority
                    const machines = this.machineList.map(m => {
                        let predictedEff = m.currentEff;
                        let statusChange = 'On';

                        if (status === 'Stable') {
                            // Supply is fine, small improvement if PLTS is better
                            const pltsDelta = simPlts - this.baseline.plts;
                            if (m.priority === 'LOW' && pltsDelta < -50) {
                                predictedEff = Math.max(0, m.currentEff - Math.round(Math.abs(pltsDelta) / 10));
                                statusChange = predictedEff === 0 ? 'Off' : predictedEff < 50 ? 'Reduced' : 'On';
                            } else if (pltsDelta > 0 && m.currentEff > 0) {
                                predictedEff = Math.min(100, m.currentEff + Math.round(pltsDelta / 30));
                            }
                        } else if (status === 'Warning') {
                            if (m.priority === 'LOW') {
                                predictedEff = Math.max(0, m.currentEff - 30);
                                statusChange = predictedEff < 20 ? 'Off' : 'Reduced';
                            } else if (m.priority === 'MED') {
                                predictedEff = Math.max(0, m.currentEff - 10);
                                statusChange = predictedEff < 50 ? 'Reduced' : 'On';
                            }
                        } else {
                            // Critical: shed non-HIGH machines
                            if (m.priority === 'LOW') {
                                predictedEff = 0;
                                statusChange = 'Off';
                            } else if (m.priority === 'MED') {
                                predictedEff = Math.max(0, m.currentEff - 40);
                                statusChange = predictedEff < 20 ? 'Off' : 'Reduced';
                            } else {
                                predictedEff = Math.max(60, m.currentEff - 10);
                                statusChange = 'On';
                            }
                        }

                        return { ...m, predictedEff, statusChange };
                    });

                    // Recommendations
                    const recommendations = [];
                    if (simPln > 180) {
                        recommendations.push({
                            level: 'high',
                            title: 'Reduce PLN Dependency',
                            body: `PLN usage at ${simPln.toFixed(0)} kW — above safe threshold. Increase battery discharge rate.`,
                            action: 'Switch to Emergency Mode',
                        });
                    }
                    if (simPlts < 100) {
                        recommendations.push({
                            level: 'high',
                            title: 'Low Solar Output',
                            body: `PLTS only producing ${simPlts.toFixed(0)} kW. Shift high-demand machines to off-peak hours.`,
                            action: 'Reschedule Operations',
                        });
                    }
                    if (status === 'Critical' || status === 'Warning') {
                        recommendations.push({
                            level: 'high',
                            title: 'Load Shedding Required',
                            body: 'Supply cannot meet demand. Immediately power off LOW priority machines to stabilize grid.',
                            action: 'Execute Load Shedding',
                        });
                    }
                    if (s.batteryLevel < 30) {
                        recommendations.push({
                            level: 'medium',
                            title: 'Pre-charge Battery',
                            body: `Battery at ${s.batteryLevel}%. Schedule charging during next peak solar window.`,
                            action: 'Schedule Charging',
                        });
                    }
                    if (simPlts > 300) {
                        recommendations.push({
                            level: 'low',
                            title: 'Surplus Solar Available',
                            body: `${simPlts.toFixed(0)} kW from PLTS — consider storing excess in battery to maximise self-sufficiency.`,
                            action: 'Charge Battery',
                        });
                    }
                    if (s.temperature > 35) {
                        recommendations.push({
                            level: 'medium',
                            title: 'High Temperature Alert',
                            body: `${s.temperature}°C reduces panel efficiency. Inspect cooling systems and ventilation.`,
                            action: 'Inspect Cooling',
                        });
                    }
                    if (recommendations.length === 0) {
                        recommendations.push({
                            level: 'low',
                            title: 'System Optimal',
                            body: 'Energy supply meets demand with good margin. No immediate action required.',
                            action: 'Monitor Status',
                        });
                    }

                    // Persist to localStorage for dashboard
                    const simPayload = {
                        active: true,
                        timestamp: Date.now(),
                        params: { ...s },
                        results: { plts: simPlts, battery: simBattery, pln: simPln, status, ratio },
                        summary: `${status} — PLTS: ${simPlts.toFixed(0)} kW, Battery: ${simBattery.toFixed(0)} kW, PLN: ${simPln.toFixed(0)} kW`,
                    };
                    try { localStorage.setItem('loadsync_sim', JSON.stringify(simPayload)); } catch(e) {}

                    return { plts: simPlts, battery: simBattery, pln: simPln, status, ratio, machines, recommendations };
                },

                runSimulation() {
                    this.results = this.computeSimulation();
                    this.hasRun = true;
                    // Scroll results into view smoothly
                    this.$nextTick(() => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                },

                resetSimulation() {
                    this.params = { sunlight: 80, condition: 'sunny', temperature: 28, batteryLevel: 75, batteryMode: 'normal' };
                    this.hasRun = false;
                    try { localStorage.removeItem('loadsync_sim'); } catch(e) {}
                },

                loadPreset(preset) {
                    const presets = {
                        peak:        { sunlight: 100, condition: 'sunny',   temperature: 32, batteryLevel: 85, batteryMode: 'normal'    },
                        storm:       { sunlight: 5,   condition: 'stormy',  temperature: 18, batteryLevel: 45, batteryMode: 'emergency' },
                        low_battery: { sunlight: 60,  condition: 'cloudy',  temperature: 25, batteryLevel: 10, batteryMode: 'saving'    },
                    };
                    if (presets[preset]) this.params = { ...presets[preset] };
                },

                barPct(val, total) {
                    if (total === 0) return 0;
                    return ((val / total) * 100).toFixed(2);
                },

                init() {
                    this.tickClock();
                    setInterval(() => this.tickClock(), 1000);
                },

                tickClock() {
                    const now   = new Date();
                    const pad   = n => String(n).padStart(2, '0');
                    const days  = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                    const months= ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    this.currentTime = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
                    this.currentDate = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getDate()}`;
                },
            };
        }
    </script>
</body>
</html>
