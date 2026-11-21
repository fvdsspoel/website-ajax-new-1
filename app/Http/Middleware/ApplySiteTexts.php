<?php

namespace App\Http\Middleware;

use App\Support\SiteTexts;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/** Puts the texts changed in the back office on the page (after SetLocale has chosen the language). */
class ApplySiteTexts
{
    public function handle(Request $request, Closure $next)
    {
        SiteTexts::apply([App::getLocale(), 'en']);

        return $next($request);
    }
}
