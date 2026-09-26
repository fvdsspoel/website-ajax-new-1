<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * EN / TL language toggle for the public site.
 *
 * Order of precedence: ?lang= on the URL (shareable links, e.g. a
 * Tagalog link posted on Facebook) → the visitor's saved choice in
 * the session → English. Supported locales live in config/company.php
 * so adding a third language later is a config change plus a lang file.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $supported = array_keys(config('company.locales', ['en' => 'English']));

        $fromQuery = $request->query('lang');
        if ($fromQuery && in_array($fromQuery, $supported, true)) {
            $request->session()->put('locale', $fromQuery);
        }

        $locale = $request->session()->get('locale', config('app.locale', 'en'));
        App::setLocale(in_array($locale, $supported, true) ? $locale : 'en');

        return $next($request);
    }
}
