<?php

namespace App\Support;

use App\Models\SiteText;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

/**
 * Website texts: the defaults live in lang/{locale}/site.php; whatever the team
 * changes in the back office is stored in site_texts and laid on top.
 * Removing a change (or saving it empty) brings the original text back.
 */
class SiteTexts
{
    public const CACHE_KEY = 'site_texts.v1';

    /** Section names in the back office, in page order. */
    public const SECTIONS = [
        'hero' => 'Home — top (hero)', 'stats' => 'Home — numbers', 'make' => 'What we make', 'why' => 'Why Ajax',
        'process' => 'How it works', 'factory' => 'Our factory', 'portfolio' => 'Projects', 'boards' => 'Our boards',
        'colours' => 'Colours', 'developers' => 'Developers / B2B', 'upload' => 'Upload your plan', 'social' => 'Social media',
        'showroom' => 'Showroom', 'design' => 'Design your space', 'quote' => 'Contact / free quote', 'about' => 'About us',
        'cta' => 'Call-to-action band', 'float' => 'Floating buttons', 'chat' => 'Chat', 'footer' => 'Footer',
        'nav' => 'Menu', 'meta' => 'Google / page titles',
    ];

    /** Every text of a locale's file as "section.key" => text (only real strings, lists included). */
    public static function defaults(string $locale): array
    {
        $file = lang_path($locale.'/site.php');
        if (! is_file($file)) {
            return [];
        }

        return array_filter(Arr::dot(require $file), fn ($v) => is_string($v));
    }

    /** All back-office changes as [locale => ["section.key" => text]]. */
    public static function overrides(): array
    {
        try {
            return Cache::rememberForever(self::CACHE_KEY, function () {
                if (! Schema::hasTable('site_texts')) {
                    return [];
                }
                $out = [];
                foreach (SiteText::all(['locale', 'key', 'value']) as $t) {
                    $out[$t->locale][$t->key] = $t->value;
                }

                return $out;
            });
        } catch (Throwable) {
            return [];                                      // never break the public site over this
        }
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /** Lays the changes over the loaded lang lines for these locales. */
    public static function apply(array $locales): void
    {
        $all = self::overrides();
        $translator = app('translator');
        $translator->setLoaded([]);                         // start from the files every request (no stale changes)
        foreach (array_unique($locales) as $locale) {
            if (empty($all[$locale])) {
                continue;
            }
            $translator->load('*', 'site', $locale);         // load the file first, or it would never load
            $lines = [];
            foreach ($all[$locale] as $key => $value) {
                $lines['site.'.$key] = $value;
            }
            $translator->addLines($lines, $locale);
        }
    }
}
