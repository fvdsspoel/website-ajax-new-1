<?php

namespace App\Http\Controllers;

use App\Services\CrmInquiryService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct(private CrmInquiryService $crm) {}

    public function create(Request $request)
    {
        return view('pages.quote', ['interest' => $request->query('interest')]);
    }

    public function store(Request $request)
    {
        if (filled($request->input('website'))) {
            return back()->with('success', true);
        }

        $v = $request->validate([
            'name' => 'required|string|max:150',
            'contact' => 'required|string|max:150',
            'message' => 'nullable|string|max:2000',
            'interest' => 'nullable|in:'.implode(',', array_keys(trans('site.quote.interests', [], 'en'))),
            'city' => 'nullable|string|max:120',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,pdf|extensions:jpg,jpeg,png,webp,pdf|max:8192',
        ]);

        $sent = $this->crm->submit([
            'name' => $v['name'],
            'contact' => $v['contact'],
            'message' => trim(implode("\n", array_filter([
                '[Website contact form]',
                ! empty($v['interest']) ? 'Interest: '.trans('site.quote.interests.'.$v['interest'], [], 'en') : null,
                ! empty($v['city']) ? 'City / area: '.$v['city'] : null,
                'Website language: '.app()->getLocale(),
                $v['message'] ?? null,
            ]))),
            'design_config' => array_filter([
                'source' => 'website_contact_form',
                'section' => $v['interest'] ?? null,
                'city' => $v['city'] ?? null,
                'locale' => app()->getLocale(),
            ]),
        ], $request->file('files', []));

        if ($sent) {
            \App\Support\SiteStats::event($request, 'quote_request', $v['interest'] ?? null);
        }

        return back()->withInput($sent ? [] : $request->except('files'))->with($sent ? 'success' : 'error', true);
    }
}
