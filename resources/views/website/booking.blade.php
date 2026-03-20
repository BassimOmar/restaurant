{{-- resources/views/website/booking.blade.php --}}
@extends('layouts.website')

@section('title', 'Reserve a Table')

@section('styles')
    .booking-page {
        min-height: 100vh;
        padding: 140px 60px 100px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 80px;
        max-width: 1100px;
        margin: 0 auto;
    }
    .booking-left { flex: 1; max-width: 480px; }
    .booking-left .section-label { text-align: left; }
    .booking-left h1 { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #fff; margin-bottom: 16px; text-align: left; }
    .booking-left p { color: var(--text-light); line-height: 1.7; margin-bottom: 30px; }

    .booking-perks { list-style: none; }
    .booking-perks li { padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; gap: 14px; color: #ccc; font-size: 0.9rem; }
    .booking-perks li:last-child { border-bottom: none; }
    .booking-perks .perk-icon { color: var(--gold); font-size: 1.1rem; }

    .booking-right { flex: 1; max-width: 460px; }
    .booking-form-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 40px;
    }
    .booking-form-card h3 { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: #fff; margin-bottom: 28px; }
    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .checkbox-fancy { display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 6px; cursor: pointer; transition: border-color 0.3s; }
    .checkbox-fancy:hover { border-color: rgba(201,168,76,0.3); }
    .checkbox-fancy input[type="checkbox"] { accent-color: var(--gold); width: 16px; height: 16px; }
    .checkbox-fancy span { color: #ccc; font-size: 0.85rem; }
    .checkbox-fancy .pd-badge { font-size: 0.7rem; color: var(--gold); background: rgba(201,168,76,0.12); padding: 2px 8px; border-radius: 10px; margin-left: 6px; }
@endsection

@section('content')

<div class="booking-page">
    <!-- LEFT: Info -->
    <div class="booking-left">
        <div class="section-label">Reservations</div>
        <h1>Reserve Your<br>Evening</h1>
        <p>Select your preferred date, time, and party size. We'll confirm your table within minutes.</p>

        <ul class="booking-perks">
            <li><span class="perk-icon">🕐</span> Instant confirmation</li>
            <li><span class="perk-icon">🍷</span> Curated wine pairing available</li>
            <li><span class="perk-icon">🌙</span> Evening ambiance, always</li>
            <li><span class="perk-icon">🎂</span> Special occasion arrangements</li>
        </ul>
    </div>

    <!-- RIGHT: Form -->
    <div class="booking-right">
        <div class="booking-form-card">
            <h3>New Reservation</h3>

            <form action="{{ route('website.booking.store') }}" method="POST">
                @csrf

                <div class="row-2">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required />
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required />
                    </div>
                </div>

                <div class="form-group">
                    <label>Email (Optional)</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" />
                </div>

                <div class="row-2">
                    <div class="form-group">
                        <label>Date & Time</label>
                        <input type="datetime-local" name="booking_date" value="{{ old('booking_date') }}" required />
                    </div>
                    <div class="form-group">
                        <label>Guests</label>
                        <select name="guest_count" required>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('guest_count') == $i ? 'selected' : '' }}>{{ $i }} Guest{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Duration</label>
                    <select name="duration_minutes">
                        <option value="60">1 Hour</option>
                        <option value="90">1.5 Hours</option>
                        <option value="120" selected>2 Hours</option>
                        <option value="180">3 Hours</option>
                    </select>
                </div>

                <!-- Private Dining Toggle -->
                <div class="form-group">
                    <label class="checkbox-fancy">
                        <input type="checkbox" name="is_private_dining" value="1" {{ old('is_private_dining') ? 'checked' : '' }} />
                        <span>Private Dining Room <span class="pd-badge">Exclusive</span></span>
                    </label>
                </div>

                <div class="form-group">
                    <label>Special Requests</label>
                    <textarea name="special_requests" rows="3" placeholder="Birthday celebration, dietary needs, etc.">{{ old('special_requests') }}</textarea>
                </div>

                @if($errors->any())
                    <div class="error-text" style="margin-bottom: 12px;">{{ $errors->first() }}</div>
                @endif

                <button type="submit" class="btn-gold btn-gold-filled" style="width:100%; padding: 15px;">Confirm Reservation</button>
            </form>
        </div>
    </div>
</div>

@endsection