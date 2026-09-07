<?php

namespace App\Http\Controllers;

use App\Services\ConfiguratorPricingService;
use App\Services\CrmInquiryService;
use Illuminate\Http\Request;

/**
 * The configurator is a lead-capture/design tool, not a checkout —
 * Ajax doesn't sell online yet, so no price is ever shown to the
 * customer here (see project decision log in README). The estimate
 * is still computed server-side and attached to the CRM inquiry so
 * the sales team walks into the follow-up call informed.
 */
class ConfiguratorController extends Controller
{
    public function __construct(
        private ConfiguratorPricingService $pricing,
        private CrmInquiryService $crm,
    ) {}

    public function show()
    {
        return view('pages.configurator', [
            'moduleTypes' => ConfiguratorPricingService::MODULE_TYPES,
            'substrates' => $this->pricing->substrateRates(),
        ]);
    }

    /** Submits the finished design as a quote request — straight into the CRM as a new Inquiry. */
    public function submit(Request $request)
    {
        $substrateKeys = array_keys($this->pricing->substrateRates());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'modules' => 'required|array|min:1',
            'modules.*.type' => 'required|string|in:' . implode(',', array_keys(ConfiguratorPricingService::MODULE_TYPES)),
            'substrate' => 'required|string|in:' . implode(',', $substrateKeys),
        ]);

        // Priced internally for the sales team's reference in the CRM
        // — never returned to the browser.
        $priced = $this->pricing->price($validated['modules'], $validated['substrate']);

        $sent = $this->crm->submitConfiguratorDesign([
            'name' => $validated['name'],
            'contact' => $validated['contact'],
            'modules' => $validated['modules'],
            'substrate' => $priced['substrate_label'],
            'total_lm' => $priced['total_lm'],
            'estimated_price' => $priced['estimated_price'],
        ]);

        return response()->json([
            'success' => $sent,
            'message' => $sent
                ? "Thanks! We've received your design — a member of our sales team will call you shortly."
                : "We couldn't send that right now — please call us directly or try again in a moment.",
        ], $sent ? 200 : 502);
    }
}
