@extends('layouts.website')

@section('title', 'About')

@section('styles')
    .about-hero {
        height: 40vh;
        display: flex; align-items: center; justify-content: center;
        text-align: center;
        background:
            linear-gradient(to bottom, rgba(15,15,15,0.5), rgba(15,15,15,0.95)),
            url('https://images.unsplash.com/photo-1414235077428-2338989a2e8c?w=1600&q=80');
        background-size: cover; background-position: center;
        padding-top: 70px;
    }
    .about-hero h1 { font-family: 'Playfair Display', serif; font-size: 3rem; color: #fff; }

    .about-content { max-width: 780px; margin: 0 auto; text-align: center; }
    .about-content p { color: var(--text-light); line-height: 1.9; font-size: 0.95rem; margin-bottom: 20px; }
    .about-content .highlight { color: #fff; font-size: 1.1rem; font-weight: 300; }

    .about-stats { display: flex; justify-content: center; gap: 60px; margin: 60px 0; }
    .about-stat .stat-num { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: var(--gold); }
    .about-stat .stat-label { color: var(--text-light); font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; margin-top: 4px; }
@endsection

@section('content')

<div class="about-hero">
    <div>
        <div class="section-label">Our Story</div>
        <h1>About Us</h1>
    </div>
</div>

<section style="padding: 90px 60px 60px;">
    <div class="about-content">
        <p class="highlight">this restaurant was born from a simple belief: that great food is more than sustenance — it is an experience.</p>
        <p>Founded in 2018, La Maison has become a cornerstone of the local culinary scene. Our chefs source the finest ingredients — many locally grown — and transform them into dishes that celebrate the seasons and honor tradition while embracing innovation.</p>
        <p>Every corner of our restaurant has been thoughtfully designed to create an atmosphere of warmth, elegance, and comfort. From our intimate main dining hall to our secluded private dining rooms, each space is a place to savor life's finer moments.</p>
    </div>

    <div class="about-stats">
        <div class="about-stat">
            <div class="stat-num">7</div>
            <div class="stat-label">Years of Excellence</div>
        </div>
        <div class="about-stat">
            <div class="stat-num">12</div>
            <div class="stat-label">Signature Dishes</div>
        </div>
        <div class="about-stat">
            <div class="stat-num">3</div>
            <div class="stat-label">Private Rooms</div>
        </div>
    </div>
</section>

<section style="text-align:center; padding: 0 60px 100px;">
    <div class="section-label">Visit Us</div>
    <h2 class="section-title" style="font-size:2rem;">Reservations Open Every Evening</h2>
    <div class="divider"></div>
    <a href="{{ route('website.booking') }}" class="btn-gold btn-gold-filled">Make a Reservation</a>
</section>

@endsection