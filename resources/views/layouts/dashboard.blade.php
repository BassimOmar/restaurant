<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') — La Maison</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --sidebar-w: 240px;
            --gold: #c9a84c;
            --dark: #111827;
            --darker: #0d1117;
            --card-bg: #1a2332;
            --card-border: rgba(255,255,255,0.06);
            --text: #e2e8f0;
            --text-muted: #6b7a8d;
            --success: #34d399;
            --danger: #f87171;
            --warning: #fbbf24;
            --info: #60a5fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--darker);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            font-size: 0.9rem;
        }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--dark);
            border-right: 1px solid var(--card-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 28px 24px;
            border-bottom: 1px solid var(--card-border);
        }
        .sidebar-logo h1 {
            font-size: 1.1rem;
            color: var(--gold);
            letter-spacing: 2px;
            font-weight: 600;
        }
        .sidebar-logo span {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 2px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .sidebar-nav a:hover { background: rgba(255,255,255,0.05); color: var(--text); }
        .sidebar-nav a.active { background: rgba(201,168,76,0.1); color: var(--gold); }
        .sidebar-nav .nav-icon { width: 18px; opacity: 0.7; }
        .sidebar-nav .nav-section {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 16px 14px 6px;
        }

        .sidebar-bottom {
            padding: 16px 12px;
            border-top: 1px solid var(--card-border);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px;
            border-radius: 6px;
        }
        .sidebar-user .avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--gold);
            color: #1a1a1a;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.85rem;
        }
        .sidebar-user .user-info { flex: 1; min-width: 0; }
        .sidebar-user .user-name { font-size: 0.82rem; font-weight: 500; color: var(--text); }
        .sidebar-user .user-role {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: capitalize;
        }
        .sidebar-user .logout-link {
            color: var(--text-muted); font-size: 0.75rem; text-decoration: none;
            transition: color 0.2s;
        }
        .sidebar-user .logout-link:hover { color: var(--danger); }

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            padding: 18px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--card-border);
            background: var(--dark);
        }
        .topbar h2 { font-size: 1.15rem; font-weight: 600; color: var(--text); }
        .topbar .breadcrumb { font-size: 0.78rem; color: var(--text-muted); }
        .topbar .breadcrumb a { color: var(--text-muted); text-decoration: none; }
        .topbar .breadcrumb a:hover { color: var(--gold); }

        .content { padding: 28px 32px; flex: 1; }

        .flash {
            padding: 12px 18px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
        .flash.success { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25); color: var(--success); }
        .flash.error { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.25); color: var(--danger); }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            padding: 22px;
        }
        .stat-card .stat-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; }
        .stat-card .stat-value { font-size: 1.7rem; font-weight: 600; color: var(--text); }
        .stat-card .stat-value.gold { color: var(--gold); }
        .stat-card .stat-value.success { color: var(--success); }
        .stat-card .stat-value.danger { color: var(--danger); }

        .table-wrap {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            overflow: hidden;
        }
        .table-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 18px 22px;
            border-bottom: 1px solid var(--card-border);
        }
        .table-header h3 { font-size: 0.95rem; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            padding: 12px 22px;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--card-border);
            font-weight: 500;
        }
        td {
            padding: 14px 22px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            font-size: 0.85rem;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.02); }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        .badge.owner { background: rgba(201,168,76,0.15); color: var(--gold); }
        .badge.supervisor { background: rgba(96,165,250,0.15); color: var(--info); }
        .badge.waiter { background: rgba(52,211,153,0.15); color: var(--success); }
        .badge.available { background: rgba(52,211,153,0.15); color: var(--success); }
        .badge.occupied { background: rgba(248,113,113,0.15); color: var(--danger); }
        .badge.reserved { background: rgba(251,191,36,0.15); color: var(--warning); }
        .badge.pending { background: rgba(251,191,36,0.15); color: var(--warning); }
        .badge.in_progress { background: rgba(96,165,250,0.15); color: var(--info); }
        .badge.completed { background: rgba(52,211,153,0.15); color: var(--success); }
        .badge.cancelled { background: rgba(248,113,113,0.15); color: var(--danger); }
        .badge.confirmed { background: rgba(52,211,153,0.15); color: var(--success); }
        .badge.no_show { background: rgba(248,113,113,0.15); color: var(--danger); }
        .badge.vip { background: rgba(201,168,76,0.2); color: var(--gold); }
        .badge.low { background: rgba(248,113,113,0.15); color: var(--danger); }
        .badge.ok { background: rgba(52,211,153,0.15); color: var(--success); }
        .badge.active { background: rgba(52,211,153,0.15); color: var(--success); }
        .badge.inactive { background: rgba(248,113,113,0.15); color: var(--danger); }

        .btn {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: opacity 0.2s;
            letter-spacing: 0.5px;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: var(--gold); color: #1a1a1a; }
        .btn-sm { padding: 5px 12px; font-size: 0.75rem; }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text);
        }
        .btn-outline:hover { border-color: var(--gold); color: var(--gold); }
        .btn-danger { background: rgba(248,113,113,0.15); color: var(--danger); border: 1px solid rgba(248,113,113,0.2); }
        .btn-success { background: rgba(52,211,153,0.15); color: var(--success); border: 1px solid rgba(52,211,153,0.2); }
        .btn-info { background: rgba(96,165,250,0.15); color: var(--info); border: 1px solid rgba(96,165,250,0.2); }

        .btn-group { display: flex; gap: 6px; flex-wrap: wrap; }

        /* FORM (dashboard) */
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            padding: 28px;
            max-width: 600px;
        }
        .form-card h3 { margin-bottom: 22px; font-size: 1rem; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.8px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--card-border);
            border-radius: 5px;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--gold); }
        .form-group select option { background: var(--dark); }
        .form-group .checkbox-row { display: flex; align-items: center; gap: 8px; }
        .form-group .checkbox-row input[type="checkbox"] { width: auto; accent-color: var(--gold); }
        .form-actions { display: flex; gap: 10px; margin-top: 24px; }
        .error-bag { color: var(--danger); font-size: 0.77rem; margin-top: 5px; }

        .pagination { display: flex; justify-content: center; gap: 4px; margin-top: 20px; }
        .pagination a, .pagination span {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-decoration: none;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
        }
        .pagination a:hover { border-color: var(--gold); color: var(--gold); }
        .pagination span.current { background: var(--gold); color: #1a1a1a; border-color: var(--gold); }

        @yield('styles')
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <h1>Restaurant</h1>
        <span>{{ auth()->user()->role }} panel</span>
    </div>

    <nav class="sidebar-nav">
        @if(auth()->user()->isOwner())
            <div class="nav-section">Overview</div>
            <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Dashboard
            </a>

            <div class="nav-section">Management</div>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Users
            </a>
            <a href="{{ route('admin.tables.index') }}" class="{{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                <span class="nav-icon">🪑</span> Tables
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <span class="nav-icon">📅</span> Bookings
            </a>
            <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <span class="nav-icon">🤝</span> CRM
            </a>
            <a href="{{ route('admin.discounts.index') }}" class="{{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                <span class="nav-icon">🏷️</span> Discounts
            </a>
            <a href="{{ route('admin.logs.index') }}" class="{{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                <span class="nav-icon">📋</span> Activity Logs
            </a>
        @endif

        @if(auth()->user()->isSupervisor() || auth()->user()->isOwner())
            <div class="nav-section">Supervisor</div>
            <a href="{{ route('supervisor.index') }}" class="{{ request()->routeIs('supervisor.index') ? 'active' : '' }}">
                <span class="nav-icon">📦</span> Overview
            </a>
            <a href="{{ route('supervisor.inventory.index') }}" class="{{ request()->routeIs('supervisor.inventory.*') ? 'active' : '' }}">
                <span class="nav-icon">🥕</span> Inventory
            </a>
            <a href="{{ route('supervisor.menu_categories.index') }}" class="{{ request()->routeIs('supervisor.menu_categories.*') ? 'active' : '' }}">
                <span class="nav-icon">📂</span> Categories
            </a>
            <a href="{{ route('supervisor.menu_items.index') }}" class="{{ request()->routeIs('supervisor.menu_items.*') ? 'active' : '' }}">
                <span class="nav-icon">🍽️</span> Menu Items
            </a>
        @endif

        <div class="nav-section">Orders</div>
        <a href="{{ route('waiter.index') }}" class="{{ request()->routeIs('waiter.index') ? 'active' : '' }}">
            <span class="nav-icon">🍴</span> My Orders
        </a>
        <a href="{{ route('waiter.orders.create') }}" class="">
            <span class="nav-icon">➕</span> New Order
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-link">Out</button>
            </form>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="main">
    <div class="topbar">
        <div>
            <h2>@yield('page_title', 'Dashboard')</h2>
            <div class="breadcrumb">@yield('breadcrumb')</div>
        </div>
        <div>@yield('topbar_actions')</div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="flash success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash error">✕ {{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="flash error">
                ✕ {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
</html>