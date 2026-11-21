<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteText;
use App\Support\SiteTexts;
use Illuminate\Http\Request;

/** Website texts in English, Tagalog and Bisaya, section by section. Empty = the original text. */
class TextController extends Controller
{
    public function index(Request $request)
    {
        $sections = SiteTexts::SECTIONS;
        $section = array_key_exists((string) $request->query('section'), $sections) ? $request->query('section') : 'hero';
        $locales = config('company.locales');
        $defaults = [];
        foreach (array_keys($locales) as $l) {
            $defaults[$l] = SiteTexts::defaults($l);
        }
        $keys = array_values(array_filter(array_keys($defaults['en']), fn ($k) => str_starts_with($k, $section.'.')));
        $changed = SiteText::all(['locale', 'key', 'value', 'updated_at'])->groupBy('locale')->map(fn ($g) => $g->keyBy('key'));
        $counts = SiteText::selectRaw("substr(key, 1, instr(key, '.') - 1) as s, count(*) as n")->groupBy('s')->pluck('n', 's');

        return view('admin.texts', compact('sections', 'section', 'locales', 'defaults', 'keys', 'changed', 'counts'));
    }

    public function update(Request $request)
    {
        $section = (string) $request->input('section');
        abort_unless(array_key_exists($section, SiteTexts::SECTIONS), 404);
        $locales = array_keys(config('company.locales'));
        $valid = array_flip(array_filter(array_keys(SiteTexts::defaults('en')), fn ($k) => str_starts_with($k, $section.'.')));
        $input = (array) $request->input('t', []);
        $saved = 0;

        foreach ($locales as $l) {
            $defaults = SiteTexts::defaults($l) + SiteTexts::defaults('en');
            foreach ((array) ($input[$l] ?? []) as $field => $value) {
                $key = str_replace('__', '.', (string) $field);
                if (! isset($valid[$key])) {
                    continue;
                }
                $value = trim(strip_tags((string) $value));
                $value = mb_substr($value, 0, 3000);
                if ($value === '' || $value === trim((string) ($defaults[$key] ?? ''))) {
                    $saved += SiteText::where(['locale' => $l, 'key' => $key])->delete();
                    continue;
                }
                $row = SiteText::firstOrNew(['locale' => $l, 'key' => $key]);
                if ($row->value !== $value) {
                    $row->fill(['value' => $value, 'updated_by' => $request->user()->id])->save();
                    $saved++;
                }
            }
        }
        SiteTexts::forget();

        return redirect()->route('admin.texts.index', ['section' => $section])
            ->with('status', $saved ? 'Saved — the website shows the new texts now.' : 'Nothing was changed.');
    }
}
