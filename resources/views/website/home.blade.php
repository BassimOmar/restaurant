@extends('layouts.website')

@section('title', 'Fine Dining Experience')

@section('styles')
    .hero {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background:
            linear-gradient(to bottom, rgba(15,15,15,0.5), rgba(15,15,15,0.85)),
            url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1600&q=80');
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 200px;
        background: linear-gradient(to top, var(--darker), transparent);
    }
    .hero-content { position: relative; z-index: 1; }
    .hero-content .hero-label { color: var(--gold); letter-spacing: 5px; text-transform: uppercase; font-size: 0.75rem; margin-bottom: 18px; }
    .hero-content h1 { font-family: 'Playfair Display', serif; font-size: 4.5rem; color: #fff; margin-bottom: 18px; font-weight: 400; line-height: 1.1; }
    .hero-content p { color: var(--text-light); font-size: 1rem; max-width: 480px; margin: 0 auto 40px; font-weight: 300; line-height: 1.7; }
    .hero-buttons { display: flex; gap: 16px; justify-content: center; }

    /* FEATURED */
    .featured-section { background: var(--darker); }
    .featured-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; max-width: 1100px; margin: 0 auto; }
    .featured-card { position: relative; overflow: hidden; border-radius: 6px; height: 320px; }
    .featured-card img { width: 100%; height: 100%; object-fit: cover; }
    .featured-card .card-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
        display: flex; flex-direction: column; justify-content: flex-end;
        padding: 28px;
    }
    .featured-card .card-category { font-size: 0.7rem; color: var(--gold); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 6px; }
    .featured-card .card-name { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: #fff; margin-bottom: 6px; }
    .featured-card .card-price { color: var(--gold); font-size: 0.95rem; }

    /* WHY US */
    .why-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; max-width: 1000px; margin: 0 auto; }
    .why-card { text-align: center; padding: 30px 20px; }
    .why-icon { font-size: 2rem; margin-bottom: 16px; }
    .why-card h4 { font-family: 'Playfair Display', serif; font-size: 1.1rem; margin-bottom: 10px; color: #fff; }
    .why-card p { color: var(--text-light); font-size: 0.85rem; line-height: 1.6; }

    /* CTA */
    .cta-section {
        background: linear-gradient(135deg, rgba(201,168,76,0.08), rgba(15,15,15,1));
        border-top: 1px solid rgba(201,168,76,0.15);
        border-bottom: 1px solid rgba(201,168,76,0.15);
        text-align: center;
    }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: 2.4rem; color: #fff; margin-bottom: 14px; }
    .cta-section p { color: var(--text-light); margin-bottom: 36px; max-width: 500px; margin-left: auto; margin-right: auto; margin-bottom: 36px; }
@endsection

@section('content')

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-label">Welcome to</div>
        <h1>La Maison</h1>
        <p>An extraordinary culinary journey, crafted with passion and the finest ingredients. Every dish tells a story.</p>
        <div class="hero-buttons">
            <a href="{{ route('website.menu') }}" class="btn-gold">Explore Menu</a>
            <a href="{{ route('website.booking') }}" class="btn-gold btn-gold-filled">Reserve a Table</a>
        </div>
    </div>
</section>

<!-- FEATURED DISHES -->
<section class="featured-section">
    <div class="section-label">Chef's Selection</div>
    <h2 class="section-title">Featured Dishes</h2>
    <div class="divider"></div>

    <div class="featured-grid">
        @foreach($featured as $item)
        <div class="featured-card">
            <img src="{{ asset('assets/img/' . $item->image) }}" 
            alt="{{ $item->name }}" 
            style="width: 100%; height: 200px; object-fit: cover;">
            <div class="card-overlay">
                <div class="card-category">{{ $item->category->name }}</div>
                <div class="card-name">{{ $item->name }}</div>
                <div class="card-price">${{ number_format($item->price, 2) }}</div>
            </div>
        </div>
        @endforeach

        @if($featured->isEmpty())
        <div class="featured-card">
            <img src="https://images.unsplash.com/photo-1414235077428-2338989a2e8c?w=600&q=80" alt="Signature Dish" />
            <div class="card-overlay">
                <div class="card-category">Main Course</div>
                <div class="card-name">Signature Dish</div>
                <div class="card-price">$ —</div>
            </div>
        </div>
        @endif
    </div>

    <div style="text-align:center; margin-top: 50px;">
        <a href="{{ route('website.menu') }}" class="btn-gold">View Full Menu</a>
    </div>
</section>

<!-- WHY US -->
<section style="background: var(--darker); padding-top: 80px;">
    <div class="section-label">Why Choose Us</div>
    <h2 class="section-title" style="font-size:2.2rem;">The Finest Experience</h2>
    <div class="divider"></div>
    <div class="why-grid">
        <div class="why-card">
            <div class="why-icon">🍽️</div>
            <h4>Exquisite Cuisine</h4>
            <p>Seasonal menus crafted by award-winning chefs using locally sourced ingredients.</p>
        </div>
        <div class="why-card">
            <div class="why-icon">🕯️</div>
            <h4>Intimate Ambiance</h4>
            <p>A refined atmosphere designed for memorable evenings with loved ones.</p>
        </div>
        <div class="why-card">
            <div class="why-icon">🥂</div>
            <h4>Private Dining</h4>
            <p>Exclusive private rooms for celebrations, business, and special occasions.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="section-label">Don't Wait</div>
    <h2>Begin Your Evening</h2>
    <p>Reserve your table today and experience the finest dining in the city.</p>
    <a href="{{ route('website.booking') }}" class="btn-gold btn-gold-filled">Make a Reservation</a>
</section>

@endsection