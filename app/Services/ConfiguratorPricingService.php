<?php

namespace App\Services;

/**
 * Prices a configurator design using the same shape of formula as the
 * ERP's CalculateBoardPriceService: raw material cost -> retail markup
 * -> price. This does NOT call the ERP directly (the public site has
 * no business talking to internal systems), but the constants below
 * (module widths, base rates) should be kept in sync with the ERP's
 * BoardPrice/MaterialPrice tables by whoever maintains pricing, rather
 * than drifting into a second, disconnected pricing model.
 *
 * Module widths follow the 32mm cabinetmaking system so every
 * combination a customer builds here is something the factory can
 * physically produce.
 */
class ConfiguratorPricingService
{
    /**
     * Linear-meter footprint per module type. Kept small and
     * explicit rather than freeform width entry, so results stay
     * within standard module sizing.
     */
    public const MODULE_TYPES = [
        'base'   => ['label' => 'Base cabinet', 'lm' => 0.6],
        'wall'   => ['label' => 'Wall cabinet', 'lm' => 0.6],
        'drawer' => ['label' => 'Drawer unit',  'lm' => 0.45],
        'corner' => ['label' => 'Corner unit',  'lm' => 0.9],
    ];

    /**
     * Placeholder per-linear-meter rates by substrate, in PHP pesos.
     * Replace with a live lookup against the ERP's BoardPrice /
     * MaterialPrice tables (see report Section 6) once the two
     * systems have an actual data bridge — do not let these drift
     * into a permanent second source of truth.
     */
    public const SUBSTRATE_RATES = [
        'melamine'    => ['label' => 'Melamine board',                 'rate_per_lm' => 2200],
        'marine_ply'  => ['label' => 'Laminated marine plywood',       'rate_per_lm' => 2800],
        'high_gloss'  => ['label' => 'Premium high-gloss finish',      'rate_per_lm' => 3600],
    ];

    /**
     * @param array<int, array{type: string}> $modules
     */
    public function price(array $modules, string $substrateKey): array
    {
        $substrate = self::SUBSTRATE_RATES[$substrateKey] ?? self::SUBSTRATE_RATES['melamine'];

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
