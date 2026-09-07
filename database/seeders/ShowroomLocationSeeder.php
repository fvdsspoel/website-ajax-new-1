<?php

namespace Database\Seeders;

use App\Models\ShowroomLocation;
use Illuminate\Database\Seeder;

/**
 * Only confirmed, currently-operating locations go here. Ajax has
 * showroom sites under lease review (Bamberton Center/Arca South,
 * and a site near SM San Pablo) — do NOT seed those as active
 * locations until a lease is actually signed and the space is open;
 * add them here when that's confirmed, not before.
 */
class ShowroomLocationSeeder extends Seeder
{
    public function run(): void
    {
        ShowroomLocation::updateOrCreate(
            ['name' => 'Ajax Trading Corporation — Head Office'],
            [
                'address' => 'Makati City, Philippines',
                'is_headquarters' => true,
                'is_factory' => false,
                'is_active' => true,
            ]
        );

        ShowroomLocation::updateOrCreate(
            ['name' => 'Ajax Trading Corporation — Production Facility'],
            [
                'address' => '281 Purok 6, Santisimo Road, Brgy. Soledad, San Pablo City, Laguna',
                'phone' => '09943648582',
                'is_headquarters' => false,
                'is_factory' => true,
                'is_active' => true,
            ]
        );
    }
}
