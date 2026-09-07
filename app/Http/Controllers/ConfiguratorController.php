<?php

namespace App\Http\Controllers;

use App\Services\ConfiguratorPricingService;
use App\Services\CrmInquiryService;
use Illuminate\Http\Request;

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
            'substrates' => ConfiguratorPricingService::SUBSTRATE_RATES,
        ]);
    }

    /** Live price recalculation as the customer edits their design. */
    public function price(Request $request)
    {
        $validated = $request->validate([
            'modules' => 'array',
            'modules.*.type' => 'required|string|in:' . implode(',', array_keys(ConfiguratorPricingService::MODULE_TYPES)),
            'substrate' => 'required|string|in:' . implode(',', array_keys(ConfiguratorPricingService::SUBSTRATE_RATES)),
        ]);

        return response()->json(
            $this->pricing->price($validated['modules'] ?? [], $validated['substrate'])
        );
    }

    /** Submits the finished design straight into the CRM as a new Inquiry. */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'modules' => 'array',
            'modules.*.type' => 'required|string|in:' . implode(',', array_keys(ConfiguratorPricingService::MODULE_TYPES)),
            'substrate' => 'required|string|in:' . implode(',', array_keys(ConfiguratorPricingService::SUBSTRATE_RATES)),
        ]);

        $priced = $this->pricing->price($validated['modules'] ?? [], $validated['substrate']);

        $sent = $this->crm->submitConfiguratorDesign([
            'name' => $validated['name'],
            'contact' => $validated['contact'],
            'modules' => $validated['modules'] ?? [],
            'substrate' => $priced['substrate_label'],
            'total_lm' => $priced['total_lm'],
            'estimated_price' => $priced['estimated_price'],
        ]);

        return response()->json([
            'success' => $sent,
            'message' => $sent
                ? "Thanks! We've received your design and a designer will follow up shortly."
                : "We couldn't send that right now — please call us or try again in a moment.",
        ], $sent ? 200 : 502);
    }
}
