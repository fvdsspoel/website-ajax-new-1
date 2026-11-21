<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            // Featured first (admin tick), then the set order — real projects with photos.
            'featured' => PortfolioItem::whereNotNull('image_url')->orderByDesc('is_featured')->orderBy('sort')->latest()->limit(6)->get(),
        ]);
    }

    public function furniture()
    {
        return view('pages.furniture');
    }

    public function portfolio(Request $request)
    {
        $type = $request->query('type');

        return view('pages.portfolio', [
            'items' => PortfolioItem::orderByDesc('is_featured')->orderBy('sort')->orderByRaw('image_url is null')->latest()->get(),
            'categories' => PortfolioItem::CATEGORIES,
            'type' => array_key_exists((string) $type, PortfolioItem::CATEGORIES) ? $type : null,
        ]);
    }

    public function colours()
    {
        return view('pages.colours');
    }

    public function factory()
    {
        return view('pages.factory');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function showrooms()
    {
        return view('pages.showrooms');
    }
}
