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
        ]);

        $sent = $this->crm->submitQuoteRequest($validated);

        return back()->with(
            $sent ? 'success' : 'error',
            $sent
                ? "Thanks! We've received your inquiry and will be in touch shortly."
                : "We couldn't send that right now — please call us directly or try again."
        );
    }
}
