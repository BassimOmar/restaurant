{{-- resources/views/website/menu.blade.php --}}
@extends('layouts.website')

@section('title', 'Menu')

@section('styles')
    .menu-hero {
        height: 35vh;
        display: flex; align-items: center; justify-content: center;
        text-align: center;
        background:
            linear-gradient(to bottom, rgba(15,15,15,0.6), rgba(15,15,15,0.9)),
            url('https://images.unsplash.com/photo-1414235077428-2338989a2e8c?w=1600&q=80');
        background-size: cover; background-position: center;
        padding-top: 70px;
    }
    .menu-hero h1 { font-family: 'Playfair Display', serif; font-size: 3rem; color: #fff; }
    .menu-hero p { color: var(--text-light); margin-top: 10px; }

    /* CATEGORY TABS */
    .category-tabs {
        display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;
        padding: 40px 60px 10px;
        position: sticky; top: 60px; z-index: 50;
        background: var(--darker);
    }
    .cat-tab {
        padding: 9px 22px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 25px;
        color: var(--text-light);
        background: transparent;
        font-size: 0.82rem;
        cursor: pointer;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.3s;
        text-decoration: none;
    }
    .cat-tab:hover, .cat-tab.active { border-color: var(--gold); color: var(--gold); background: rgba(201,168,76,0.08); }

    /* MENU SECTION */
    .menu-section { max-width: 850px; margin: 0 auto; }
    .menu-category-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.7rem;
        color: #fff;
        margin-bottom: 8px;
        padding-top: 50px;
    }
    .menu-category-title:first-child { padding-top: 0; }
    .menu-category-desc { color: var(--text-light); font-size: 0.85rem; margin-bottom: 24px; }

    /* MENU ITEM ROW */
    .menu-item-row {
        display: flex; justify-content: space-between; align-items: baseline;
        padding: 18px 0;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .menu-item-row:last-child { border-bottom: none; }
    .menu-item-left { flex: 1; padding-right: 30px; }
    .menu-item-name { font-size: 1rem; color: #fff; font-weight: 500; margin-bottom: 4px; }
    .menu-item-name .featured-dot { display: inline-block; width: 7px; height: 7px; background: var(--gold); border-radius: 50%; margin-left: 8px; }
    .menu-item-desc { color: var(--text-light); font-size: 0.82rem; line-height: 1.5; }
    .menu-item-allergens { margin-top: 5px; }
    .menu-item-allergens span { font-size: 0.7rem; color: #c0a060; background: rgba(192,160,96,0.12); padding: 2px 8px; border-radius: 10px; margin-right: 4px; }
    .menu-item-price { color: var(--gold); font-size: 1.05rem; white-space: nowrap; font-weight: 500; }
@endsection

@section('content')

<div class="menu-hero">
    <div>
        <div class="section-label">Crafted With Care</div>
        <h1>Our Menu</h1>
        <p>Seasonal dishes, timeless flavors</p>
    </div>
</div>

<!-- CATEGORY TABS -->
<div class="category-tabs">
    <a href="#all" class="cat-tab active" onclick="filterCategory(event, 'all')">All</a>
    @foreach($categories as $cat)
        <a href="#{{ $cat->id }}" class="cat-tab" onclick="filterCategory(event, '{{ $cat->id }}')">{{ $cat->name }}</a>
    @endforeach
</div>

<!-- MENU -->
<section style="padding: 30px 60px 100px;">
    <div class="menu-section">
        @foreach($categories as $category)
            <div class="menu-category" data-category="{{ $category->id }}">
                <h2 class="menu-category-title">{{ $category->name }}</h2>
                @if($category->description)
                    <p class="menu-category-desc">{{ $category->description }}</p>
                @endif

                @foreach($category->items as $item)
                    <div class="menu-item-row">
                        <div class="menu-item-left">
                            <div class="menu-item-name">
                                {{ $item->name }}
                                @if($item->is_featured)<span class="featured-dot"></span>@endif
                            </div>
                            @if($item->description)
                                <div class="menu-item-desc">{{ $item->description }}</div>
                            @endif
                            @if(!empty($item->allergens))
                                <div class="menu-item-allergens">
                                    @foreach($item->allergens as $allergen)
                                        <span>{{ $allergen }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="menu-item-price">${{ number_format($item->price, 2) }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach

        @if($categories->isEmpty())
            <p style="text-align:center; color: var(--text-light); padding: 60px 0;">Menu coming soon...</p>
        @endif
    </div>
</section>

<!-- CTA -->
<section style="text-align:center; padding: 0 60px 100px;">
    <div class="section-label">Ready?</div>
    <h2 class="section-title" style="font-size:2rem;">Reserve Your Table</h2>
    <a href="{{ route('website.booking') }}" class="btn-gold btn-gold-filled">Make a Reservation</a>
</section>

@endsection

@section('scripts')
<script>
function filterCategory(e, catId) {
    e.preventDefault();
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    e.target.classList.add('active');

    document.querySelectorAll('.menu-category').forEach(section => {
        if (catId === 'all') {
            section.style.display = 'block';
        } else {
            section.style.display = section.dataset.category === catId ? 'block' : 'none';
        }
    });
}
</script>
@endsection