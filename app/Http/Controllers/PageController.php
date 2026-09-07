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
        return view('pages.home', [
            'highlights' => Highlight::latest('published_at')->limit(6)->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function portfolio()
    {
        return view('pages.portfolio', [
            'items' => PortfolioItem::latest()->get(),
            'categories' => PortfolioItem::CATEGORIES,
        ]);
    }

    public function products()
    {
        return view('pages.products', [
            'products' => Product::orderBy('category')->get(),
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
