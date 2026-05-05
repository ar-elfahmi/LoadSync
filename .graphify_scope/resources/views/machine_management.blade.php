<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoadSync — Machine Management</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">
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

        .brand-logo {
            height: 48px;
            width: auto;
        }

        .navbar-controls {
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

        .weather-sep {
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

        /* ── MAIN ── */
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

        .add-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 48px;
            padding: 0 24px;
            border-radius: 8px;
            background: #3B82F6;
            border: none;
            color: #FFF;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            font-family: 'Inter', sans-serif;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .add-btn:hover { background: #2563EB; }
        .add-btn:active { transform: scale(0.98); }

        /* ── CONTROL BAR ── */
        .control-bar {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            box-shadow: 0 4px 6px -4px rgba(0,0,0,.1), 0 10px 15px -3px rgba(0,0,0,.1);
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .control-bar-left {
            display: flex;
            align-items: center;
            gap: 32px;
            flex-wrap: wrap;
        }

        .control-label {
            font-size: 14px;
            font-weight: 500;
            color: #CBD5E1;
        }

        .inline-control {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Big Toggle (Auto Approve System) */
        .big-toggle {
            position: relative;
            width: 48px;
            height: 24px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .big-toggle-track {
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: #334155;
            transition: background 0.25s;
        }

        .big-toggle-track.is-green { background: #22C55E; }

        .big-toggle-thumb {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #FFF;
            transition: transform 0.25s;
        }

        .big-toggle-thumb.is-on { transform: translateX(24px); }

        /* Mode Buttons */
        .mode-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mode-pills {
            display: flex;
            gap: 4px;
        }

        .mode-pill {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            background: #0F172A;
            color: #94A3B8;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .mode-pill.is-active { background: #3B82F6; color: #FFF; }
        .mode-pill:hover:not(.is-active) { background: rgba(59,130,246,0.12); color: #CBD5E1; }

        /* Stats */
        .stats-cluster {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-shrink: 0;
        }

        .stat-block { text-align: left; }
        .stat-lbl { font-size: 14px; font-weight: 400; color: #94A3B8; }

        .stat-num {
            font-size: 28px;
            font-weight: 700;
            color: #E2E8F0;
            line-height: 36px;
        }

        .stat-num.is-active-count { color: #22C55E; }
        .stat-num.is-energy { font-size: 22px; }

        .energy-unit {
            font-size: 14px;
            font-weight: 400;
            color: #94A3B8;
            margin-left: 2px;
        }

        .stat-vline {
            width: 1px;
            height: 40px;
            background: #334155;
        }

        /* ── MACHINE TABLE ── */
        .table-card {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            overflow: hidden;
        }

        .machine-table {
            width: 100%;
            border-collapse: collapse;
        }

        .machine-table thead tr { border-bottom: 1px solid #334155; }

        .machine-table th {
            padding: 16px 24px;
            text-align: left;
            font-size: 14px;
            font-weight: 500;
            color: #94A3B8;
            white-space: nowrap;
        }

        .machine-table tbody tr {
            border-top: 1px solid #334155;
            transition: background 0.15s;
        }

        .machine-table tbody tr:hover { background: rgba(51,65,85,0.3); }

        .machine-table td {
            padding: 0 24px;
            height: 65px;
            vertical-align: middle;
        }

        .cell-name {
            font-size: 16px;
            font-weight: 600;
            color: #FFF;
        }

        .cell-power {
            font-family: 'Roboto Mono', monospace;
            font-size: 16px;
            font-weight: 700;
            color: #FFF;
        }

        .power-unit {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 400;
            color: #94A3B8;
            margin-left: 2px;
        }

        /* Priority Badge */
        .priority-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 26px;
            padding: 0 13px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .badge-high { border: 1px solid #EF4444; background: rgba(239,68,68,0.2); color: #EF4444; }
        .badge-med  { border: 1px solid #F59E0B; background: rgba(245,158,11,0.2); color: #F59E0B; }
        .badge-low  { border: 1px solid #3B82F6; background: rgba(59,130,246,0.2); color: #3B82F6; }

        /* Status Dot */
        .status-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-active   { background: #22C55E; opacity: 0.9; }
        .dot-inactive { background: #94A3B8; }

        .status-text {
            font-size: 14px;
            font-weight: 500;
            color: #CBD5E1;
        }

        /* Small Toggle (table rows) */
        .small-toggle {
            position: relative;
            width: 36px;
            height: 20px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .small-toggle-track {
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: #334155;
            transition: background 0.25s;
        }

        .small-toggle-track.is-green { background: #22C55E; }
        .small-toggle-track.is-blue  { background: #3B82F6; }

        .small-toggle-thumb {
            position: absolute;
            top: 3px;
            left: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #FFF;
            transition: transform 0.25s;
        }

        .small-toggle-thumb.is-on { transform: translateX(14px); }

        /* Action Buttons */
        .action-cell { display: flex; gap: 8px; }

        .icon-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #0F172A;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .icon-btn:hover { background: #1E3A5F; }
        .icon-btn.is-delete:hover { background: rgba(239,68,68,0.18); }

        .empty-row td {
            text-align: center;
            padding: 48px;
            color: #94A3B8;
            font-size: 15px;
        }

        /* ── DRAWER OVERLAY ── */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 200;
        }

        /* ── SIDE DRAWER ── */
        .side-drawer {
            position: fixed;
            top: 0; right: 0; bottom: 0;
            width: 420px;
            background: #1E293B;
            border-left: 1px solid #334155;
            z-index: 201;
            padding: 32px;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .drawer-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .drawer-title {
            font-size: 20px;
            font-weight: 700;
            color: #FFF;
        }

        .close-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #0F172A;
            border: none;
            cursor: pointer;
            color: #94A3B8;
            font-size: 18px;
            line-height: 1;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .close-btn:hover { background: #334155; }

        /* Form */
        .form-field { margin-bottom: 20px; }

        .field-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #CBD5E1;
            margin-bottom: 8px;
        }

        .field-input, .field-select {
            width: 100%;
            height: 44px;
            padding: 0 16px;
            background: #0F172A;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #E2E8F0;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .field-input:focus, .field-select:focus { border-color: #3B82F6; }

        .field-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%2394A3B8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .field-select option { background: #1E293B; }

        .toggle-field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid rgba(51,65,85,0.5);
        }

        .toggle-field-label {
            font-size: 14px;
            font-weight: 500;
            color: #CBD5E1;
        }

        .drawer-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn-save {
            flex: 1;
            height: 44px;
            border-radius: 8px;
            background: #3B82F6;
            border: none;
            color: #FFF;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-save:hover { background: #2563EB; }

        .btn-cancel {
            flex: 1;
            height: 44px;
            border-radius: 8px;
            background: #0F172A;
            border: 1px solid #334155;
            color: #94A3B8;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-cancel:hover { background: #334155; color: #CBD5E1; }

        /* ── DELETE MODAL ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.65);
            z-index: 300;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-modal {
            background: #1E293B;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 32px;
            width: 400px;
            max-width: 90vw;
        }

        .modal-danger-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(239,68,68,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #FFF;
            margin-bottom: 8px;
        }

        .modal-body {
            font-size: 14px;
            color: #94A3B8;
            line-height: 20px;
            margin-bottom: 24px;
        }

        .machine-name-highlight { color: #E2E8F0; font-weight: 500; }

        .modal-actions { display: flex; gap: 12px; }

        .btn-danger {
            flex: 1;
            height: 44px;
            border-radius: 8px;
            background: #EF4444;
            border: none;
            color: #FFF;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.2s;
        }

        .btn-danger:hover { background: #DC2626; }
    </style>
</head>
<body x-data="machineManager()" x-init="init()">

    <!-- ── NAVBAR ── -->
    <nav class="navbar">
        <img class="brand-logo"
             src="https://api.builder.io/api/v1/image/assets/TEMP/65cf4edde248f5ead840168b1dbb51718479d60b?width=192"
             alt="LoadSync">

        <div class="navbar-controls">
            <div class="weather-pill">
                <div class="weather-stat">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <g clip-path="url(#sun)">
                            <path d="M5.33 8a2.67 2.67 0 1 0 5.33 0 2.67 2.67 0 0 0-5.33 0Z" stroke="#FBBF24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 1.33V2.66M8 13.33v1.33M3.29 3.29l.94.94M11.77 11.77l.94.94M1.33 8h1.33M13.33 8h1.33M4.23 11.77l-.94.94M12.71 3.29l-.94.94" stroke="#FBBF24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs><clipPath id="sun"><rect width="16" height="16"/></clipPath></defs>
                    </svg>
                    <span>28°C</span>
                </div>
                <div class="weather-sep"></div>
                <div class="weather-stat">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <g clip-path="url(#cloud)">
                            <path d="M2.28 9.93A4 4 0 0 1 6.11 2c2.02.14 3.74 1.46 4.32 3.33h1.25A2.67 2.67 0 0 1 13.41 10.83" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.67 9.33v4M5.34 9.33v4M8 10.67v4" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs><clipPath id="cloud"><rect width="16" height="16"/></clipPath></defs>
                    </svg>
                    <span>12% Cloud</span>
                </div>
            </div>

            <div class="clock-block">
                <div class="clock-time" x-text="currentTime">--:--:--</div>
                <div class="clock-date" x-text="currentDate">---</div>
            </div>

            <button class="bell-btn" aria-label="Notifications">
                <svg width="24" height="24" viewBox="0 0 29 29" fill="none">
                    <path d="M12.41 25.38a4 4 0 0 0 4.19 0" stroke="#94A3B8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.84 18.51C3.51 18.86 3.43 19.37 3.63 19.81c.19.44.63.72 1.11.72h19.52c.48 0 .92-.28 1.12-.72.19-.44.11-.95-.19-1.3C23.54 16.85 21.82 15.09 21.82 9.66c0-4-3.28-7.25-7.32-7.25-4.04 0-7.32 3.25-7.32 7.25 0 5.43-1.72 7.19-3.34 8.85Z" stroke="#94A3B8" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="bell-dot"></div>
            </button>
        </div>
    </nav>

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar">
        <a class="nav-icon-btn" href="/dashboard" title="Dashboard">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M3.91 14.02a2 2 0 0 1-.93-1.57c-.17-.35.88-2.29 1.13-2.06L13.13 2.11a.5.5 0 0 1 .75.46l-1.94 6.06c-.11.31-.07.66.12.93.19.27.51.43.84.43H20.08a1 1 0 0 1 .92 1.39L10.86 21.9a.5.5 0 0 1-.83-.46l1.94-6.06c.12-.31.07-.66-.12-.93a1.07 1.07 0 0 0-.84-.43H3.91Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn is-active" href="#" title="Machine Management">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="7" height="7" rx="1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="14" y="3" width="7" height="7" rx="1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="14" y="14" width="7" height="7" rx="1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="3" y="14" width="7" height="7" rx="1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="/energy_simulation" title="Simulation">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14.06 2v6c0 .34.09.66.25.96L20 19.04A2 2 0 0 1 18.19 22H5.81A2 2 0 0 1 4 19.04L9.68 8.96A2 2 0 0 0 9.94 8V2" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.45 15h11.09M8.5 2h7" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <a class="nav-icon-btn" href="#" title="Settings">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.23 2h-.46a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.44.25a2 2 0 0 1-2 0l-.16-.08a2 2 0 0 0-2.73.73l-.23.38a2 2 0 0 0 .73 2.73l.15.09a2 2 0 0 1 1 1.73v.5a2 2 0 0 1-1 1.73l-.15.09a2 2 0 0 0-.73 2.73l.23.38a2 2 0 0 0 2.73.73l.16-.08a2 2 0 0 1 2 0l.44.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.46a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.44-.25a2 2 0 0 1 2 0l.16.08a2 2 0 0 0 2.73-.73l.23-.38a2 2 0 0 0-.73-2.73l-.15-.09A2 2 0 0 1 19.08 12.25v-.5a2 2 0 0 1 1-1.73l.15-.09a2 2 0 0 0 .73-2.73l-.23-.38a2 2 0 0 0-2.73-.73l-.16.08a2 2 0 0 1-2 0l-.44-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </aside>

    <!-- ── MAIN CONTENT ── -->
    <main class="page-wrapper">
        <div class="page-outer-frame">

            <!-- Page Header -->
            <div class="page-head">
                <div>
                    <h1 class="page-title">Machine Management</h1>
                    <p class="page-subtitle">Manage machines, settings, and auto-approve configurations</p>
                </div>
                <button class="add-btn" @click="openAddDrawer()">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M4.16 10h11.67M10 4.17v11.67" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Add Machine
                </button>
            </div>

            <!-- Control Bar -->
            <div class="control-bar">
                <div class="control-bar-left">
                    <!-- Auto Approve Toggle -->
                    <div class="inline-control">
                        <span class="control-label">Auto Approve System</span>
                        <div class="big-toggle" @click="autoApprove = !autoApprove" role="switch" :aria-checked="autoApprove">
                            <div class="big-toggle-track" :class="autoApprove ? 'is-green' : ''">
                                <div class="big-toggle-thumb" :class="autoApprove ? 'is-on' : ''"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Mode Selector -->
                    <div class="mode-group">
                        <span class="control-label">Mode:</span>
                        <div class="mode-pills">
                            <button class="mode-pill" :class="activeMode === 'Manual' ? 'is-active' : ''" @click="activeMode = 'Manual'">Manual</button>
                            <button class="mode-pill" :class="activeMode === 'Semi-Auto' ? 'is-active' : ''" @click="activeMode = 'Semi-Auto'">Semi-Auto</button>
                            <button class="mode-pill" :class="activeMode === 'Full Auto' ? 'is-active' : ''" @click="activeMode = 'Full Auto'">Full Auto</button>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="stats-cluster">
                    <div class="stat-block">
                        <div class="stat-lbl">Total Machines</div>
                        <div class="stat-num" x-text="machines.length"></div>
                    </div>
                    <div class="stat-vline"></div>
                    <div class="stat-block">
                        <div class="stat-lbl">Active</div>
                        <div class="stat-num is-active-count" x-text="activeCount()"></div>
                    </div>
                    <div class="stat-vline"></div>
                    <div class="stat-block">
                        <div class="stat-lbl">Total Energy</div>
                        <div class="stat-num is-energy">
                            <span x-text="totalEnergy()"></span><span class="energy-unit">kW</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Machine Table -->
            <div class="table-card">
                <table class="machine-table">
                    <thead>
                        <tr>
                            <th>Machine Name</th>
                            <th>Power Usage</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Power Status</th>
                            <th>Auto-Approve</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="machines.length === 0">
                            <tr class="empty-row">
                                <td colspan="7">No machines found. Click "+ Add Machine" to get started.</td>
                            </tr>
                        </template>
                        <template x-for="machine in machines" :key="machine.id">
                            <tr>
                                <!-- Name -->
                                <td><span class="cell-name" x-text="machine.name"></span></td>

                                <!-- Power Usage -->
                                <td>
                                    <span class="cell-power" x-text="machine.powerOn ? machine.power.toFixed(1) : '0.0'"></span>
                                    <span class="power-unit">kWh</span>
                                </td>

                                <!-- Priority -->
                                <td>
                                    <span class="priority-badge"
                                          :class="priorityBadgeClass(machine.priority)"
                                          x-text="machine.priority">
                                    </span>
                                </td>

                                <!-- Status -->
                                <td>
                                    <div class="status-row">
                                        <div class="status-dot" :class="machine.powerOn ? 'dot-active' : 'dot-inactive'"></div>
                                        <span class="status-text" x-text="machine.powerOn ? 'Active' : 'Inactive'"></span>
                                    </div>
                                </td>

                                <!-- Power Status Toggle -->
                                <td>
                                    <div class="small-toggle"
                                         @click="togglePower(machine.id)"
                                         role="switch"
                                         :aria-checked="machine.powerOn">
                                        <div class="small-toggle-track" :class="machine.powerOn ? 'is-green' : ''">
                                            <div class="small-toggle-thumb" :class="machine.powerOn ? 'is-on' : ''"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Auto-Approve Toggle -->
                                <td>
                                    <div class="small-toggle"
                                         @click="toggleAutoApprove(machine.id)"
                                         role="switch"
                                         :aria-checked="machine.autoApprove">
                                        <div class="small-toggle-track" :class="machine.autoApprove ? 'is-blue' : ''">
                                            <div class="small-toggle-thumb" :class="machine.autoApprove ? 'is-on' : ''"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="action-cell">
                                        <button class="icon-btn" @click="openEditDrawer(machine)" title="Edit machine">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8 2H3.33A1.33 1.33 0 0 0 2 3.33v9.33A1.33 1.33 0 0 0 3.33 14h9.33A1.33 1.33 0 0 0 14 12.67V8" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.56 1.34a1.33 1.33 0 0 1 1.88 1.88L8.37 9.73 5.77 10.67l.92-2.6 5.87-6.73Z" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <button class="icon-btn is-delete" @click="promptDelete(machine.id)" title="Delete machine">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M2 4h12" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.66 4v9.34A1.33 1.33 0 0 1 11.33 14.67H4.66A1.33 1.33 0 0 1 3.33 13.34V4" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5.33 4V2.67A1.33 1.33 0 0 1 6.66 1.33h2.67A1.33 1.33 0 0 1 10.66 2.67V4" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

        </div><!-- /page-outer-frame -->
    </main>

    <!-- ── DRAWER OVERLAY ── -->
    <div class="overlay"
         x-show="drawerOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeDrawer()"
         style="display:none;">
    </div>

    <!-- ── SIDE DRAWER ── -->
    <div class="side-drawer"
         x-show="drawerOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform translate-x-full"
         style="display:none;">

        <div class="drawer-head">
            <h2 class="drawer-title" x-text="editMode ? 'Edit Machine' : 'Add Machine'"></h2>
            <button class="close-btn" @click="closeDrawer()">&#x2715;</button>
        </div>

        <div class="form-field">
            <label class="field-label">Machine Name</label>
            <input class="field-input" type="text" x-model="form.name" placeholder="e.g. CNC Machine A1">
        </div>

        <div class="form-field">
            <label class="field-label">Power Usage (kWh)</label>
            <input class="field-input" type="number" x-model="form.power" placeholder="0.0" min="0" step="0.1">
        </div>

        <div class="form-field">
            <label class="field-label">Priority</label>
            <select class="field-select" x-model="form.priority">
                <option value="High">High</option>
                <option value="Med">Medium</option>
                <option value="Low">Low</option>
            </select>
        </div>

        <div class="toggle-field-row">
            <span class="toggle-field-label">Power Status (Active)</span>
            <div class="small-toggle" @click="form.powerOn = !form.powerOn" role="switch" :aria-checked="form.powerOn">
                <div class="small-toggle-track" :class="form.powerOn ? 'is-green' : ''">
                    <div class="small-toggle-thumb" :class="form.powerOn ? 'is-on' : ''"></div>
                </div>
            </div>
        </div>

        <div class="toggle-field-row">
            <span class="toggle-field-label">Auto-Approve</span>
            <div class="small-toggle" @click="form.autoApprove = !form.autoApprove" role="switch" :aria-checked="form.autoApprove">
                <div class="small-toggle-track" :class="form.autoApprove ? 'is-blue' : ''">
                    <div class="small-toggle-thumb" :class="form.autoApprove ? 'is-on' : ''"></div>
                </div>
            </div>
        </div>

        <div class="drawer-actions">
            <button class="btn-cancel" @click="closeDrawer()">Cancel</button>
            <button class="btn-save" @click="saveMachine()">
                <span x-text="editMode ? 'Save Changes' : 'Add Machine'"></span>
            </button>
        </div>
    </div>

    <!-- ── DELETE CONFIRM MODAL ── -->
    <div class="modal-overlay"
         x-show="deleteModal.open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display:none;">
        <div class="delete-modal" @click.stop>
            <div class="modal-danger-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M10 9v4M10 15h.01M8.11 3.21L1.4 15a2 2 0 0 0 1.75 3h13.71a2 2 0 0 0 1.75-3L11.9 3.21a2 2 0 0 0-3.79 0Z" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="modal-title">Delete Machine</h3>
            <p class="modal-body">
                Are you sure you want to remove
                <span class="machine-name-highlight" x-text="deleteModal.machineName"></span>?
                This action cannot be undone.
            </p>
            <div class="modal-actions">
                <button class="btn-cancel" @click="deleteModal.open = false">Cancel</button>
                <button class="btn-danger" @click="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <script>
        function machineManager() {
            return {
                currentTime: '--:--:--',
                currentDate: '---',

                autoApprove: true,
                activeMode: 'Semi-Auto',

                machines: [
                    { id: 1, name: 'CNC Machine A1',    power: 45.2, priority: 'High', powerOn: true,  autoApprove: true  },
                    { id: 2, name: 'Conveyor Belt B2',  power: 12.8, priority: 'Med',  powerOn: true,  autoApprove: false },
                    { id: 3, name: 'Compressor C1',     power: 0.0,  priority: 'High', powerOn: false, autoApprove: true  },
                    { id: 4, name: 'Welding Unit D3',   power: 28.5, priority: 'Low',  powerOn: true,  autoApprove: false },
                    { id: 5, name: 'Cooling System E1', power: 65.0, priority: 'High', powerOn: true,  autoApprove: true  },
                    { id: 6, name: 'Packaging Line F2', power: 0.0,  priority: 'Med',  powerOn: false, autoApprove: false },
                ],

                nextId: 7,

                drawerOpen: false,
                editMode: false,
                editingId: null,
                form: { name: '', power: '', priority: 'High', powerOn: true, autoApprove: false },

                deleteModal: { open: false, targetId: null, machineName: '' },

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

                activeCount() {
                    return this.machines.filter(m => m.powerOn).length;
                },

                totalEnergy() {
                    return this.machines
                        .filter(m => m.powerOn)
                        .reduce((sum, m) => sum + m.power, 0)
                        .toFixed(1);
                },

                priorityBadgeClass(priority) {
                    return { High: 'badge-high', Med: 'badge-med', Low: 'badge-low' }[priority] ?? 'badge-low';
                },

                togglePower(id) {
                    const m = this.machines.find(m => m.id === id);
                    if (m) m.powerOn = !m.powerOn;
                },

                toggleAutoApprove(id) {
                    const m = this.machines.find(m => m.id === id);
                    if (m) m.autoApprove = !m.autoApprove;
                },

                openAddDrawer() {
                    this.editMode  = false;
                    this.editingId = null;
                    this.form = { name: '', power: '', priority: 'High', powerOn: true, autoApprove: false };
                    this.drawerOpen = true;
                },

                openEditDrawer(machine) {
                    this.editMode  = true;
                    this.editingId = machine.id;
                    this.form = { ...machine };
                    this.drawerOpen = true;
                },

                saveMachine() {
                    const name = (this.form.name ?? '').trim();
                    if (!name) return;

                    const power = parseFloat(this.form.power) || 0;

                    if (this.editMode) {
                        const idx = this.machines.findIndex(m => m.id === this.editingId);
                        if (idx !== -1) {
                            this.machines[idx] = {
                                id:          this.editingId,
                                name:        name,
                                power:       power,
                                priority:    this.form.priority,
                                powerOn:     this.form.powerOn,
                                autoApprove: this.form.autoApprove,
                            };
                        }
                    } else {
                        this.machines.push({
                            id:          this.nextId++,
                            name:        name,
                            power:       power,
                            priority:    this.form.priority,
                            powerOn:     this.form.powerOn,
                            autoApprove: this.form.autoApprove,
                        });
                    }

                    this.closeDrawer();
                },

                closeDrawer() {
                    this.drawerOpen = false;
                },

                promptDelete(id) {
                    const m = this.machines.find(m => m.id === id);
                    if (!m) return;
                    this.deleteModal = { open: true, targetId: id, machineName: m.name };
                },

                confirmDelete() {
                    this.machines = this.machines.filter(m => m.id !== this.deleteModal.targetId);
                    this.deleteModal.open = false;
                },
            };
        }
    </script>
</body>
</html>
