<?php

namespace App\Http\Controllers;

use App\Models\Highlight;
use App\Models\PortfolioItem;
use App\Models\Product;
use App\Models\ShowroomLocation;

class PageController extends Controller
{
    public function home()
    {
        // Featured projects first; if nobody has ticked "featured" in the
        // admin yet, fall back to projects that already have a photo,
        // then to the newest — so the homepage never shows an empty grid.
        $featured = PortfolioItem::orderByDesc('is_featured')
            ->orderByRaw('image_url is null')
            ->latest()
            ->limit(6)
            ->get();

        return view('pages.home', [
            'featured' => $featured,
            'accessories' => Product::whereIn('category', array_keys(Product::CATEGORIES))->orderBy('id')->limit(6)->get(),
            'highlights' => Highlight::latest('published_at')->limit(4)->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function portfolio()
    {
        return view('pages.portfolio', [
            'items' => PortfolioItem::orderByDesc('is_featured')->orderByRaw('image_url is null')->latest()->get(),
            'categories' => PortfolioItem::CATEGORIES,
        ]);
    }

    public function machines()
    {
        return view('pages.machines');
    }

    public function products()
    {
        return view('pages.products', [
            'products' => Product::whereIn('category', array_keys(Product::CATEGORIES))->orderBy('id')->get(),
            'categories' => Product::CATEGORIES,
        ]);
    }

    public function showrooms()
    {
        return view('pages.showrooms', [
            'locations' => ShowroomLocation::where('is_showroom', true)
                ->where('is_active', true)
                ->orderBy('is_upcoming')
                ->get(),
        ]);
    }
}
