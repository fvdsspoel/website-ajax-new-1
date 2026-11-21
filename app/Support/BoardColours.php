<?php

namespace App\Support;

/**
 * All board colours from config/colours.php as one list (melamine, plywood, HPL).
 * Used by the Colours page and the colour step of "Design your space";
 * the value a visitor picks is the ERP code, so sales sees exactly which board.
 */
class BoardColours
{
    /** @return array<string, array{code:string,name:string,finish:string,hex:string,group:string,image?:string}> keyed by code */
    public static function all(): array
    {
        $out = [];
        foreach (config('colours') as $group => $list) {
            foreach ($list as $c) {
                $out[$c['code']] = $c + ['group' => $group];
            }
        }

        return $out;
    }

    /** English text for the CRM, e.g. "Cedar — Melamine boards, wood (MP.Y2146)". */
    public static function describe(string $code): ?string
    {
        $c = self::all()[$code] ?? null;
        if (! $c) {
            return null;
        }
        $group = trans('site.colours.tabs.'.$c['group'], [], 'en');
        $finish = trans('site.colours.finishes.'.$c['finish'], [], 'en');

        return $c['name'].' — '.$group.', '.strtolower($finish).' ('.$c['code'].')';
    }
}
