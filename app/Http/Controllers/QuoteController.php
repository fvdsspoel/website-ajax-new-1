<?php

namespace App\Http\Controllers;

use App\Services\CrmInquiryService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct(private CrmInquiryService $crm) {}

    public function create()
    {
        return view('pages.quote');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'message' => 'nullable|string|max:2000',
            'interest' => 'nullable|string|in:kitchen,wardrobe,custom,accessories,project',
            'city' => 'nullable|string|max:120',
        ]);

        // Interest and city ride along in the CRM message so sales can
        // route the lead (e.g. project inquiries to the project team)
        // without needing new CRM columns.
        $validated['message'] = trim(implode("\n", array_filter([
            isset($validated['interest']) ? 'Interest: '.$validated['interest'] : null,
            !empty($validated['city']) ? 'City: '.$validated['city'] : null,
            'Language: '.app()->getLocale(),
            $validated['message'] ?? null,
        ])));

        $sent = $this->crm->submitQuoteRequest($validated);

        // The view shows the translated message; the flag just says which.
        return back()->withInput($sent ? [] : $request->all())->with($sent ? 'success' : 'error', true);
    }
}
