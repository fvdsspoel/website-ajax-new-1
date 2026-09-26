<?php

return [
    'phone_primary' => env('COMPANY_PHONE_PRIMARY', '09943648582'),
    'phone_secondary' => env('COMPANY_PHONE_SECONDARY', '09921496385'),
    'address' => env('COMPANY_ADDRESS', '281 Purok 6, Santisimo Road Brgy. Soledad, San Pablo City'),

    // Leave empty to hide the email line — the live site's addresses are
    // Cloudflare-obfuscated, so set the real one in .env rather than guess.
    'email' => env('COMPANY_EMAIL', ''),

    // Chat channels. Messenger page ID is the live site's; Viber and
    // WhatsApp default to the primary number in international format.
    'messenger_url' => env('COMPANY_MESSENGER_URL', 'https://m.me/61559238760421'),
    'whatsapp_number' => env('COMPANY_WHATSAPP', '639943648582'),
    'viber_number' => env('COMPANY_VIBER', '639943648582'),

    'social' => [
        'facebook' => 'https://www.facebook.com/profile.php?id=61559238760421',
        'instagram' => 'https://www.instagram.com/ajaxtradingcorporation/',
        'tiktok' => 'https://www.tiktok.com/@ajaxtradingcorpor',
        'youtube' => 'https://www.youtube.com/channel/UCXOD9PjiQAy_WMJ51ZwLZzQ',
        'shopee' => 'https://shopee.ph/shop/1355732891',
    ],

    // true on the temporary test site so Google doesn't index it.
    'noindex' => (bool) env('SITE_NOINDEX', false),

    'catalog_url' => env('COMPANY_CATALOG_URL', ''),

    // Public-site languages (SetLocale middleware + header toggle).
    'locales' => [
        'en' => 'English',
        'tl' => 'Tagalog',
    ],
];
