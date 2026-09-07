<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Melamine board', 'category' => 'boards', 'description' => 'Durable, easy-to-clean melamine boards in a wide range of colors and finishes, imported and quality-controlled in-house.'],
            ['name' => 'Laminated marine plywood', 'category' => 'boards', 'description' => 'Water-resistant marine plywood built for durability in kitchen and high-moisture applications.'],
            ['name' => 'Modular drawer systems', 'category' => 'storage', 'description' => 'Space-efficient drawer and pull-out systems for modular kitchens and cabinetry.'],
            ['name' => 'Pull-down pantry units', 'category' => 'storage', 'description' => 'High-quality pull-down pantry systems for maximizing kitchen storage.'],
            ['name' => 'Cabinet hardware', 'category' => 'hardware', 'description' => 'Hinges, runners, and fittings used across our modular kitchen and cabinet builds.'],
        ];

        foreach ($rows as $row) {
            Product::updateOrCreate(['name' => $row['name']], $row);
        }
    }
}
