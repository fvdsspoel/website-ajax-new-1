<?php

namespace App\Http\Middleware;

use App\Support\SiteStats;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Counts a page view after the page went out (it never slows or breaks a page): only pages, only people, not the back office. */
class CountVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! $request->isMethod('GET') || $request->ajax() || $request->expectsJson() || $response->getStatusCode() !== 200) {
            return;
        }
        if (! str_contains((string) $response->headers->get('Content-Type'), 'text/html')) {
            return;
        }
        if ($request->is('admin', 'admin/*', 'chat/*', 'lang/*', 'up', 'sitemap.xml', 'robots.txt') || auth()->check()) {
            return;
        }
        // A page the browser only fetches in the background to be ready (prefetch) is not a visit.
        if (in_array(strtolower((string) $request->headers->get('Purpose', $request->headers->get('Sec-Purpose', ''))), ['prefetch', 'prerender'], true)) {
            return;
        }
        SiteStats::countVisit($request);
    }
}
