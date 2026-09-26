<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Posts every lead-capturing form on the site (quote requests, kitchen
 * builder designs) into the CRM as a new Inquiry, via the CRM's existing
 * public endpoint POST /api/inquiry (SalesToolController::storeInquiry).
 *
 * Everything arrives on the CRM's 'web' channel, so it lands in the same
 * Inquiries inbox as Facebook and WhatsApp, is labelled "Website" when
 * converted to a deal, and Maya / the no-reply timer take over as usual.
 */
class CrmInquiryService
{
    public function submitQuoteRequest(array $data): bool
    {
        return $this->post([
            'name' => $data['name'],
            'contact' => $data['contact'],
            'channel' => 'web',
            'message' => "[Website quote form]\n" . ($data['message'] ?? ''),
            'design_config' => array_filter([
                'source' => 'website_quote_form',
                'section' => $data['interest'] ?? null,
                'city' => $data['city'] ?? null,
            ]),
        ]);
    }

    /**
     * @param array{name: string, contact: string, modules: array, substrate: string, total_lm: float, estimated_price: float} $data
     */
    public function submitConfiguratorDesign(array $data): bool
    {
        $modules = collect($data['modules'])->countBy('type')
            ->map(fn ($n, $type) => "{$n}× {$type}")->implode(', ');

        return $this->post([
            'name' => $data['name'],
            'contact' => $data['contact'],
            'channel' => 'web',
            'message' => "[Website kitchen builder] Layout: " . ($data['layout'] ?? '—')
                . ", material: {$data['substrate']}, colour: " . ($data['colour'] ?? '—')
                . ", cabinets: {$modules}"
                . (! empty($data['accessories']) ? ', accessories: ' . implode(', ', $data['accessories']) : ''),
            'design_config' => [
                'source' => 'website_kitchen_builder',
                'section' => 'kitchen',
                'modules' => $data['modules'],
                'substrate' => $data['substrate'],
                'total_lm' => $data['total_lm'],
                'estimated_price' => $data['estimated_price'],
                'layout' => $data['layout'] ?? null,
                'colour' => $data['colour'] ?? null,
                'accessories' => $data['accessories'] ?? [],
                'locale' => $data['locale'] ?? 'en',
            ],
        ]);
    }

    private function post(array $payload): bool
    {
        $url = config('services.crm.inquiry_api_url');
        if (! $url) {
            Log::error('CRM inquiry URL not set (CRM_INQUIRY_API_URL) — lead not sent', ['payload' => $payload]);
            return false;
        }

        try {
            $response = Http::acceptJson()
                ->timeout(10)
                ->withToken((string) config('services.crm.inquiry_api_key'))
                ->post($url, $payload);

            if (! $response->successful()) {
                Log::error('CRM inquiry rejected', ['status' => $response->status(), 'body' => mb_substr($response->body(), 0, 500), 'payload' => $payload]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            // A failed CRM post never breaks the visitor's page. The lead is
            // kept in the log so nothing is lost; the visitor is asked to
            // call or message instead.
            Log::error('CRM inquiry submission failed', ['error' => $e->getMessage(), 'payload' => $payload]);
            return false;
        }
    }
}
