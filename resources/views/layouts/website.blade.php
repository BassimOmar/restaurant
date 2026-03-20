{{-- resources/views/layouts/website.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Restaurant')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold: #c9a84c;
            --gold-light: #e2c98a;
            --dark: #1a1a1a;
            --darker: #0f0f0f;
            --cream: #f5f0e8;
            --text-light: #999;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--darker);
            color: #fff;
            min-height: 100vh;
        }

        /* NAV */
        nav {
            position: fixed; top: 0; width: 100%; z-index: 100;
            padding: 20px 60px;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(15,15,15,0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(201,168,76,0.15);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--gold);
            text-decoration: none;
            letter-spacing: 2px;
        }

        .nav-links { display: flex; gap: 35px; list-style: none; }
        .nav-links a {
            color: #ccc;
            text-decoration: none;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: var(--gold); }

        /* FLASH */
        .flash {
            position: fixed; top: 80px; right: 30px; z-index: 200;
            padding: 16px 24px; border-radius: 8px;
            font-size: 0.9rem; max-width: 380px;
            animation: slideIn 0.3s ease;
        }
        .flash.success { background: #1e3a2f; border-left: 3px solid #4caf7a; color: #a8f0c8; }
        .flash.error { background: #3a1e1e; border-left: 3px solid #f04c4c; color: #f0a8a8; }
        @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* SECTIONS */
        section { padding: 100px 60px; }

        .section-label {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: var(--gold);
            font-size: 0.75rem;
            margin-bottom: 12px;
        }

        .section-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: #fff;
            margin-bottom: 50px;
        }

        /* BUTTONS */
        .btn-gold {
            display: inline-block;
            padding: 14px 36px;
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
            border-radius: 2px;
            transition: all 0.3s;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-gold:hover { background: var(--gold); color: #1a1a1a; }

        .btn-gold-filled {
            background: var(--gold);
            color: #1a1a1a;
        }
        .btn-gold-filled:hover { background: var(--gold-light); }

        /* CARDS */
        .card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 4px;
            padding: 30px;
            transition: border-color 0.3s;
        }
        .card:hover { border-color: rgba(201,168,76,0.3); }

        /* DIVIDER */
        .divider {
            width: 50px; height: 1px;
            background: var(--gold);
            margin: 0 auto 40px;
        }

        /* FOOTER */
        footer {
            background: var(--darker);
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 60px;
            text-align: center;
            color: var(--text-light);
            font-size: 0.85rem;
        }
        footer .footer-links { margin-bottom: 20px; display: flex; justify-content: center; gap: 30px; }
        footer .footer-links a { color: var(--text-light); text-decoration: none; transition: color 0.3s; }
        footer .footer-links a:hover { color: var(--gold); }

        /* FORM STYLES */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #aaa; font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 4px;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--gold);
        }
        .form-group select option { background: var(--dark); color: #fff; }
        .error-text { color: #f06060; font-size: 0.78rem; margin-top: 5px; }

        @yield('styles')
    </style>
</head>
<body>

<nav>
    <a href="{{ route('website.home') }}" class="logo"><span>Restaurant</span></a>
    <ul class="nav-links">
        <li><a href="{{ route('website.home') }}">Home</a></li>
        <li><a href="{{ route('website.menu') }}">Menu</a></li>
        <li><a href="{{ route('website.private_dining') }}">Private Dining</a></li>
        <li><a href="{{ route('website.booking') }}">Reserve</a></li>
        <li><a href="{{ route('website.about') }}">About</a></li>
    </ul>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div class="flash success" id="flash">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="flash error" id="flash">{{ session('error') }}</div>
@endif

@yield('content')

<footer>
    <div class="footer-links">
        <a href="{{ route('website.menu') }}">Menu</a>
        <a href="{{ route('website.booking') }}">Reservations</a>
        <a href="{{ route('website.private_dining') }}">Private Dining</a>
        <a href="{{ route('website.about') }}">About</a>
    </div>
    <p>&copy; {{ date('Y') }} Restaurant. All rights reserved.</p>
</footer>

<script>
    // Auto-dismiss flash after 4s
    const flash = document.getElementById('flash');
    if (flash) setTimeout(() => flash.remove(), 4000);
</script>

@yield('scripts')
</body>
</html>