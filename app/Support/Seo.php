<?php

namespace App\Support;

/**
 * One fixed address per page for Google (26 November 2026: Search Console "Duplicate, Google chose different canonical
 * than user"). The address is built from APP_URL (https://www.ajaxtradingcorp.com), never from the address the page
 * happened to be opened with; the home page always ends in "/"; Tagalog and Bisaya add ?lang=tl / ?lang=ceb.
 */
class Seo
{
    public static function url(?string $path = null, string $locale = 'en'): string
    {
        $path = trim($path ?? request()->path(), '/');
        $u = rtrim((string) config('app.url'), '/').'/'.$path;

        return $u.($locale !== 'en' ? '?lang='.$locale : '');
    }

    /** The path of a named route ("home" → ""). */
    public static function routePath(string $name): string
    {
        return trim((string) parse_url(route($name), PHP_URL_PATH), '/');
    }
}
