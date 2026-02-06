<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{MenuItem, MenuCategory};

class PageController extends Controller
{
    /*
    1- Homepage
    2- Full menu page (calls API internally or loads directly)
    3- Private dining page
    4 - About
    */
    public function home()
    {
        $featured = MenuItem::where('is_featured', true)
            ->where('is_available', true)
            ->with('category')
            ->take(6)
            ->get();

        return view('website.home', compact('featured'));
    }

    // Full menu page (calls API internally or loads directly)
    public function menu()
    {
        $categories = MenuCategory::where('is_active', true)
            ->with(['items' => fn($q) => $q->where('is_available', true)])
            ->orderBy('sort_order')
            ->get();

        return view('website.menu', compact('categories'));
    }

    // Private dining page
    public function privateDining()
    {
        return view('website.private_dining');
    }

    // About page
    public function about()
    {
        return view('website.about');
    }
}
