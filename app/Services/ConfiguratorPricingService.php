<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Prices a configurator design using the ERP's public pricing feed
 * (routes/api.php -> /api/public/substrate-prices on the ERP) rather
 * than a second, disconnected set of numbers. Rates are cached for
 * an hour so a normal page load never waits on the ERP, and fall
 * back to the constants below if the ERP is unreachable — a
 * stale-but-plausible price beats a broken configurator.
 *
 * Module widths follow the 32mm cabinetmaking system so every
 * combination a customer builds here is something the factory can
 * physically produce.
 */
class ConfiguratorPricingService
{
    public const MODULE_TYPES = [
        'base'   => ['label' => 'Base cabinet', 'lm' => 0.6],
        'wall'   => ['label' => 'Wall cabinet', 'lm' => 0.6],
        'drawer' => ['label' => 'Drawer unit',  'lm' => 0.45],
        'corner' => ['label' => 'Corner unit',  'lm' => 0.9],
    ];

    /**
     * Fallback only — used when the ERP's pricing feed can't be
     * reached. Keep these roughly in sync manually; they are not
     * the source of truth once the feed is live.
     */
    private const FALLBACK_RATES = [
        'melamine'    => ['label' => 'Melamine board',                 'rate_per_lm' => 2200],
        'marine_ply'  => ['label' => 'Laminated marine plywood',       'rate_per_lm' => 2800],
        'high_gloss'  => ['label' => 'Premium high-gloss finish',      'rate_per_lm' => 3600],
    ];

    /**
     * @return array<string, array{label: string, rate_per_lm: float}>
     */
    public function substrateRates(): array
    {
        return Cache::remember('erp.public_substrate_prices', now()->addHour(), function () {
            try {
                $client = new Client(['timeout' => 3]);
                $response = $client->get(config('services.erp.public_pricing_url'), [
                    'headers' => ['X-Api-Key' => config('services.erp.public_pricing_api_key')],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                $rates = [];
                foreach ($data['substrates'] ?? [] as $row) {
                    $rates[$row['key']] = [
                        'label' => $row['label'],
                        'rate_per_lm' => (float) $row['rate_per_lm'],
                    ];
                }

                return $rates ?: self::FALLBACK_RATES;
            } catch (\Throwable $e) {
                Log::warning('ERP pricing feed unreachable, using fallback rates', ['error' => $e->getMessage()]);
                return self::FALLBACK_RATES;
            }
        });
    }

    /**
     * @param array<int, array{type: string}> $modules
     */
    public function price(array $modules, string $substrateKey): array
    {
        $rates = $this->substrateRates();
        $substrate = $rates[$substrateKey] ?? reset($rates);

        $totalLm = 0.0;
        foreach ($modules as $module) {
            $type = self::MODULE_TYPES[$module['type']] ?? null;
            if ($type) {
                $totalLm += $type['lm'];
            }
        }

        $estimate = $totalLm * $substrate['rate_per_lm'];

        return [
            'total_lm' => round($totalLm, 2),
            'substrate_label' => $substrate['label'],
            'estimated_price' => round($estimate, 2),
        ];
    }
}
