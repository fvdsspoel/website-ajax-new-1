<?php

return [
    'crm' => [
        'inquiry_api_url' => env('CRM_INQUIRY_API_URL'),
        'inquiry_api_key' => env('CRM_INQUIRY_API_KEY'),
        // Website live chat → CRM /api/webchat (Maya). Key must equal the
        // CRM's WEBCHAT_API_KEY.
        'webchat_url' => env('CRM_WEBCHAT_URL'),
        'webchat_key' => env('CRM_WEBCHAT_API_KEY'),
    ],

    // The ERP's read-only public pricing feed — see
    // Ajax-erp routes/api.php -> /api/public/substrate-prices and
    // App\Http\Controllers\Api\PublicPricingController.
    'erp' => [
        'public_pricing_url' => env('ERP_PUBLIC_PRICING_URL'),
        'public_pricing_api_key' => env('ERP_PUBLIC_PRICING_API_KEY'),
    ],
];
