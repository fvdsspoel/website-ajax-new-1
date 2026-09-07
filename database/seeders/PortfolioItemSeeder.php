<?php

namespace Database\Seeders;

use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;

/**
 * Real projects, extracted from 2026_AJAX_TRADING_CORP_PORTFOLIO_REV_1.pdf
 * (the company's own portfolio deck). Titles/descriptions are real;
 * image_url is intentionally left null for every row — the PDF's
 * photos weren't committed into this repo (89MB of embedded images
 * has no business bloating a git history). Upload the actual photos
 * for each project through /admin/portfolio once that's live —
 * matching by title makes it easy to find the right row.
 */
class PortfolioItemSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // Kitchens
            ['title' => 'Contemporary two-tone kitchen design', 'category' => 'kitchen', 'description' => 'A modern two-tone kitchen with latte lower cabinets, dark gray uppers, and a sleek dining area, illuminated by under-cabinet lighting for a clean, contemporary look.'],
            ['title' => 'Contemporary kitchen with central island', 'category' => 'kitchen', 'description' => 'A modern kitchen with dark blue lower cabinets, stone finish uppers, and speckled stone countertops.'],
            ['title' => 'Minimalist handleless kitchen', 'category' => 'kitchen', 'description' => 'A sleek and minimalist kitchen design featuring handleless cabinetry, warm integrated LED lighting, and a clean neutral palette that creates a sophisticated and functional space.'],
            ['title' => 'L-shaped white kitchen cabinetry', 'category' => 'kitchen', 'description' => 'Modern, handle-less white cabinetry designed with an L-shaped layout, featuring a seamless marble-look countertop and an integrated stainless steel sink.'],
            ['title' => 'Dark wood and beige kitchen', 'category' => 'kitchen', 'description' => 'A stylish kitchen featuring dark wood and beige cabinetry, a sleek breakfast bar and modern accents illuminated by under-cabinet lighting.'],
            ['title' => 'Modern black and gold kitchen', 'category' => 'kitchen', 'description' => 'A sleek L-shaped kitchen with black cabinetry and gold handles, paired with white marble countertops and herringbone wood flooring for a luxurious contemporary look.'],
            ['title' => 'Custom U-shaped kitchen cabinetry', 'category' => 'kitchen', 'description' => 'Custom U-shaped kitchen with handle-less light mocha cabinets and LED-lit wood accent shelving.'],
            ['title' => 'Mahogany straight kitchen counter', 'category' => 'kitchen', 'description' => 'Straight kitchen counter featuring handle-less mahogany wood finish laminate lower cabinets, with a marble-patterned countertop.'],
            ['title' => 'Modern kitchen counter & storage overhead cabinets', 'category' => 'kitchen', 'description' => 'Minimalist kitchen cabinetry featuring handle-less white overhead storage, warm wood countertops, and integrated LED accent lighting above and below.'],
            ['title' => 'Modern handle-less kitchen cabinetry with integrated LED lighting', 'category' => 'kitchen', 'description' => 'Seamless kitchen cabinetry featuring handle-less panels, dual sink basins, a stainless steel countertop, and a dark marble-look backsplash with LED accent lighting.'],
            ['title' => 'White and wood / dark grey L-shaped kitchen', 'category' => 'kitchen', 'description' => 'A modern kitchen with crisp white cabinetry, wood-finish lower cabinets, and a sleek L-shaped layout with dark grey cabinetry.'],
            ['title' => 'Glossy beige L-shaped kitchen', 'category' => 'kitchen', 'description' => 'A sleek modern kitchen with glossy beige cabinetry, white quartz countertops, and under-cabinet lighting for a bright, contemporary look.'],
            ['title' => 'Contemporary modern kitchen', 'category' => 'kitchen', 'description' => 'A contemporary U-shaped kitchen with white upper cabinets, dark brown lowers, and marble countertops.'],
            ['title' => 'Turquoise and white U-shaped kitchen', 'category' => 'kitchen', 'description' => 'A vibrant modern kitchen with turquoise lower cabinets, white glass-front uppers, and light countertops with natural light.'],
            ['title' => 'Beige kitchen', 'category' => 'kitchen', 'description' => 'A bright modern kitchen with sleek beige cabinetry and marble-patterned countertops.'],
            ['title' => 'Modern two-tone kitchen with warm ambient lighting', 'category' => 'kitchen', 'description' => null],
            ['title' => 'Symmetrical white cabinetry / L-shape design', 'category' => 'kitchen', 'description' => 'Symmetrical white cabinetry surrounding a textured grey niche, complete with an integrated stovetop, under-cabinet warm strip lighting, and toe-kick illumination.'],
            ['title' => 'Navy and wood modern kitchen', 'category' => 'kitchen', 'description' => 'A contemporary kitchen with matte navy cabinetry, warm wood finishes, and elegant gold accents, illuminated by under-cabinet and base lighting for a sleek, inviting look.'],
            ['title' => 'Modern executive kitchen island & cabinetry set', 'category' => 'kitchen', 'description' => 'Dark wood finish island unit featuring a tiered white marble-veined countertop, integrated prep sink, and matching full-height wall cabinetry setup.'],

            // Wardrobes & closets
            ['title' => 'Luxe walk-in closet', 'category' => 'wardrobe', 'description' => 'A modern walk-in closet with dark wood cabinetry, warm accent lighting, and a chic vanity area, blending functionality with elegant design.'],
            ['title' => 'Handle-less white & wood wardrobe', 'category' => 'wardrobe', 'description' => 'Custom floor-to-ceiling wardrobe featuring handle-less matte white panels integrated with warm natural wood open shelving and a matching wooden plinth.'],
            ['title' => 'Natural wood wardrobe', 'category' => 'wardrobe', 'description' => 'Floor-to-ceiling built-in wardrobe crafted in warm wood laminate, complete with long matte black vertical handles.'],
            ['title' => 'Modern woodgrain modular wardrobe cabinet with open side shelves', 'category' => 'wardrobe', 'description' => 'A modern modular wardrobe with dual hanging sections, top shelves, and bottom drawers for organized storage, finished in clean white interior.'],

            // Custom furniture
            ['title' => 'Media console with wood laminate side column', 'category' => 'commercial', 'description' => 'Media console unit featuring white pull-out storage drawers paired with an integrated warm wood laminate side column.'],
            ['title' => 'Minimalist modern media console & accent wall unit', 'category' => 'commercial', 'description' => null],
            ['title' => 'Marble and wood TV console', 'category' => 'commercial', 'description' => 'A contemporary TV console featuring a white marble backdrop with wooden slats, sleek drawers, and open compartments, blending elegance with modern functionality.'],
            ['title' => 'Custom LED-lit perfume display cabinet', 'category' => 'commercial', 'description' => 'Floor-to-ceiling vanity unit featuring warm wood grain open shelving with integrated LED lighting and glass shelves.'],
            ['title' => 'Shoe cabinet and storage', 'category' => 'commercial', 'description' => 'Built-in foyer storage unit featuring a matte white shoe cabinet and seating bench, accented by vertical wood fluted wall paneling.'],
            ['title' => 'Pantry shelves', 'category' => 'commercial', 'description' => 'A custom-built open shelving unit with integrated LED strip lighting, designed to maximize vertical storage while maintaining a clean and modern aesthetic.'],

            // Commercial & institutional
            ['title' => 'Office locker and medical storage', 'category' => 'commercial', 'description' => null],
            ['title' => 'Office partitions & workstations', 'category' => 'commercial', 'description' => 'Designed for organized, space-efficient, and productive work areas, in wood cedar matte finish and white matte.'],
            ['title' => 'Modern two-tone commercial locker unit', 'category' => 'commercial', 'description' => 'Full-height storage lockers with latte and ash brown key-locked doors, framed in a light wood grain laminate casing.'],
            ['title' => 'Institutional desk & chair sets', 'category' => 'commercial', 'description' => 'Mass-produced student desk and chair set featuring precision-cut wood-grain laminate tops and matching backrest/seat boards engineered for high-volume supply.'],
            ['title' => 'Custom table — bar counter & island table', 'category' => 'commercial', 'description' => 'Wall-mounted bar counter table with a smooth off-white laminate top for high-density seating, paired with a minimalist freestanding island table with a solid white top and cedar wood laminate base.'],
            ['title' => 'Retail kiosk displays', 'category' => 'commercial', 'description' => 'A vibrant mall kiosk featuring illuminated shelves and a branded front panel, designed to showcase and promote a brand in an eye-catching way.'],
        ];

        foreach ($rows as $row) {
            PortfolioItem::updateOrCreate(
                ['title' => $row['title']],
                $row + ['image_url' => null, 'is_featured' => false]
            );
        }
    }
}
