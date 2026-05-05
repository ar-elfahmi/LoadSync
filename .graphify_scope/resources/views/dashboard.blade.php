<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoadSync — Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        .weather-divider {
            width: 1px;
            height: 32px;
            background: #334155;
            margin: 0 4px;
        }

        .clock-block {
            border-left: 1px solid rgba(51,65,85,0.5);
            padding: 6px 26px;
            text-align: center;
        }

        .clock-time {
            font-size: 18px;
            font-weight: 600;
            color: #E2E8F0;
            line-height: 20px;
        }

        .clock-date {
            font-size: 15px;
            font-weight: 400;
            color: #94A3B8;
            line-height: 16px;
        }

        .bell-btn {
            position: relative;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            margin-left: 12px;
            background: none;
            border: none;
        }

        .bell-dot {
            position: absolute;
            top: 0; right: 0;
            width: 12px;
            height: 12px;
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
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
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
            padding: 28px;
            min-height: calc(100vh - 80px);
        }

        .content-frame {
            border: 2px solid #6B7280;
            border-radius: 10px;
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── CARD BASE ── */
        .card {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #FFF;
        }

        /* ── KPI ROW ── */
        .kpi-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .kpi-card {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .kpi-card--ok { border-color: #22C55E; }

        .kpi-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kpi-icon-wrap {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .kpi-icon-wrap--green  { background: rgba(16,185,129,0.2); }
        .kpi-icon-wrap--blue   { background: rgba(59,130,246,0.2); }
        .kpi-icon-wrap--amber  { background: rgba(245,158,11,0.15); }
        .kpi-icon-wrap--emerald { background: rgba(34,197,94,0.15); }

        .kpi-value-block { display: flex; flex-direction: column; gap: 2px; }

        .kpi-value-row {
            display: flex;
            align-items: flex-end;
            gap: 2px;
        }

        .kpi-number {
            font-size: 28px;
            font-weight: 600;
            color: #F8FAFC;
            line-height: 28px;
        }

        .kpi-unit {
            font-size: 16px;
            font-weight: 600;
            color: #F8FAFC;
            line-height: 16px;
            margin-bottom: 2px;
        }

        .kpi-label {
            font-size: 12px;
            font-weight: 400;
            color: #94A3B8;
            line-height: 18px;
        }

        .kpi-trend {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 500;
            color: #22C55E;
        }

        /* Battery indicator */
        .battery-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .battery-body {
            width: 20px;
            height: 52px;
            border: 2px solid #334155;
            border-radius: 2px;
            background: #0F172A;
            overflow: hidden;
            position: relative;
        }

        .battery-fill {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: #3B82F6;
            transition: height 0.5s;
        }

        .battery-cap {
            width: 8px;
            height: 3px;
            border-radius: 0 0 2px 2px;
            background: #334155;
        }

        /* Battery progress bar */
        .progress-bar-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .progress-bar-track {
            height: 8px;
            border-radius: 9999px;
            background: rgba(148,163,184,0.4);
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            transition: width 0.5s;
        }

        .progress-bar-fill--blue   { background: #3B82F6; }
        .progress-bar-fill--amber  { background: linear-gradient(90deg, #F59E0B, #D97706); }

        .progress-bar-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .progress-label-text {
            font-size: 12px;
            font-weight: 400;
            color: #F59E0B;
        }

        .progress-label-remaining {
            font-family: 'Roboto Mono', monospace;
            font-size: 12px;
            font-weight: 400;
            color: #94A3B8;
        }

        /* Gauge SVG container */
        .gauge-wrap {
            width: 56px;
            height: 48px;
            flex-shrink: 0;
        }

        /* System status indicators */
        .status-indicators {
            display: flex;
            justify-content: center;
            gap: 24px;
        }

        .status-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-dot--green { background: #22C55E; }
        .status-dot--red   { background: #EF4444; }
        .status-dot--amber { background: #F59E0B; }
        .status-dot--gray  { background: #94A3B8; }

        .status-dot-label {
            font-size: 10px;
            font-weight: 400;
            color: #94A3B8;
            white-space: nowrap;
        }

        /* ── POWER BALANCE ── */
        .power-balance-card { padding: 16px; }

        .power-balance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .surplus-badge {
            display: flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(34,197,94,0.2);
            box-shadow: 0 0 8px rgba(34,197,94,0.4);
        }

        .surplus-text {
            font-size: 11px;
            font-weight: 700;
            color: #22C55E;
        }

        .balance-section { margin-bottom: 8px; }

        .balance-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .balance-section-title {
            font-size: 10px;
            font-weight: 600;
            color: #D1D5DB;
        }

        .balance-legend {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            color: #6B7280;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .legend-dot--green  { background: #22C55E; }
        .legend-dot--blue   { background: #3B82F6; }
        .legend-dot--purple { background: #8B5CF6; }
        .legend-dot--amber  { background: #F59E0B; }
        .legend-dot--gray   { background: #6B7280; }

        .stacked-bar {
            display: flex;
            height: 24px;
            border-radius: 6px;
            overflow: hidden;
        }

        .bar-segment {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 700;
            color: #FFF;
            overflow: hidden;
            white-space: nowrap;
            transition: width 0.5s;
        }

        .bar-segment--green  { background: #22C55E; }
        .bar-segment--blue   { background: #3B82F6; }
        .bar-segment--purple { background: #8B5CF6; }
        .bar-segment--amber  { background: #F59E0B; }
        .bar-segment--gray   { background: #475569; }

        /* ── CHARTS + DSS ROW ── */
        .panels-row {
            display: grid;
            grid-template-columns: 1fr 1.2fr 1.2fr;
            gap: 20px;
        }

        .chart-card { padding: 16px; }

        .chart-container {
            position: relative;
            width: 100%;
            height: 140px;
            margin: 8px 0;
        }

        .chart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-footer-text { font-size: 10px; }
        .chart-footer-text strong { font-weight: 600; color: #F59E0B; }
        .chart-footer-text span { color: #9CA3AF; }

        .chart-footer-right strong { font-weight: 600; color: #D1D5DB; }
        .chart-footer-right span { color: #9CA3AF; }

        .energy-chart-legend {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .energy-legend-item {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 9px;
            color: #9CA3AF;
        }

        .energy-legend-line {
            width: 16px;
            height: 2px;
            flex-shrink: 0;
        }

        .energy-legend-line--green  { background: #22C55E; }
        .energy-legend-line--orange { background: #F97316; }
        .energy-legend-line--blue   { background: #3B82F6; }

        /* Confidence badge */
        .confidence-badge {
            padding: 2px 8px;
            border-radius: 9999px;
            background: rgba(245,158,11,0.2);
            font-size: 10px;
            font-weight: 600;
            color: #F59E0B;
        }

        /* ── DECISION SUPPORT ── */
        .dss-card { padding: 16px; }

        .alert-card {
            padding: 12px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 8px;
        }

        .alert-card:last-child { margin-bottom: 0; }

        .alert-card--high {
            border: 1px solid rgba(239,68,68,0.4);
            background: rgba(239,68,68,0.05);
            box-shadow: 0 0 8px rgba(239,68,68,0.15);
        }

        .alert-card--medium {
            border: 1px solid rgba(245,158,11,0.4);
            background: rgba(245,158,11,0.05);
        }

        .alert-card--low {
            border: 1px solid rgba(59,130,246,0.4);
            background: rgba(59,130,246,0.05);
        }

        .alert-priority-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alert-priority-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.25px;
            text-transform: uppercase;
        }

        .alert-priority-label--high   { color: #EF4444; }
        .alert-priority-label--medium { color: #F59E0B; }
        .alert-priority-label--low    { color: #3B82F6; }

        .alert-title {
            font-size: 12px;
            font-weight: 600;
            color: #FFF;
        }

        .alert-body {
            font-size: 10px;
            font-weight: 400;
            color: #9CA3AF;
            line-height: 1.625;
        }

        .alert-savings {
            font-size: 10px;
            font-weight: 500;
            color: #22C55E;
        }

        /* ── BOTTOM ROW ── */
        .bottom-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        /* ── MACHINE TABLE ── */
        .machine-card { padding: 16px; }

        .machine-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .filter-tabs {
            display: flex;
            gap: 4px;
        }

        .filter-tab {
            padding: 4px 12px;
            border-radius: 4px;
            border: none;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .filter-tab--active { background: #3B82F6; color: #FFF; }
        .filter-tab--inactive { background: #334155; color: #9CA3AF; }
        .filter-tab--inactive:hover { background: #3D5068; color: #CBD5E1; }

        .machine-mini-table {
            width: 100%;
            border-collapse: collapse;
        }

        .machine-mini-table thead tr {
            border-bottom: 1px solid #334155;
        }

        .machine-mini-table th {
            padding: 6px 8px;
            font-size: 10px;
            font-weight: 500;
            color: #6B7280;
            text-align: left;
            white-space: nowrap;
        }

        .machine-mini-table td {
            padding: 0 8px;
            height: 44px;
            vertical-align: middle;
            border-top: 1px solid #334155;
        }

        .machine-mini-table tbody tr {
            transition: background 0.15s;
        }

        .machine-mini-table tbody tr:hover {
            background: rgba(51,65,85,0.25);
        }

        .machine-name-text {
            font-size: 13px;
            font-weight: 500;
            color: #E2E8F0;
            white-space: nowrap;
        }

        .priority-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 22px;
            padding: 0 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
        }

        .badge-high { border: 1px solid #EF4444; background: rgba(239,68,68,0.2); color: #EF4444; }
        .badge-med  { border: 1px solid #F59E0B; background: rgba(245,158,11,0.2); color: #F59E0B; }
        .badge-low  { border: 1px solid #3B82F6; background: rgba(59,130,246,0.2); color: #3B82F6; }

        .machine-status-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .machine-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .machine-status-dot--active  { background: #22C55E; }
        .machine-status-dot--standby { background: #F59E0B; }
        .machine-status-dot--offline { background: #EF4444; }

        .machine-status-text {
            font-size: 12px;
            font-weight: 500;
            color: #CBD5E1;
        }

        .machine-power-text {
            font-family: 'Roboto Mono', monospace;
            font-size: 12px;
            font-weight: 600;
            color: #E2E8F0;
        }

        /* Small Toggle */
        .small-toggle {
            position: relative;
            width: 36px;
            height: 20px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .toggle-track {
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: #334155;
            transition: background 0.25s;
        }

        .toggle-track--on { background: #22C55E; }

        .toggle-thumb {
            position: absolute;
            top: 3px;
            left: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #FFF;
            transition: transform 0.25s;
        }

        .toggle-thumb--on { transform: translateX(14px); }

        .machine-footer {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-top: 12px;
            border-top: 1px solid #334155;
            margin-top: 8px;
        }

        .machine-footer-text {
            font-size: 10px;
            color: #9CA3AF;
        }

        .machine-footer-text strong { font-weight: 600; color: #FFF; }

        .view-all-link {
            font-size: 12px;
            font-weight: 500;
            color: #3B82F6;
            text-decoration: none;
            margin-left: auto;
        }

        .view-all-link:hover { text-decoration: underline; }

        /* ── ACTIVITY LOG ── */
        .activity-card { padding: 16px; }

        .activity-entries {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .activity-entry {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .activity-time {
            font-size: 10px;
            font-weight: 400;
            color: #6B7280;
            padding-top: 2px;
            width: 36px;
            flex-shrink: 0;
        }

        .activity-dot-wrap {
            padding-top: 6px;
            flex-shrink: 0;
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .activity-dot--green  { background: #22C55E; box-shadow: 0 0 6px rgba(34,197,94,0.7); }
        .activity-dot--amber  { background: #F59E0B; box-shadow: 0 0 5px rgba(245,158,11,0.6); }
        .activity-dot--blue   { background: #3B82F6; box-shadow: 0 0 6px rgba(59,130,246,0.7); }
        .activity-dot--red    { background: #EF4444; box-shadow: 0 0 5px rgba(239,68,68,0.6); }

        .activity-message {
            font-size: 11px;
            font-weight: 400;
            color: #D1D5DB;
            line-height: 1.625;
        }

        .activity-log-footer {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #334155;
        }

        .view-full-log-link {
            font-size: 12px;
            font-weight: 500;
            color: #3B82F6;
            text-decoration: none;
        }

        .view-full-log-link:hover { text-decoration: underline; }
    </style>
</head>
<body x-data="dashboardApp()" x-init="init()">

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
                    <span x-text="weather.temp + '°C'">28°C</span>
                </div>
                <div class="weather-divider"></div>
                <div class="weather-stat">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2.28 9.93A4 4 0 0 1 6.11 2c2.02.14 3.74 1.46 4.32 3.33h1.25A2.67 2.67 0 0 1 13.41 10.83" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                        <path d="M10.67 9.33v4M5.34 9.33v4M8 10.67v4" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span x-text="weather.cloud + '% Cloud'">12% Cloud</span>
                </div>
            </div>
            <div class="clock-block">
                <div class="clock-time" x-text="currentTime">--:--:--</div>
                <div class="clock-date" x-text="currentDate">---</div>
            </div>
            <button class="bell-btn" aria-label="Notifications">
                <svg width="24" height="24" viewBox="0 0 29 29" fill="none">
                    <path d="M12.41 25.38a4 4 0 0 0 4.19 0" stroke="#94A3B8" stroke-width="3" stroke-linecap="round"/>
                    <path d="M3.84 18.51c-.33.35-.41.86-.21 1.3.19.44.63.72 1.11.72h19.52c.48 0 .92-.28 1.12-.72.19-.44.11-.95-.19-1.3C23.54 16.85 21.82 15.09 21.82 9.66c0-4-3.28-7.25-7.32-7.25-4.04 0-7.32 3.25-7.32 7.25 0 5.43-1.72 7.19-3.34 8.85Z" stroke="#94A3B8" stroke-width="3" stroke-linecap="round"/>
                </svg>
                <div class="bell-dot"></div>
            </button>
        </div>
    </nav>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <a class="nav-icon-btn is-active" href="/dashboard" title="Dashboard">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3.91 14.02a2 2 0 0 1-.93-1.57L13.13 2.11a.5.5 0 0 1 .75.46l-1.94 6.06c-.11.31-.07.66.12.93.19.27.51.43.84.43H20.08a1 1 0 0 1 .92 1.39L10.86 21.9a.5.5 0 0 1-.83-.46l1.94-6.06c.12-.31.07-.66-.12-.93a1.07 1.07 0 0 0-.84-.43H3.91Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="/machines" title="Machine Management">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2"/>
                <rect x="14" y="3" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2"/>
                <rect x="14" y="14" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2"/>
                <rect x="3" y="14" width="7" height="7" rx="1" stroke="#94A3B8" stroke-width="2"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="/energy_simulation" title="Simulation">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14.06 2v6c0 .34.09.66.25.96L20 19.04A2 2 0 0 1 18.19 22H5.81A2 2 0 0 1 4 19.04L9.68 8.96A2 2 0 0 0 9.94 8V2" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                <path d="M6.45 15h11.09M8.5 2h7" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="#" title="Settings">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.23 2h-.46a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.44.25a2 2 0 0 1-2 0l-.16-.08a2 2 0 0 0-2.73.73l-.23.38a2 2 0 0 0 .73 2.73l.15.09a2 2 0 0 1 1 1.73v.5a2 2 0 0 1-1 1.73l-.15.09a2 2 0 0 0-.73 2.73l.23.38a2 2 0 0 0 2.73.73l.16-.08a2 2 0 0 1 2 0l.44.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.46a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.44-.25a2 2 0 0 1 2 0l.16.08a2 2 0 0 0 2.73-.73l.23-.38a2 2 0 0 0-.73-2.73l-.15-.09A2 2 0 0 1 19.08 12.25v-.5a2 2 0 0 1 1-1.73l.15-.09a2 2 0 0 0 .73-2.73l-.23-.38a2 2 0 0 0-2.73-.73l-.16.08a2 2 0 0 1-2 0l-.44-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2Z" stroke="#94A3B8" stroke-width="2"/>
                <circle cx="12" cy="12" r="3" stroke="#94A3B8" stroke-width="2"/>
            </svg>
        </a>
    </aside>

    <!-- ── MAIN ── -->
    <main class="page-wrapper">
        <div class="content-frame">

            <!-- ══ KPI CARDS ══ -->
            <div class="kpi-row">

                <!-- Today's Production -->
                <div class="card kpi-card">
                    <div class="kpi-card-top">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="kpi-icon-wrap kpi-icon-wrap--green">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M12.71.04a.5.5 0 0 1 .34.42l.7 3.79 3.79.7a.5.5 0 0 1 .26.81L15.71 9l1.9 2.96a.5.5 0 0 1-.26.81l-3.79.7-.7 3.79a.5.5 0 0 1-.81.26L9 15.62 6.04 17.52a.5.5 0 0 1-.81-.26l-.7-3.79-3.79-.7a.5.5 0 0 1-.26-.81L2.38 9 .48 6.04a.5.5 0 0 1 .26-.81l3.79-.7.7-3.79A.5.5 0 0 1 6.04.48L9 2.38 11.96.48a.5.5 0 0 1 .75-.44ZM5.62 9a3.375 3.375 0 1 0 6.75 0 3.375 3.375 0 0 0-6.75 0Z" fill="#34D399"/>
                                </svg>
                            </div>
                            <div class="kpi-value-block">
                                <div class="kpi-value-row">
                                    <span class="kpi-number" x-text="production">847</span>
                                    <span class="kpi-unit">kWh</span>
                                </div>
                                <div class="kpi-label">Today's Production</div>
                            </div>
                        </div>
                        <!-- Mini sparkline -->
                        <svg width="80" height="48" viewBox="0 0 80 48" fill="none">
                            <path d="M80 48H0V42L11 34 23 22 34 13 46 6 57 2 69 4 80 9" fill="#22C55E" fill-opacity="0.2"/>
                            <path d="M0 42L11 34 23 22 34 13 46 6 57 2 69 4 80 9" stroke="#22C55E" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="kpi-trend">
                        <svg width="13" height="11" viewBox="0 0 13 11" fill="none">
                            <path d="M8.25 3.44a.69.69 0 0 1 0-1.38h3.44c.38 0 .69.31.69.69v3.44a.69.69 0 1 1-1.38 0V4.41L7.36 8.05a.69.69 0 0 1-.97 0L4.13 5.79 1.17 8.74a.69.69 0 0 1-.97-.97L3.64 4.32a.69.69 0 0 1 .97 0L6.88 6.59 10.03 3.44H8.25Z" fill="#22C55E"/>
                        </svg>
                        +12% vs yesterday
                    </div>
                </div>

                <!-- Battery State of Charge -->
                <div class="card kpi-card">
                    <div class="kpi-card-top">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="kpi-icon-wrap kpi-icon-wrap--blue">
                                <svg width="21" height="18" viewBox="0 0 21 18" fill="none">
                                    <path d="M16.31 5.63c.31 0 .56.25.56.56v5.63c0 .31-.25.56-.56.56H2.81c-.31 0-.56-.25-.56-.56V6.19c0-.31.25-.56.56-.56h13.5ZM2.81 3.38C1.26 3.38 0 4.63 0 6.19v5.63C0 13.37 1.26 14.63 2.81 14.63h13.5c1.55 0 2.81-1.26 2.81-2.81v-.56c.62 0 1.12-.5 1.12-1.13V8.44c0-.62-.5-1.13-1.12-1.13V6.19c0-1.55-1.26-2.81-2.81-2.81H2.81ZM6.75 6.75H2.25v4.5h4.5v-4.5Z" fill="#3B82F6"/>
                                </svg>
                            </div>
                            <div class="kpi-value-block">
                                <div class="kpi-value-row">
                                    <span class="kpi-number" x-text="batteryPct">78</span>
                                    <span class="kpi-unit">%</span>
                                </div>
                                <div class="kpi-label">State of Charge</div>
                            </div>
                        </div>
                        <div class="battery-indicator">
                            <div class="battery-body">
                                <div class="battery-fill" :style="'height:' + batteryPct + '%'"></div>
                            </div>
                            <div class="battery-cap"></div>
                        </div>
                    </div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill progress-bar-fill--blue" :style="'width:' + batteryPct + '%'"></div>
                        </div>
                        <div class="progress-bar-label">
                            <span></span>
                            <span class="progress-label-remaining" x-text="batteryHoursLeft + 'h left'">4.2h left</span>
                        </div>
                    </div>
                </div>

                <!-- Current Draw -->
                <div class="card kpi-card">
                    <div class="kpi-card-top">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="kpi-icon-wrap kpi-icon-wrap--amber">
                                <svg width="14" height="18" viewBox="0 0 14 18" fill="none">
                                    <path d="M3.38 0C2.75 0 2.25.5 2.25 1.13V4.5h2.25V1.13C4.5.5 4 0 3.38 0Zm6.75 0C9.5 0 9 .5 9 1.13V4.5h2.25V1.13C11.25.5 10.75 0 10.13 0ZM1.13 5.63C.5 5.63 0 6.13 0 6.75S.5 7.88 1.13 7.88V9c0 2.72 1.93 4.99 4.5 5.51V16.88C5.63 17.5 6.13 18 6.75 18S7.88 17.5 7.88 16.88V14.51C10.44 13.99 12.38 11.72 12.38 9V7.88c.62 0 1.12-.5 1.12-1.13s-.5-1.12-1.13-1.12H1.13Z" fill="#F59E0B"/>
                                </svg>
                            </div>
                            <div class="kpi-value-block">
                                <div class="kpi-value-row">
                                    <span class="kpi-number" x-text="currentDraw">234</span>
                                    <span class="kpi-unit">kW</span>
                                </div>
                                <div class="kpi-label">Current Draw</div>
                            </div>
                        </div>
                        <!-- Gauge SVG -->
                        <div class="gauge-wrap">
                            <svg width="56" height="48" viewBox="0 0 56 48" fill="none">
                                <path d="M0 38C0 30.57 2.95 23.45 8.2 18.2 13.45 12.95 20.57 10 28 10c7.43 0 14.55 2.95 19.8 8.2C53.05 23.45 56 30.57 56 38H49a21 21 0 0 0-21-21 21 21 0 0 0-21 21H0Z" fill="#334155" fill-opacity="0.4"/>
                                <path d="M1.4 38C1.4 32.24 3.27 26.64 6.73 22.03c3.46-4.61 8.32-7.97 13.85-9.58 5.53-1.61 11.43-1.38 16.82.66 5.39 2.04 9.97 5.77 13.06 10.63L46.91 25.9C44.31 21.9 40.46 18.76 35.92 17.05c-4.54-1.71-9.51-1.91-14.17-.55C17.09 17.84 13 20.67 10.09 24.55 7.17 28.43 5.6 33.15 5.6 38H1.4Z" fill="#F59E0B"/>
                            </svg>
                        </div>
                    </div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-label" style="margin-bottom:4px;">
                            <span class="progress-label-text" x-text="drawPct + '% of ' + drawLimit + ' kW limit'">82% of 285 kW limit</span>
                        </div>
                        <div class="progress-bar-track" style="height:6px;">
                            <div class="progress-bar-fill progress-bar-fill--amber" :style="'width:' + drawPct + '%'"></div>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="card kpi-card kpi-card--ok">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:auto;">
                        <div class="kpi-icon-wrap kpi-icon-wrap--emerald">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M18.34 10H16.27c-.75 0-1.41.5-1.61 1.22L12.7 18.19a.5.5 0 0 1-.96 0L7.7 1.82a.5.5 0 0 0-.96 0L4.79 8.79A1.67 1.67 0 0 1 3.04 10H1.67" stroke="#22C55E" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="kpi-value-block">
                            <div class="kpi-number" style="font-size:22px;" x-text="systemStatus">All Normal</div>
                            <div class="kpi-label">System Status</div>
                        </div>
                    </div>
                    <div class="status-indicators">
                        <div class="status-indicator">
                            <div class="status-dot status-dot--green"></div>
                            <div class="status-dot-label">PLTS</div>
                        </div>
                        <div class="status-indicator">
                            <div class="status-dot status-dot--green"></div>
                            <div class="status-dot-label">Battery</div>
                        </div>
                        <div class="status-indicator">
                            <div class="status-dot status-dot--green"></div>
                            <div class="status-dot-label">Grid PLN</div>
                        </div>
                        <div class="status-indicator">
                            <div class="status-dot status-dot--green"></div>
                            <div class="status-dot-label">Control</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ REAL-TIME POWER BALANCE ══ -->
            <div class="card power-balance-card">
                <div class="power-balance-header">
                    <div class="card-header" style="margin-bottom:0;">
                        <svg width="12" height="12" viewBox="0 0 12 16" fill="none">
                            <path d="M9.55 1.22c.16-.37.04-.81-.29-1.05-.33-.24-.78-.22-1.09.05L1.17 6.34a1 1 0 0 0 .58 1.75H4.8L2.7 12.78c-.16.37-.04.81.29 1.05.33.24.78.22 1.09-.05L11.08 7.66A1 1 0 0 0 10.5 5.9H7.45L9.55 1.22Z" fill="#F59E0B"/>
                        </svg>
                        <span class="card-title">Real-Time Power Balance</span>
                    </div>
                    <div class="surplus-badge">
                        <span class="surplus-text" x-text="'+' + surplusKw + ' kW SURPLUS'">+76.0 kW SURPLUS</span>
                    </div>
                </div>

                <!-- Supply Bar -->
                <div class="balance-section">
                    <div class="balance-section-header">
                        <span class="balance-section-title" x-text="'SUPPLY — ' + totalSupply.toFixed(1) + ' kW Total'">SUPPLY — 512.0 kW Total</span>
                        <div class="balance-legend">
                            <div class="legend-item"><div class="legend-dot legend-dot--green"></div>PLTS <span x-text="pltsSupply.toFixed(1) + ' kW'" style="margin-left:2px;"></span></div>
                            <div class="legend-item"><div class="legend-dot legend-dot--blue"></div>Battery <span x-text="batterySupply.toFixed(1) + ' kW'" style="margin-left:2px;"></span></div>
                            <div class="legend-item"><div class="legend-dot legend-dot--purple"></div>PLN <span x-text="plnSupply.toFixed(1) + ' kW'" style="margin-left:2px;"></span></div>
                        </div>
                    </div>
                    <div class="stacked-bar">
                        <div class="bar-segment bar-segment--green" :style="'width:' + supplyPct(pltsSupply) + '%'">
                            PLTS <span x-text="pltsSupply.toFixed(1)"></span>
                        </div>
                        <div class="bar-segment bar-segment--blue" :style="'width:' + supplyPct(batterySupply) + '%'">
                            Bat <span x-text="batterySupply.toFixed(0)"></span>
                        </div>
                        <div class="bar-segment bar-segment--purple" :style="'width:' + supplyPct(plnSupply) + '%'">
                            PLN <span x-text="plnSupply.toFixed(1)"></span>
                        </div>
                    </div>
                </div>

                <!-- Demand Bar -->
                <div class="balance-section" style="margin-bottom:0;">
                    <div class="balance-section-header">
                        <span class="balance-section-title" x-text="'DEMAND — ' + totalDemand.toFixed(1) + ' kW Total'">DEMAND — 436.0 kW Total</span>
                        <div class="balance-legend">
                            <div class="legend-item"><div class="legend-dot legend-dot--amber"></div>Machines <span x-text="machineDemand.toFixed(1) + ' kW'" style="margin-left:2px;"></span></div>
                            <div class="legend-item"><div class="legend-dot legend-dot--gray"></div>Idle <span x-text="idleDemand.toFixed(1) + ' kW'" style="margin-left:2px;"></span></div>
                        </div>
                    </div>
                    <div class="stacked-bar">
                        <div class="bar-segment bar-segment--amber" :style="'width:' + demandPct(machineDemand) + '%'">
                            Machines <span x-text="machineDemand.toFixed(1) + ' kW'"></span>
                        </div>
                        <div class="bar-segment bar-segment--gray" :style="'width:' + demandPct(idleDemand) + '%'">
                            Idle
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ CHARTS + DECISION SUPPORT ══ -->
            <div class="panels-row">

                <!-- Solar Generation Forecast -->
                <div class="card chart-card">
                    <div class="card-header" style="justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M9.88.03a.5.5 0 0 1 .27.33l.54 2.95 2.95.54a.5.5 0 0 1 .26.84L11.72 7l1.98 2.47a.5.5 0 0 1-.26.84l-2.95.54-.54 2.95a.5.5 0 0 1-.84.26L7 12.08 4.53 14.06a.5.5 0 0 1-.84-.26l-.54-2.95-2.95-.54A.5.5 0 0 1 .14 9.47L2.08 7 .14 4.53a.5.5 0 0 1 .26-.84l2.95-.54.54-2.95A.5.5 0 0 1 4.73.14L7 1.78 9.47.14a.5.5 0 0 1 .41-.11ZM4.38 7a2.625 2.625 0 1 0 5.25 0 2.625 2.625 0 0 0-5.25 0Z" fill="#F59E0B"/>
                            </svg>
                            <span class="card-title">Solar Generation Forecast</span>
                        </div>
                        <span class="confidence-badge">92% Confidence</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="solarChart"></canvas>
                    </div>
                    <div class="chart-footer">
                        <div class="chart-footer-text">
                            <span>Today's peak: </span>
                            <strong>11:00 – 312 kW</strong>
                        </div>
                        <div class="chart-footer-text chart-footer-right">
                            <span>Tomorrow est: </span>
                            <strong>270 kWh</strong>
                        </div>
                    </div>
                </div>

                <!-- Energy Consumption Profile -->
                <div class="card chart-card">
                    <div class="card-header">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M1.75 1.75C1.75 1.27 1.36.88.88.88S0 1.27 0 1.75v9.19C0 12.15.98 13.13 2.19 13.13h10.94c.48 0 .88-.4.88-.88s-.4-.88-.88-.88H2.19c-.24 0-.44-.2-.44-.44V1.75ZM4.38 9.63h7.88c.48 0 .88-.4.88-.88V6.9c0-.21-.08-.41-.29-.56L11.12 4.22a.88.88 0 0 0-1.28.15L9.26 4.74a.88.88 0 0 1-1.31-.04L6.72 3.41a.88.88 0 0 0-1.35.4L3.22 6.38a.88.88 0 0 0-.1.43v2.29c0 .48.4.88.88.88l.38-.45Z" fill="#3B82F6"/>
                        </svg>
                        <span class="card-title">Energy Consumption Profile</span>
                    </div>
                    <div class="energy-chart-legend">
                        <div class="energy-legend-item">
                            <div class="energy-legend-line energy-legend-line--green"></div>Supply
                        </div>
                        <div class="energy-legend-item">
                            <div class="energy-legend-line energy-legend-line--orange"></div>Demand
                        </div>
                        <div class="energy-legend-item">
                            <div class="energy-legend-line energy-legend-line--blue" style="border-top:2px dashed #3B82F6;height:0;background:none;"></div>Battery
                        </div>
                    </div>
                    <div class="chart-container" style="height:130px;">
                        <canvas id="energyChart"></canvas>
                    </div>
                </div>

                <!-- Decision Support -->
                <div class="card dss-card">
                    <div class="card-header" style="margin-bottom:12px;">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M5.03 0c.85 0 1.53.69 1.53 1.53v10.94c0 .85-.68 1.53-1.53 1.53-.79 0-1.44-.59-1.52-1.37-.14.04-.29.06-.44.06C1.1 12.69.31 11.9.31 10.94c0-.2.03-.39.1-.57C.12 10.05-.01 9.25 0 8.31c0-.87.51-1.62 1.25-1.96-.24-.3-.38-.67-.38-1.08 0-.84.59-1.53 1.38-1.7-.05-.15-.07-.31-.07-.47C2.19 2.24 2.75 1.56 3.51 1.36 3.59.6 4.24 0 5.03 0Zm3.94 0c.79 0 1.44.6 1.52 1.36.76.19 1.31.88 1.31 1.69 0 .16-.02.31-.07.47.79.17 1.38.86 1.38 1.7 0 .41-.14.78-.38 1.08.74.35 1.25 1.09 1.25 1.96.09.93-.04 1.73-.41 2.06.07.18.1.37.1.57 0 .96-.78 1.75-1.75 1.75-.15 0-.3-.02-.44-.06-.08.78-.73 1.37-1.52 1.37C8.12 14 7.44 13.31 7.44 12.47V1.53C7.44.69 8.12 0 8.97 0Z" fill="#8B5CF6"/>
                        </svg>
                        <span class="card-title">Decision Support</span>
                    </div>

                    <!-- HIGH -->
                    <div class="alert-card alert-card--high">
                        <div class="alert-priority-row">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M6 .75c.33 0 .64.18.81.46l5.06 8.63a.94.94 0 0 1-.81 1.41H.94A.94.94 0 0 1 .13 9.84L5.19 1.21A.94.94 0 0 1 6 .75ZM6 3.75a.56.56 0 0 0-.56.56V6.94a.56.56 0 0 0 1.13 0V4.31A.56.56 0 0 0 6 3.75ZM6.75 9a.75.75 0 1 0-1.5 0 .75.75 0 0 0 1.5 0Z" fill="#EF4444"/>
                            </svg>
                            <span class="alert-priority-label alert-priority-label--high">HIGH PRIORITY</span>
                        </div>
                        <div class="alert-title">Reduce PLN Load</div>
                        <div class="alert-body">PLN nearing 60% threshold. Switch 2 non-critical machines to battery.</div>
                        <div class="alert-savings">Potential savings: Rp 420,000/hr</div>
                    </div>

                    <!-- MEDIUM -->
                    <div class="alert-card alert-card--medium">
                        <div class="alert-priority-row">
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M10.88 3.75c.21 0 .38.17.38.38v3.75c0 .21-.17.38-.38.38H1.88c-.21 0-.38-.17-.38-.38V4.13c0-.21.17-.38.38-.38h9ZM1.88 2.25A1.88 1.88 0 0 0 0 4.13v3.75A1.88 1.88 0 0 0 1.88 9.75h9A1.88 1.88 0 0 0 12.75 7.88V7.5c.41 0 .75-.34.75-.75V5.25A.75.75 0 0 0 12.75 4.5v-.38A1.88 1.88 0 0 0 10.88 2.25H1.88ZM6.75 4.5H2.25v3h4.5v-3Z" fill="#F59E0B"/>
                            </svg>
                            <span class="alert-priority-label alert-priority-label--medium">MEDIUM PRIORITY</span>
                        </div>
                        <div class="alert-title">Pre-charge Battery</div>
                        <div class="alert-body">Cloud cover expected at 15:00. Pre-charge battery to 90% before solar drops.</div>
                    </div>

                    <!-- LOW -->
                    <div class="alert-card alert-card--low">
                        <div class="alert-priority-row">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="6" fill="#3B82F6"/>
                                <path d="M5.06 7.88H5.63V6.38H5.06A.56.56 0 0 1 5.06 5.25h1.13a.56.56 0 0 1 .56.56v2.06h.19a.56.56 0 0 1 0 1.13H5.06a.56.56 0 0 1 0-1.13ZM6 4.5A.75.75 0 1 0 6 3a.75.75 0 0 0 0 1.5Z" fill="white"/>
                            </svg>
                            <span class="alert-priority-label alert-priority-label--low">LOW PRIORITY</span>
                        </div>
                        <div class="alert-title">Optimize Load Schedule</div>
                        <div class="alert-body">Shift Machine C production to 22:00 for off-peak PLN rates.</div>
                    </div>
                </div>
            </div>

            <!-- ══ MACHINE TABLE + ACTIVITY LOG ══ -->
            <div class="bottom-row">

                <!-- Machine Management -->
                <div class="card machine-card">
                    <div class="machine-header">
                        <div class="card-header" style="margin-bottom:0;">
                            <svg width="18" height="14" viewBox="0 0 18 14" fill="none">
                                <path d="M8.44 3.7c.19-.17.27-.44.16-.68L6.6 1.36C6.54 1.22 6.47 1.08 6.4.96L6.31.81A6.56 6.56 0 0 0 5.61.05c-.25-.08-.52 0-.67.19L4.37 1.22a2.18 2.18 0 0 1-1.11.31 2.19 2.19 0 0 1-1.09-.31L2 1.14A1.12 1.12 0 0 0 .14 2.05L0 2.44a3.52 3.52 0 0 0 0 .9l-.62 1.34a.5.5 0 0 0 .19.68l.61.37c-.03.18-.05.37-.05.55s.02.37.05.55l-.62.36a.5.5 0 0 0-.19.68L.5 8.2c.17.29.53.38.83.25l.62-.37c.25.2.52.36.82.47l.17.8a.5.5 0 0 0 .49.37c.18.02.36.03.54.03s.36 0 .54-.02a.5.5 0 0 0 .49-.37l.17-.8c.32-.12.6-.27.83-.47l.62.25c.3.12.66.04.83-.25l.23-.38.16-.27c.07-.13.13-.26.18-.4a.5.5 0 0 0-.19-.68l-.62-.38c.03-.18.05-.37.05-.55s-.02-.37-.05-.55l.63-.37.01-.01ZM3.06 4.81a1.31 1.31 0 1 1 2.63 0 1.31 1.31 0 0 1-2.63 0Zm10.74 8.87c.17.19.44.28.69.18.14-.06.27-.13.4-.19l.15-.09c.13-.08.26-.17.38-.26.21-.16.28-.43.2-.68l-.25-.77a2.51 2.51 0 0 0 .6-1.05l.8-.17a.5.5 0 0 0 .38-.42c.02-.18.03-.36.03-.55 0-.18-.01-.37-.03-.55a.5.5 0 0 0-.38-.42l-.8-.17a2.5 2.5 0 0 0-.6-1.05l.25-.77a.5.5 0 0 0-.2-.68 4.6 4.6 0 0 0-.38-.26l-.15-.09a4.6 4.6 0 0 0-.4-.19.5.5 0 0 0-.68.19l-.54.61a2.5 2.5 0 0 0-1.05-.21 2.5 2.5 0 0 0-1.05.21l-.54-.61a.5.5 0 0 0-.68-.19c-.14.06-.27.13-.4.19l-.14.09c-.14.08-.26.17-.38.26a.5.5 0 0 0-.2.68l.25.77a2.5 2.5 0 0 0-.6 1.05l-.8.16a.5.5 0 0 0-.38.42c-.02.18-.03.36-.03.55 0 .19.01.37.03.55a.5.5 0 0 0 .38.42l.8.17a2.5 2.5 0 0 0 .6 1.05l-.25.77a.5.5 0 0 0 .2.68c.12.09.24.17.38.26l.14.09c.13.07.26.13.4.19a.5.5 0 0 0 .68-.19l.54-.61a2.5 2.5 0 0 0 2.11 0l.54.61-.01.01Zm-2.11-3.5a1.31 1.31 0 1 1 2.63 0 1.31 1.31 0 0 1-2.63 0Z" fill="#3B82F6"/>
                            </svg>
                            <span class="card-title">Industrial Machine Management</span>
                        </div>
                        <div class="filter-tabs">
                            <template x-for="tab in ['All','Active','Standby','Offline']" :key="tab">
                                <button class="filter-tab"
                                        :class="activeFilter === tab ? 'filter-tab--active' : 'filter-tab--inactive'"
                                        @click="activeFilter = tab"
                                        x-text="tab">
                                </button>
                            </template>
                        </div>
                    </div>

                    <table class="machine-mini-table">
                        <thead>
                            <tr>
                                <th>Machine Name</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Power Usage</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="m in filteredMachines()" :key="m.id">
                                <tr>
                                    <td><span class="machine-name-text" x-text="m.name"></span></td>
                                    <td>
                                        <span class="priority-badge" :class="priorityClass(m.priority)" x-text="m.priority"></span>
                                    </td>
                                    <td>
                                        <div class="machine-status-row">
                                            <div class="machine-status-dot"
                                                 :class="m.status === 'Active' ? 'machine-status-dot--active' : m.status === 'Standby' ? 'machine-status-dot--standby' : 'machine-status-dot--offline'">
                                            </div>
                                            <span class="machine-status-text" x-text="m.status"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="machine-power-text" x-text="m.on ? m.power.toFixed(1) + ' kW' : '0.0 kW'"></span>
                                    </td>
                                    <td>
                                        <div class="small-toggle"
                                             @click="toggleMachine(m.id)"
                                             role="switch"
                                             :aria-checked="m.on">
                                            <div class="toggle-track" :class="m.on ? 'toggle-track--on' : ''">
                                                <div class="toggle-thumb" :class="m.on ? 'toggle-thumb--on' : ''"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div class="machine-footer">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M6 12a6 6 0 1 0 0-12A6 6 0 0 0 6 12ZM8.65 4.9L5.65 7.9a.69.69 0 0 1-.97 0L3.35 6.4a.69.69 0 0 1 .97-.97L5.25 6.5l2.6-2.6a.69.69 0 0 1 .97.97l-.17.03Z" fill="#22C55E"/>
                        </svg>
                        <span class="machine-footer-text">
                            Active Load: <strong x-text="activeLoadKw() + ' kW'"></strong> across <strong x-text="activeMachineCount() + ' machines'"></strong>
                        </span>
                        <a class="view-all-link" href="/machines">Manage All →</a>
                    </div>
                </div>

                <!-- System Activity Log -->
                <div class="card activity-card">
                    <div class="card-header" style="margin-bottom:12px;">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M2.05 2.05L1.12 1.12C.71.71 0 1 0 1.58V4.59c0 .36.29.66.66.66H3.67c.58 0 .87-.71.46-1.12L3.29 3.29A5.25 5.25 0 1 1 .39 9.63.88.88 0 1 0-.79 10.72 7 7 0 1 0 2.05 2.05ZM7 3.5a.66.66 0 0 0-.66.66v2.84l1.97 1.97a.66.66 0 0 0 .94-.94L7.66 6.45V4.16A.66.66 0 0 0 7 3.5Z" fill="#3B82F6"/>
                        </svg>
                        <span class="card-title">System Activity Log</span>
                    </div>
                    <div class="activity-entries">
                        <template x-for="entry in activityLog" :key="entry.time + entry.text">
                            <div class="activity-entry">
                                <div class="activity-time" x-text="entry.time"></div>
                                <div class="activity-dot-wrap">
                                    <div class="activity-dot" :class="'activity-dot--' + entry.color"></div>
                                </div>
                                <div class="activity-message" x-text="entry.text"></div>
                            </div>
                        </template>
                    </div>
                    <div class="activity-log-footer">
                        <a class="view-full-log-link" href="#">View Full Log →</a>
                    </div>
                </div>

            </div><!-- /bottom-row -->

        </div><!-- /content-frame -->
    </main>

    <script>
        function dashboardApp() {
            return {
                currentTime: '--:--:--',
                currentDate: '---',

                weather: { temp: 28, cloud: 12 },
                production: 847,
                batteryPct: 78,
                batteryHoursLeft: 4.2,
                currentDraw: 234,
                drawLimit: 285,
                systemStatus: 'All Normal',

                pltsSupply: 284.7,
                batterySupply: 85.0,
                plnSupply: 142.3,
                machineDemand: 387.4,
                idleDemand: 48.6,

                activeFilter: 'All',

                machines: [
                    { id: 1, name: 'Compressor Unit A',    priority: 'HIGH', status: 'Active',  power: 85.4, on: true  },
                    { id: 2, name: 'CNC Milling M-01',     priority: 'HIGH', status: 'Active',  power: 72.1, on: true  },
                    { id: 3, name: 'Conveyor Belt C-03',   priority: 'MED',  status: 'Active',  power: 45.8, on: true  },
                    { id: 4, name: 'Hydraulic Press P-02', priority: 'HIGH', status: 'Standby', power: 0,    on: false },
                    { id: 5, name: 'Cooling Tower CT-1',   priority: 'MED',  status: 'Active',  power: 38.6, on: true  },
                    { id: 6, name: 'Welding Station W-4',  priority: 'LOW',  status: 'Offline', power: 0,    on: false },
                    { id: 7, name: 'Pump Station PS-2',    priority: 'MED',  status: 'Active',  power: 31.2, on: true  },
                    { id: 8, name: 'Lighting Circuit L-1', priority: 'LOW',  status: 'Active',  power: 14.3, on: true  },
                ],

                activityLog: [
                    { time: '14:25', color: 'green', text: 'Battery charged to 73% — auto-save activated' },
                    { time: '14:18', color: 'amber', text: 'PLN load exceeded 55% threshold — alert triggered' },
                    { time: '14:02', color: 'blue',  text: 'Solar output peaked at 298 kW' },
                    { time: '13:47', color: 'red',   text: 'Machine W-4 (Welding Station) went offline' },
                    { time: '13:30', color: 'green', text: 'Load balancing optimization applied successfully' },
                ],

                get totalSupply() { return this.pltsSupply + this.batterySupply + this.plnSupply; },
                get totalDemand() { return this.machineDemand + this.idleDemand; },
                get drawPct()     { return Math.round((this.currentDraw / this.drawLimit) * 100); },
                get surplusKw()   { return (this.totalSupply - this.totalDemand).toFixed(1); },

                supplyPct(val) { return ((val / this.totalSupply) * 100).toFixed(2); },
                demandPct(val) { return ((val / this.totalDemand) * 100).toFixed(2); },

                filteredMachines() {
                    if (this.activeFilter === 'All') return this.machines;
                    return this.machines.filter(m => m.status === this.activeFilter);
                },

                toggleMachine(id) {
                    const m = this.machines.find(m => m.id === id);
                    if (!m) return;
                    m.on = !m.on;
                    m.status = m.on ? 'Active' : 'Offline';
                },

                activeLoadKw() {
                    return this.machines.filter(m => m.on).reduce((s, m) => s + m.power, 0).toFixed(1);
                },

                activeMachineCount() {
                    return this.machines.filter(m => m.on).length;
                },

                priorityClass(p) {
                    return { HIGH: 'badge-high', MED: 'badge-med', LOW: 'badge-low' }[p] ?? 'badge-low';
                },

                init() {
                    this.tickClock();
                    setInterval(() => this.tickClock(), 1000);
                    // init charts after DOM is ready
                    setTimeout(() => {
                        this.initSolarChart();
                        this.initEnergyChart();
                    }, 50);
                },

                tickClock() {
                    const now = new Date();
                    const pad = n => String(n).padStart(2, '0');
                    const days   = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    this.currentTime = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
                    this.currentDate = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getDate()}`;
                },

                initSolarChart() {
                    const ctx = document.getElementById('solarChart');
                    if (!ctx) return;
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['06','07','08','09','10','11','12','13','14','15','16','17','18'],
                            datasets: [{
                                data: [5, 28, 80, 155, 242, 312, 295, 258, 214, 168, 118, 65, 18],
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245,158,11,0.15)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 2.5,
                                pointRadius: 0,
                                pointHoverRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1E293B',
                                    borderColor: '#334155',
                                    borderWidth: 1,
                                    titleColor: '#94A3B8',
                                    bodyColor: '#F59E0B',
                                    callbacks: {
                                        label: ctx => ctx.parsed.y + ' kW'
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: '#1E293B' },
                                    ticks: { color: '#475569', font: { size: 9, family: 'Inter' } },
                                    border: { color: '#475569' }
                                },
                                y: {
                                    grid: { color: 'rgba(51,65,85,0.5)' },
                                    ticks: { color: '#475569', font: { size: 9, family: 'Inter' }, maxTicksLimit: 5 },
                                    min: 0, max: 350,
                                    border: { color: '#475569' }
                                }
                            }
                        }
                    });
                },

                initEnergyChart() {
                    const ctx = document.getElementById('energyChart');
                    if (!ctx) return;
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['02','03','04','05','06','07','08','09','10','11','12','13','14'],
                            datasets: [
                                {
                                    label: 'Supply',
                                    data: [380, 372, 365, 355, 325, 295, 275, 265, 258, 263, 268, 272, 278],
                                    borderColor: '#22C55E',
                                    tension: 0.4, borderWidth: 1.5, pointRadius: 0, pointHoverRadius: 3,
                                },
                                {
                                    label: 'Demand',
                                    data: [392, 382, 378, 368, 342, 324, 314, 304, 298, 303, 308, 313, 318],
                                    borderColor: '#F97316',
                                    tension: 0.4, borderWidth: 1.5, pointRadius: 0, pointHoverRadius: 3,
                                },
                                {
                                    label: 'Battery',
                                    data: [342, 340, 337, 332, 332, 336, 340, 342, 342, 340, 338, 336, 335],
                                    borderColor: '#3B82F6',
                                    borderDash: [3, 3],
                                    tension: 0.4, borderWidth: 1.5, pointRadius: 0, pointHoverRadius: 3,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#1E293B',
                                    borderColor: '#334155',
                                    borderWidth: 1,
                                    titleColor: '#94A3B8',
                                    bodyColor: '#E2E8F0',
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: '#1E293B' },
                                    ticks: { color: '#475569', font: { size: 8, family: 'Inter' } },
                                    border: { color: '#475569' }
                                },
                                y: {
                                    grid: { color: 'rgba(51,65,85,0.5)' },
                                    ticks: { color: '#475569', font: { size: 8, family: 'Inter' }, maxTicksLimit: 5 },
                                    min: 0, max: 600,
                                    border: { color: '#475569' }
                                }
                            }
                        }
                    });
                },
            };
        }
    </script>
</body>
</html>
