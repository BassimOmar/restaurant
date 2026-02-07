{{-- resources/views/website/private_dining.blade.php --}}
@extends('layouts.website')

@section('title', 'Private Dining — La Maison')

@section('styles')
    .pd-hero {
        height: 55vh;
        display: flex; align-items: center; justify-content: center;
        text-align: center;
        background:
            linear-gradient(to bottom, rgba(15,15,15,0.4), rgba(15,15,15,0.9)),
            url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1600&q=80');
        background-size: cover; background-position: center;
        padding-top: 70px;
    }
    .pd-hero h1 { font-family: 'Playfair Display', serif; font-size: 3.5rem; color: #fff; margin-bottom: 12px; }
    .pd-hero p { color: rgba(255,255,255,0.7); max-width: 520px; line-height: 1.7; }

    .pd-features { max-width: 900px; margin: 0 auto; }
    .pd-feature-row { display: flex; align-items: center; gap: 50px; margin-bottom: 70px; }
    .pd-feature-row:nth-child(even) { flex-direction: row-reverse; }
    .pd-feature-img { flex: 1; height: 280px; border-radius: 6px; overflow: hidden; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); display: flex; align-items: center; justify-content: center; }
    .pd-feature-img span { font-size: 4rem; }
    .pd-feature-text { flex: 1; }
    .pd-feature-text h3 { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #fff; margin-bottom: 12px; }
    .pd-feature-text p { color: var(--text-light); line-height: 1.7; font-size: 0.9rem; }

    .pd-packages { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-width: 950px; margin: 0 auto; }
    .pd-pkg {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 6px;
        padding: 36px 28px;
        text-align: center;
        transition: border-color 0.3s;
    }
    .pd-pkg:hover { border-color: rgba(201,168,76,0.3); }
    .pd-pkg h4 { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: #fff; margin-bottom: 8px; }
    .pd-pkg .pkg-price { color: var(--gold); font-size: 1.5rem; margin-bottom: 16px; }
    .pd-pkg .pkg-price span { font-size: 0.78rem; color: var(--text-light); }
    .pd-pkg ul { list-style: none; text-align: left; margin-bottom: 24px; }
    .pd-pkg ul li { padding: 6px 0; color: #bbb; font-size: 0.83rem; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .pd-pkg ul li:last-child { border: none; }
    .pd-pkg ul li::before { content: '✓ '; color: var(--gold); }
@endsection

@section('content')

<!-- HERO -->
<div class="pd-hero">
    <div>
        <div class="section-label">Exclusive</div>
        <h1>Private Dining</h1>
        <p>Intimate, secluded spaces designed for your most important moments. A personalized experience from start to finish.</p>
    </div>
</div>

<!-- FEATURES -->
<section style="padding: 90px 60px 40px;">
    <div class="pd-features">
        <div class="pd-feature-row">
            <div class="pd-feature-img"><span>🕯️</span></div>
            <div class="pd-feature-text">
                <h3>Intimate Setting</h3>
                <p>Our private dining rooms are designed to offer an unparalleled sense of exclusivity. From candlelit tables to bespoke décor, every detail is tailored to your vision.</p>
            </div>
        </div>
        <div class="pd-feature-row">
            <div class="pd-feature-img"><span>🍽️</span></div>
            <div class="pd-feature-text">
                <h3>Custom Menus</h3>
                <p>Work directly with our chef to create a menu that perfectly reflects your occasion — whether it's a birthday, anniversary, or corporate celebration.</p>
            </div>
        </div>
    </div>
</section>

<!-- PACKAGES -->
<section style="padding: 60px 60px 100px;">
    <div class="section-label">Packages</div>
    <h2 class="section-title">Choose Your Experience</h2>
    <div class="divider"></div>

    <div class="pd-packages">
        <div class="pd-pkg">
            <h4>Intimate</h4>
            <div class="pkg-price">$150 <span>/ person</span></div>
            <ul>
                <li>Up to 4 guests</li>
                <li>3-course meal</li>
                <li>Wine pairing</li>
                <li>Candlelit setup</li>
            </ul>
            <a href="{{ route('website.booking') }}" class="btn-gold">Reserve</a>
        </div>
        <div class="pd-pkg" style="border-color: rgba(201,168,76,0.3);">
            <h4>Classic</h4>
            <div class="pkg-price">$220 <span>/ person</span></div>
            <ul>
                <li>Up to 8 guests</li>
                <li>5-course meal</li>
                <li>Premium wine list</li>
                <li>Custom décor</li>
            </ul>
            <a href="{{ route('website.booking') }}" class="btn-gold btn-gold-filled">Reserve</a>
        </div>
        <div class="pd-pkg">
            <h4>Grand</h4>
            <div class="pkg-price">$350 <span>/ person</span></div>
            <ul>
                <li>Up to 16 guests</li>
                <li>7-course tasting</li>
                <li>Sommelier service</li>
                <li>Full event planning</li>
            </ul>
            <a href="{{ route('website.booking') }}" class="btn-gold">Reserve</a>
        </div>
    </div>
</section>

@endsection