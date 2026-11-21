<?php

// What the pages show, and which photo goes where. Texts are in lang/*/site.php.
return [
    // Homepage slideshow — real Ajax installations.
    'hero_slides' => [
        'images/projects/02/01.webp',
        'images/projects/15/01.webp',
        'images/projects/19/01.webp',
        'images/projects/18/01.webp',
        'images/projects/04/01.webp',
    ],

    // Numbers only the user stated: 400+ developer units, up to 3,000 lm a month,
    // 16 machines on the old site + the stone cutter, 1-year warranty.
    'stats' => [
        ['value' => 400, 'suffix' => '+', 'key' => 'units'],
        ['value' => 3000, 'suffix' => '', 'key' => 'capacity'],
        ['value' => 17, 'suffix' => '', 'key' => 'machines'],
        ['value' => 1, 'suffix' => '', 'key' => 'warranty'],
    ],

    // What we make — tile size on desktop: big (2×2), wide (2×1) or normal.
    'furniture' => [
        'kitchen' => ['icon' => 'kitchen', 'image' => 'images/projects/02/01.webp', 'size' => 'big', 'filter' => 'kitchen'],
        'wardrobe' => ['icon' => 'wardrobe', 'image' => 'images/projects/13/02.webp', 'size' => '', 'filter' => 'wardrobe'],
        'living' => ['icon' => 'tv', 'image' => 'images/projects/19/01.webp', 'size' => '', 'filter' => 'living'],
        'office' => ['icon' => 'office', 'image' => 'images/site/office-open.webp', 'size' => 'wide', 'filter' => 'commercial'],
        'stone' => ['icon' => 'stone', 'image' => 'images/projects/06/01.webp', 'size' => 'wide', 'filter' => 'kitchen'],
        'cladding' => ['icon' => 'wall', 'image' => 'images/projects/20/02.webp', 'size' => '', 'filter' => 'commercial'],
        'bath' => ['icon' => 'bath', 'image' => 'images/projects/17/03.webp', 'size' => '', 'filter' => 'kitchen'],
        'bedroom' => ['icon' => 'bed', 'image' => 'images/factory/walk-in-closet.webp', 'size' => '', 'filter' => 'wardrobe'],
        'accessories' => ['icon' => 'puzzle', 'image' => 'images/site/accessories.webp', 'size' => 'wide', 'filter' => 'kitchen'],
    ],

    // Our factory — machines by group. Photo in public/images/machines/<key>.webp,
    // or 'photo' for a real shot from the factory.
    'machine_groups' => [
        'cutting' => ['beam_saw', 'cnc_router', 'panel_saw'],
        'drilling' => ['six_sided', 'hinge'],
        'edging' => ['edge', 'curve_edge', 'bevel', 'polish'],
        'pressing' => ['hot_press', 'multi_press', 'cold_press', 'vacuum', 'gluing'],
        'stone' => ['stone_cutter'],
        'handling' => ['roller'],
    ],
    'machine_photos' => [
        'stone_cutter' => 'images/factory/stone-saw.webp',
    ],

    // Real shots from the factory floor (the reel on the factory page).
    'factory_reel' => [
        ['images/factory/stone-saw.webp', 'stone_cutter'],
        ['images/factory/stone-edge.webp', 'stone_edge'],
        ['images/factory/stone-polish.webp', 'stone_polish'],
        ['images/factory/edge-bander.webp', 'edge'],
        ['images/factory/team-assembly.webp', 'assembly'],
        ['images/factory/led-wiring.webp', 'led'],
        ['images/factory/testfit-kitchen.webp', 'testfit'],
        ['images/factory/hot-press-10.webp', 'multi_press'],
        ['images/factory/cnc-drill.webp', 'cnc_router'],
        ['images/factory/warehouse-2.webp', 'warehouse'],
        ['images/factory/sample-case.webp', 'samples'],
        ['images/factory/delivery-truck.webp', 'delivery'],
    ],

    // For the design selector: a real photo per style.
    'style_images' => [
        'handleless' => 'images/projects/03/01.webp',
        'handles' => 'images/projects/13/02.webp',
        'wood' => 'images/projects/06/01.webp',
        'dark' => 'images/projects/04/01.webp',
        'gloss' => 'images/projects/08/01.webp',
        'twotone' => 'images/projects/02/01.webp',
    ],
    'room_icons' => [
        'kitchen' => 'kitchen', 'wardrobe' => 'wardrobe', 'living' => 'tv', 'bedroom' => 'bed',
        'office' => 'office', 'bath' => 'bath', 'whole' => 'home', 'other' => 'puzzle',
    ],
    'colour_swatches' => [
        'white' => '#f4f3ef',
        'light' => 'linear-gradient(135deg,#d9d6cf,#c4bdb0)',
        'dark' => 'linear-gradient(135deg,#3a3d3f,#16181a)',
        'woodlight' => 'linear-gradient(135deg,#e2c89c,#c9a36b)',
        'wooddark' => 'linear-gradient(135deg,#7a4b2c,#3f2414)',
        'colour' => 'linear-gradient(135deg,#2f6f57,#2b4f86)',
    ],
];
