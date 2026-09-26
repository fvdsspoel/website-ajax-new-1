<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Kitchen and wardrobe accessories shown on /accessories.
 *
 * Wholesale boards (melamine, laminated marine plywood) are no longer
 * sold through the website, so any old 'boards' rows are removed.
 * Upload a real photo for each item via /admin/products.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::where('category', 'boards')->delete();
        Product::whereIn('category', ['storage'])->delete();

        $rows = [
            ['name' => 'Pull-out spice rack', 'category' => 'pullouts', 'description' => 'Slim pull-out rack that fits beside the cooktop, keeping spices, oils and sauces within reach.'],
            ['name' => 'Pull-out basket', 'category' => 'pullouts', 'description' => 'Soft-close wire basket for base cabinets — pots, pans and dry goods slide out instead of hiding at the back.'],
            ['name' => 'Pull-down pantry', 'category' => 'pullouts', 'description' => 'Lift-down shelving for high wall cabinets, so the top shelf is usable without a step stool.'],
            ['name' => 'Tall pantry unit', 'category' => 'pullouts', 'description' => 'Full-height pull-out pantry that turns one narrow tall cabinet into organized storage.'],
            ['name' => 'Magic corner', 'category' => 'corner', 'description' => 'Swing-out shelves that bring the blind corner of an L- or U-shaped kitchen to the front.'],
            ['name' => 'Corner carousel', 'category' => 'corner', 'description' => 'Rotating shelves for corner base cabinets — nothing lost in the corner again.'],
            ['name' => 'Waste bin set', 'category' => 'organizers', 'description' => 'Built-in pull-out bins under the sink, sized for segregating wet, dry and recyclable waste.'],
            ['name' => 'Cutlery tray', 'category' => 'organizers', 'description' => 'Drawer insert that keeps utensils and cutlery sorted and easy to clean.'],
            ['name' => 'Dish rack', 'category' => 'organizers', 'description' => 'Wall-cabinet or drawer dish rack so plates dry and store in the same place.'],
            ['name' => 'Smart sink', 'category' => 'sinks', 'description' => 'Stainless steel sink with touch-free flow for a cleaner, faster kitchen routine.'],
            ['name' => 'Soft-close hinges', 'category' => 'hardware', 'description' => 'Quiet, cushioned door closing on every cabinet we build.'],
            ['name' => 'Soft-close drawer runners', 'category' => 'hardware', 'description' => 'Full-extension runners so the whole drawer opens smoothly and closes gently.'],
            ['name' => 'Lift-up door system', 'category' => 'hardware', 'description' => 'Wall-cabinet doors that open upward and stay in place — no head bumps.'],
        ];

        foreach ($rows as $row) {
            Product::updateOrCreate(['name' => $row['name']], $row);
        }
    }
}
