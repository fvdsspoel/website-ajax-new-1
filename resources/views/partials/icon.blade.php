{{-- Inline stroke icons (currentColor). Usage: @include('partials.icon', ['name' => 'phone']) --}}
@php
$paths = [
    'kitchen'   => '<rect x="3" y="11" width="18" height="10" rx="1"/><path d="M3 15h18M9 11v10M15 11v10"/><rect x="4" y="3" width="16" height="5" rx="1"/><path d="M12 3v5"/>',
    'building'  => '<rect x="4" y="3" width="11" height="18" rx="1"/><path d="M15 9h5v12h-5M8 7h3M8 11h3M8 15h3M11 21v-3H8v3"/>',
    'drawer'    => '<rect x="3" y="4" width="18" height="16" rx="1.5"/><path d="M3 12h18M10 8h4M10 16h4"/>',
    'phone'     => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/>',
    'chat'      => '<path d="M21 12a8 8 0 0 1-11.7 7.1L4 20.5l1.4-4.7A8 8 0 1 1 21 12Z"/>',
    'messenger' => '<path d="M12 3C7 3 3 6.7 3 11.4c0 2.6 1.3 5 3.3 6.5V21l3-1.7c.9.3 1.8.4 2.7.4 5 0 9-3.7 9-8.3S17 3 12 3Z"/><path d="m7.5 13.5 3-3.2 2 2 3-3.3"/>',
    'viber'     => '<path d="M6 3h12a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3h-6l-4 4v-4H6a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z"/><path d="M9 7.5c0 3 2.5 5.5 5.5 5.5l1-1.5-1.8-1-.9.8a4 4 0 0 1-2.1-2.1l.8-.9-1-1.8Z"/>',
    'whatsapp'  => '<path d="M3.5 20.5 5 16a8.5 8.5 0 1 1 3 3Z"/><path d="M9 8.5c0 3.5 3 6.5 6.5 6.5l1-1.5-2-1-1 .8a4.5 4.5 0 0 1-2.3-2.3l.8-1-1-2Z"/>',
    'check'     => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
    'menu'      => '<path d="M4 7h16M4 12h16M4 17h16"/>',
    'close'     => '<path d="M6 6l12 12M18 6 6 18"/>',
    'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6 8.5-6"/>',
    'pin'       => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.5"/>',
    'photo'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="10" r="2"/><path d="m21 16-5-5-9 8"/>',
    'drop'      => '<path d="M12 3s6 6.4 6 11a6 6 0 0 1-12 0c0-4.6 6-11 6-11Z"/>',
    'layers'    => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 13 9 5 9-5"/>',
    'hinge'     => '<rect x="4" y="3" width="6" height="18" rx="1"/><path d="M10 8h4a4 4 0 0 1 4 4v0a4 4 0 0 1-4 4h-4"/>',
    'bag'       => '<path d="M5 8h14l-1 12H6L5 8Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>',
    'facebook'  => '<path d="M14 21v-8h3l.5-3.5H14V7.8c0-1 .4-1.8 1.8-1.8H18V3a22 22 0 0 0-2.8-.1C12.6 2.9 11 4.5 11 7.3v2.2H8V13h3v8"/>',
    'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.7" r=".6"/>',
    'tiktok'    => '<path d="M14 3v11.5a3.5 3.5 0 1 1-3.5-3.5"/><path d="M14 3c.5 2.8 2.4 4.6 5 5"/>',
    'youtube'   => '<rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="m10 9 5 3-5 3V9Z"/>',
];
@endphp
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">{!! $paths[$name] ?? '' !!}</svg>
