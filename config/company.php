<?php

return [
    'phone_primary' => env('COMPANY_PHONE_PRIMARY', '0994 364 8582'),
    'phone_secondary' => env('COMPANY_PHONE_SECONDARY', '0992 149 6385'),
    // Third line (FM) — on the Facebook page and the Google Business Profile.
    'phone_fm' => env('COMPANY_PHONE_FM', '0945 603 5520'),
    'address' => env('COMPANY_ADDRESS', '281 Purok 6, Santisimo Road, Brgy. Soledad, San Pablo City, Laguna'),
    // Small office line (Makati). Main address stays the San Pablo factory & showroom.
    'office_address' => env('COMPANY_OFFICE_ADDRESS', 'Unit 2201, 22/F Cityland Pasong Tamo Tower, 2210 Don Chino Roces Ave, Makati City'),
    'hours' => env('COMPANY_HOURS', 'Mon – Sat · 7:00 AM – 7:00 PM'),
    'map_url' => env('COMPANY_MAP_URL', 'https://maps.google.com/?q=Ajax+Trading+Corporation+San+Pablo+City+Laguna'),
    'map_embed' => env('COMPANY_MAP_EMBED', 'https://maps.google.com/maps?q=Santisimo%20Road%20Soledad%20San%20Pablo%20City%20Laguna&z=15&output=embed'),

    // Leave empty to hide the email line — the live site's addresses are
    // Cloudflare-obfuscated, so set the real one in .env rather than guess.
    'email' => env('COMPANY_EMAIL', 'sales.ajaxtradingcorporation@gmail.com'),

    // Chat channels. Messenger page ID is the live site's; Viber and
    // WhatsApp default to the primary number in international format.
    'messenger_url' => env('COMPANY_MESSENGER_URL', 'https://m.me/61559238760421'),
    'whatsapp_number' => env('COMPANY_WHATSAPP', '639921496385'),          // as on the Facebook page (21 Nov 2026)
    'viber_number' => env('COMPANY_VIBER', '639943648582'),

    // The Facebook page (also used for the live page feed on the homepage).
    'facebook_page' => env('COMPANY_FACEBOOK_PAGE', 'https://www.facebook.com/profile.php?id=61559238760421'),

    'social' => [
        'facebook' => env('COMPANY_FACEBOOK_PAGE', 'https://www.facebook.com/profile.php?id=61559238760421'),
        'instagram' => 'https://www.instagram.com/ajaxtradingcorporation_2024/',
        'tiktok' => 'https://www.tiktok.com/@ajaxtradingcorpor',
        'youtube' => 'https://www.youtube.com/channel/UCXOD9PjiQAy_WMJ51ZwLZzQ',
        'x' => 'https://x.com/ajaxtradingco',
        'shopee' => 'https://shopee.ph/shop/1355732891',
    ],

    // Marketing tags — empty = not loaded. Meta Pixel lets Facebook ads
    // measure who sent a quote request; GA4 counts visitors.
    'meta_pixel_id' => env('META_PIXEL_ID', ''),
    'ga4_id' => env('GA4_MEASUREMENT_ID', ''),

    // Google Ads (account 564-160-6996). The tag loads on every page; the
    // "Request quote" conversion fires once after a quote / design request
    // is sent. Set GOOGLE_ADS_ID= (empty) in .env to switch it off.
    'google_ads_id' => env('GOOGLE_ADS_ID', 'AW-18588478601'),
    'google_ads_lead_label' => env('GOOGLE_ADS_LEAD_LABEL', 'Bst8CNyq8bwdEInZ1p9F'),

    // true on the temporary test site so Google doesn't index it.
    'noindex' => (bool) env('SITE_NOINDEX', false),

    'catalog_url' => env('COMPANY_CATALOG_URL', ''),

    // Public-site languages (SetLocale middleware + header toggle).
    // Short label shown in the header toggle; a missing text falls back to English.
    'locales' => [
        'en' => 'English',
        'tl' => 'Tagalog',
        'ceb' => 'Bisaya (Cebuano)',
    ],
    'locale_short' => ['en' => 'EN', 'tl' => 'TL', 'ceb' => 'BIS'],
];
