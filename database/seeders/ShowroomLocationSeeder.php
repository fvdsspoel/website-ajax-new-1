<?php

namespace Database\Seeders;

use App\Models\ShowroomLocation;
use Illuminate\Database\Seeder;

/**
 * Only one showroom is currently open — San Pablo City (co-located
 * with the factory). Manila is a real upcoming location but NOT
 * open yet, so it's listed with is_upcoming = true and no confirmed
 * address, rather than being presented as available now.
 */
class ShowroomLocationSeeder extends Seeder
{
    public function run(): void
    {
        ShowroomLocation::updateOrCreate(
            ['name' => 'Ajax Trading Corporation — San Pablo City'],
            [
                'address' => '281 Purok 6, Santisimo Road, Brgy. Soledad, San Pablo City, Laguna',
                'phone' => '09943648582',
                'is_headquarters' => false,
                'is_factory' => true,
                'is_showroom' => true,
                'is_upcoming' => false,
                'is_active' => true,
            ]
        );

        ShowroomLocation::updateOrCreate(
            ['name' => 'Ajax Trading Corporation — Manila (opening soon)'],
            [
                'address' => 'Manila — exact location to be announced',
                'is_headquarters' => false,
                'is_factory' => false,
                'is_showroom' => true,
                'is_upcoming' => true,
                'is_active' => true,
            ]
        );
    }
}
