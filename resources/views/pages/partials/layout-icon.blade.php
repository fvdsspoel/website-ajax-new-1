{{-- Small top-view / front-view drawing of a layout choice --}}
@php
$draw = [
    'kitchen.straight' => '<rect x="8" y="10" width="84" height="14" rx="2"/>',
    'kitchen.l_shape' => '<rect x="8" y="10" width="84" height="14" rx="2"/><rect x="8" y="24" width="14" height="32" rx="2"/>',
    'kitchen.u_shape' => '<rect x="8" y="10" width="84" height="14" rx="2"/><rect x="8" y="24" width="14" height="32" rx="2"/><rect x="78" y="24" width="14" height="32" rx="2"/>',
    'kitchen.island' => '<rect x="8" y="10" width="84" height="14" rx="2"/><rect x="28" y="38" width="44" height="16" rx="2"/>',
    'kitchen.parallel' => '<rect x="8" y="10" width="84" height="14" rx="2"/><rect x="8" y="44" width="84" height="14" rx="2"/>',
    'wardrobe.hinged' => '<rect x="20" y="6" width="60" height="54" rx="2"/><path d="M35 6v54M50 6v54M65 6v54"/>',
    'wardrobe.sliding' => '<rect x="20" y="6" width="60" height="54" rx="2"/><rect x="22" y="8" width="30" height="50"/><rect x="48" y="8" width="30" height="50"/>',
    'wardrobe.walk_in' => '<path d="M14 10h72v46M14 10v46"/><rect x="14" y="10" width="72" height="10"/><rect x="14" y="20" width="10" height="36"/><rect x="76" y="20" width="10" height="36"/>',
    'wardrobe.open' => '<rect x="20" y="6" width="60" height="54" rx="2"/><path d="M20 20h60M20 34h60M20 48h60"/>',
    'living.console' => '<rect x="30" y="12" width="40" height="22" rx="2"/><rect x="14" y="42" width="72" height="12" rx="2"/>',
    'living.wall' => '<rect x="8" y="6" width="84" height="54" rx="2"/><rect x="32" y="14" width="36" height="20" rx="1"/><path d="M8 44h84"/>',
    'living.shelves' => '<rect x="14" y="6" width="72" height="54" rx="2"/><path d="M14 20h72M14 34h72M14 48h72M50 6v54"/>',
    'living.divider' => '<path d="M50 6v54"/><rect x="36" y="6" width="28" height="54" rx="2"/><path d="M36 20h28M36 34h28M36 48h28"/>',
    'other.single' => '<rect x="34" y="16" width="32" height="40" rx="2"/>',
    'other.room' => '<rect x="10" y="8" width="80" height="50" rx="3"/><rect x="14" y="12" width="30" height="10"/><rect x="58" y="40" width="28" height="14"/>',
    'other.several' => '<rect x="8" y="8" width="38" height="24" rx="2"/><rect x="54" y="8" width="38" height="24" rx="2"/><rect x="8" y="36" width="84" height="22" rx="2"/>',
    'other.project' => '<rect x="10" y="8" width="18" height="50"/><rect x="34" y="20" width="18" height="38"/><rect x="58" y="14" width="18" height="44"/><path d="M6 58h88"/>',
];
@endphp
<svg class="layout-svg" viewBox="0 0 100 64" fill="rgba(30,138,74,.14)" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true">{!! $draw[$set.'.'.$key] ?? '' !!}</svg>
