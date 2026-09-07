<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * Posts every lead-capturing form on the site (quote requests,
 * configurator submissions) directly into the CRM's Inquiry model,
 * tagged with the originating channel — replacing the previous
 * Messenger-only hand-off (see report Section 7).
 *
 * The CRM's Inquiry model already has a `design_config` JSON column
 * sitting unused for exactly the configurator's module list — see
 * CrmInquiryService::submitConfiguratorDesign().
 */
class CrmInquiryService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.crm.inquiry_api_url'),
            'timeout' => 5,
        ]);
    }

    public function submitQuoteRequest(array $data): bool
    {
        return $this->post([
            'name' => $data['name'],
            'contact' => $data['contact'],
            'channel' => 'website_quote_form',
            'message' => $data['message'] ?? null,
        ]);
    }

    /**
     * @param array{name: string, contact: string, modules: array, substrate: string, total_lm: float, estimated_price: float} $data
     */
    public function submitConfiguratorDesign(array $data): bool
    {
        return $this->post([
            'name' => $data['name'],
            'contact' => $data['contact'],
            'channel' => 'website_configurator',
            'message' => 'Design submitted via Build Your Own configurator.',
            'design_config' => [
                'modules' => $data['modules'],
                'substrate' => $data['substrate'],
                'total_lm' => $data['total_lm'],
                'estimated_price' => $data['estimated_price'],
            ],
        ]);
    }

    private function post(array $payload): bool
    {
        try {
            $response = $this->client->post('', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.crm.inquiry_api_key'),
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            return $response->getStatusCode() < 300;
        } catch (\Throwable $e) {
            // A failed CRM post should never break the customer's
            // experience — log it for follow-up and let the caller
            // decide how to degrade (e.g. show a "we'll be in touch"
            // message and email the team as a fallback).
            Log::error('CRM inquiry submission failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
