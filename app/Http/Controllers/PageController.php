<?php

namespace App\Http\Controllers;

use App\Models\Highlight;

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
        return view('pages.portfolio');
    }

    public function products()
    {
        return view('pages.products');
    }

    public function showrooms()
    {
        return view('pages.showrooms');
    }
}
