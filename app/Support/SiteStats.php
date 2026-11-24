<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * (Sir Ferdinand, 24 November 2026: "it should count itself visitors also and shown on our social app") The website
 * counts its own visitors — no cookies, no outside service. A visitor is a short one-way code of the address, the
 * browser and the day (it cannot be turned back into either and changes every day), so a person counts once a day.
 * The social app (social.ajaxtradingcorp.com → Website) reads these two tables.
 */
class SiteStats
{
    /** What the website counts as a step a visitor took, besides looking at pages. */
    public const EVENTS = ['design_step', 'design_request', 'quote_request', 'chat_started', 'call_click', 'messenger_click', 'viber_click', 'whatsapp_click'];

    protected const BOTS = '/bot|crawl|spider|slurp|preview|facebookexternalhit|facebot|lighthouse|headless|pingdom|uptime|monitor|curl|wget|python|java\/|okhttp|axios|go-http|semrush|ahrefs|mj12|dotbot|petal|bytespider|gptbot|claude|anthropic|bingpreview|whatsapp\/|viber|telegram|skype|discord|embedly|vkshare|quora link|outbrain|pinterest|redditbot/i';

    public static function ready(): bool
    {
        static $ready = null;

        return $ready ??= Schema::hasTable('site_visits') && Schema::hasTable('site_events');
    }

    public static function today(): string
    {
        return now('Asia/Manila')->toDateString();
    }

    public static function isBot(?string $agent): bool
    {
        return $agent === null || trim($agent) === '' || (bool) preg_match(self::BOTS, $agent);
    }

    public static function visitor(Request $request): string
    {
        return substr(hash('sha256', $request->ip().'|'.(string) $request->userAgent().'|'.self::today().'|'.config('app.key')), 0, 16);
    }

    public static function device(?string $agent): string
    {
        $agent = (string) $agent;
        if (preg_match('/iPad|Tablet|PlayBook|Silk|(Android(?!.*Mobile))/i', $agent)) {
            return 'tablet';
        }

        return preg_match('/Mobi|iPhone|iPod|Android|BlackBerry|Opera Mini|IEMobile/i', $agent) ? 'phone' : 'computer';
    }

    /** Where the visitor came from: ads first (they carry a mark in the address), then the page that sent them. */
    public static function source(Request $request): array
    {
        $utm = strtolower((string) $request->query('utm_source', ''));
        $referrer = (string) $request->headers->get('referer', '');
        $host = strtolower((string) parse_url($referrer, PHP_URL_HOST));
        $host = preg_replace('/^(www\.|m\.|l\.|lm\.)/', '', $host) ?? $host;
        $own = strtolower(preg_replace('/^www\./', '', (string) $request->getHost()) ?? '');

        if ($request->query->has('gclid') || $request->query->has('gbraid') || $request->query->has('wbraid') || in_array($utm, ['google', 'googleads', 'adwords'], true)) {
            return ['google_ads', $host ?: null];
        }
        if ($request->query->has('fbclid') && ($utm !== '' || $request->query->has('utm_campaign'))) {
            return ['facebook_ads', $host ?: null];
        }
        // Our own pages (also new.ajaxtradingcorp.com, the test site): the visitor clicked on.
        $inside = $host !== '' && ($host === $own || $host === 'ajaxtradingcorp.com' || str_ends_with($host, '.ajaxtradingcorp.com'));
        if ($host === '' || $inside) {
            if ($request->query->has('fbclid')) {
                return ['facebook', null];
            }

            return [$inside ? 'inside' : ($utm !== '' ? 'other' : 'direct'), null];
        }
        foreach (['facebook' => ['facebook.', 'fb.', 'messenger.', 'instagram.'], 'google' => ['google.'], 'tiktok' => ['tiktok.'], 'youtube' => ['youtube.', 'youtu.be'],
            'other_search' => ['bing.', 'yahoo.', 'duckduckgo.', 'ecosia.', 'baidu.', 'yandex.'], 'shopee' => ['shopee.']] as $source => $marks) {
            foreach ($marks as $mark) {
                if (str_contains($host, $mark)) {
                    return [$source, $host];
                }
            }
        }

        return ['other', $host];
    }

    public static function countVisit(Request $request): void
    {
        try {
            if (! self::ready() || self::isBot($request->userAgent())) {
                return;
            }
            [$source, $host] = self::source($request);
            DB::table('site_visits')->insert([
                'day' => self::today(), 'visitor' => self::visitor($request),
                'path' => mb_substr('/'.ltrim($request->path(), '/'), 0, 190),
                'source' => $source, 'referrer_host' => $host ? mb_substr($host, 0, 120) : null,
                'device' => self::device($request->userAgent()), 'lang' => mb_substr((string) app()->getLocale(), 0, 5),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Visitor counter: '.$e->getMessage());
        }
    }

    public static function event(Request $request, string $name, ?string $detail = null): void
    {
        try {
            if (! in_array($name, self::EVENTS, true) || ! self::ready() || self::isBot($request->userAgent())) {
                return;
            }
            DB::table('site_events')->insert([
                'day' => self::today(), 'visitor' => self::visitor($request), 'name' => $name,
                'detail' => $detail !== null ? mb_substr($detail, 0, 120) : null,
                'path' => mb_substr((string) parse_url((string) $request->headers->get('referer', ''), PHP_URL_PATH) ?: '/'.ltrim($request->path(), '/'), 0, 190),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Visitor counter (event): '.$e->getMessage());
        }
    }
}
