<?php

namespace App\Http\Controllers;

use App\Services\CrmInquiryService;
use Illuminate\Http\JsonResponse;
use App\Support\BoardColours;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * "Design your space": the visitor picks what, layout, style, finish and
 * colour, may upload a plan or photos, and asks for a call back, a measuring
 * visit or a showroom visit. No price is ever shown here — it all goes into
 * the CRM as a new inquiry, and sales calls back with a quotation.
 */
class DesignController extends Controller
{
    public function __construct(private CrmInquiryService $crm) {}

    public function show()
    {
        return view('pages.design');
    }

    public function submit(Request $request): JsonResponse
    {
        // A field no person sees: a robot that fills it in gets a friendly answer and nothing is sent.
        if (filled($request->input('website'))) {
            return response()->json(['success' => true]);
        }

        $keys = fn (string $path) => implode(',', array_keys(trans('site.design.'.$path, [], 'en')));
        $layouts = collect(trans('site.design.layouts', [], 'en'))->flatMap(fn ($set) => array_keys($set))->unique()->implode(',');

        $v = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|string|max:40',
            'email' => 'nullable|email|max:150',
            'city' => 'nullable|string|max:120',
            'room' => 'nullable|in:'.$keys('rooms'),
            'layout' => 'nullable|in:'.$layouts,
            'size_m' => 'nullable|numeric|min:0.3|max:500',
            'style' => 'nullable|in:'.$keys('styles'),
            'board' => 'nullable|in:'.$keys('board_options'),
            'finish' => 'nullable|in:'.$keys('finishes'),
            'colour' => ['nullable', Rule::in(array_merge(['advise'], array_keys(BoardColours::all())))],
            'top' => 'nullable|in:'.$keys('tops'),
            'note' => 'nullable|string|max:2000',
            'next' => 'nullable|in:'.$keys('next_options'),
            'visit_date' => 'nullable|date|after:today',
            'visit_time' => 'nullable|in:'.$keys('visit_times'),
            'prefer' => 'nullable|in:'.$keys('prefer_options'),
            'when' => 'nullable|in:'.$keys('when_options'),
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|extensions:jpg,jpeg,png,webp,pdf|max:8192',
        ]);

        // The CRM message is written in English for the sales team, whatever language the visitor used.
        $en = fn (string $path, ?string $key) => $key ? (trans('site.design.'.$path.'.'.$key, [], 'en')) : null;
        $name = fn ($x) => is_array($x) ? ($x['name'] ?? null) : $x;
        $layoutSet = array_key_exists($v['room'] ?? '', trans('site.design.layouts', [], 'en')) ? $v['room'] : 'other';
        $visit = in_array($v['next'] ?? null, ['measure', 'showroom'], true);

        $lines = array_filter([
            '[Website design selector]',
            in_array($v['board'] ?? null, ['pvc', 'aluminium'], true)
                ? 'INFO REQUEST: please send this customer information about '.$name($en('board_options', $v['board'])).' (coming soon)'
                : null,
            'Wants: '.($en('rooms', $v['room'] ?? null) ?? 'not chosen'),
            isset($v['layout']) ? 'Layout: '.$en('layouts.'.$layoutSet, $v['layout']) : null,
            isset($v['size_m']) ? 'Wall length about: '.$v['size_m'].' m' : null,
            isset($v['style']) ? 'Style: '.$name($en('styles', $v['style'])) : null,
            isset($v['board']) ? 'Board: '.$name($en('board_options', $v['board'])).(in_array($v['board'], ['pvc', 'aluminium'], true) ? ' (coming soon — info request)' : '') : null,
            isset($v['finish']) ? 'Finish: '.$name($en('finishes', $v['finish'])) : null,
            isset($v['colour']) ? 'Colour: '.($v['colour'] === 'advise' ? 'Not sure yet — advise me' : BoardColours::describe($v['colour'])) : null,
            isset($v['top']) ? 'Countertop: '.$en('tops', $v['top']) : null,
            'Next step: '.($name($en('next_options', $v['next'] ?? 'call')) ?? 'Call me back')
                .($visit && ! empty($v['visit_date']) ? ' — '.$v['visit_date'].' '.($en('visit_times', $v['visit_time'] ?? 'any') ?? '') : ''),
            isset($v['when']) ? 'Timing: '.$en('when_options', $v['when']) : null,
            ! empty($v['city']) ? 'City / area: '.$v['city'] : null,
            ! empty($v['email']) ? 'E-mail: '.$v['email'] : null,
            'Website language: '.app()->getLocale(),
            ! empty($request->file('files')) ? 'Files attached: '.count($request->file('files')) : 'No files — may need a site visit to measure',
            ! empty($v['note']) ? "Note: ".$v['note'] : null,
        ]);

        $sent = $this->crm->submit([
            'name' => $v['name'],
            'contact' => $v['mobile'],
            'channel' => $v['prefer'] ?? 'call',
            'message' => implode("\n", $lines),
            'design_config' => array_filter([
                'source' => 'website_design_selector',
                'section' => $v['room'] ?? null,
                'type' => $v['room'] ?? null,
                'layout' => $v['layout'] ?? null,
                'length' => $v['size_m'] ?? null,
                'style' => $v['style'] ?? null,
                'board' => $v['board'] ?? null,
                'info_request' => in_array($v['board'] ?? null, ['pvc', 'aluminium'], true) ? $v['board'].'_board' : null,
                'finish' => $v['finish'] ?? null,
                'colour' => $v['colour'] ?? null,
                'countertop' => $v['top'] ?? null,
                'next' => $v['next'] ?? 'call',
                'visit_date' => $visit ? ($v['visit_date'] ?? null) : null,
                'visit_time' => $visit ? ($v['visit_time'] ?? null) : null,
                'timing' => $v['when'] ?? null,
                'city' => $v['city'] ?? null,
                'email' => $v['email'] ?? null,
                'locale' => app()->getLocale(),
            ], fn ($x) => $x !== null && $x !== ''),
        ], $request->file('files', []));

        if ($sent) {
            \App\Support\SiteStats::event($request, 'design_request', $v['room'] ?? null);
        }

        return response()->json([
            'success' => $sent,
            'message' => $sent ? __('site.design.success_title') : __('site.design.error'),
        ], $sent ? 200 : 502);
    }
}
