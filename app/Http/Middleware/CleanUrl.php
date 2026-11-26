<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * /index.php showed the home page under a second address (26 November 2026, Search Console: duplicate pages).
 * /index.php and /index.php/anything go to the clean address with a permanent redirect (301), keeping ?lang=.
 */
class CleanUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        $uri = (string) $request->server('REQUEST_URI', '');
        if (in_array($request->method(), ['GET', 'HEAD'], true) && preg_match('#^/index\.php(/[^?]*)?(\?.*)?$#', $uri, $m)) {
            return redirect()->to(rtrim((string) config('app.url'), '/').($m[1] ?? '/').($m[2] ?? ''), 301);
        }

        return $next($request);
    }
}
