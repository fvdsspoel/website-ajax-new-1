<?php

namespace App\Support;

/**
 * All colours from config/colours.php as one list: board colours (plywood or particle board) and HPL.
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

    /** English text for the CRM, e.g. "Cedar — board colour, wood (MP.Y2146)" or "Golden Teak — HPL, wood (HPL.9066)". */
    public static function describe(string $code): ?string
    {
        $c = self::all()[$code] ?? null;
        if (! $c) {
            return null;
        }
        $group = $c['group'] === 'hpl' ? 'HPL' : 'board colour';
        $finish = trans('site.colours.finishes.'.$c['finish'], [], 'en');

        return $c['name'].' — '.$group.', '.strtolower($finish).' ('.$c['code'].')';
    }
}
