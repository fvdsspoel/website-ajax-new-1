{{-- Front-view sketch of a style for a room type, used in the design selector when
     we have no real Ajax photo of that exact style for that room.
     $set: wardrobe | living | office | bath | other   ·   $style: handleless | handles | wood | dark | gloss | twotone --}}
@php
    $pal = [
        'white' => '#f4f2ed', 'line' => '#cfc8ba', 'wood' => '#b88a5c', 'woodDark' => '#8f6440',
        'dark' => '#2c2d2f', 'darkLine' => '#47494c', 'stone' => '#ecebe7', 'bar' => '#1d1d1d',
    ];
    $uid = 'sk'.$set.$style;
    // Door colour for a door; $part = 'upper' | 'lower' (only matters for two-tone).
    $fill = function ($part = 'lower') use ($style, $pal, $uid) {
        return match ($style) {
            'wood' => "url(#{$uid}g)",
            'dark' => $pal['dark'],
            'twotone' => $part === 'upper' ? $pal['white'] : "url(#{$uid}g)",
            'gloss' => "url(#{$uid}s)",
            default => $pal['white'],
        };
    };
    $stroke = $style === 'dark' ? $pal['darkLine'] : $pal['line'];
    // One door: panel + handle (handles style) or bevel groove (handleless/dark/gloss).
    $door = function ($x, $y, $w, $h, $part = 'lower', $hingeLeft = true) use ($fill, $stroke, $style, $pal) {
        $s = "<rect x='$x' y='$y' width='$w' height='$h' rx='1.5' fill='{$fill($part)}' stroke='$stroke' stroke-width='1.4'/>";
        if ($style === 'handles' || $style === 'wood' || $style === 'twotone') {
            $hx = $hingeLeft ? $x + $w - 9 : $x + 6;
            $hl = min(60, $h * .45);
            $hy = $y + ($h - $hl) / 2;
            $s .= "<rect x='$hx' y='$hy' width='3.5' height='$hl' rx='1.5' fill='{$pal['bar']}'/>";
        } else {
            $s .= "<rect x='".($x + 2)."' y='".($y + 2)."' width='".($w - 4)."' height='3' fill='".($style === 'dark' ? '#151617' : '#bdb5a5')."' opacity='.8'/>";
        }
        return $s;
    };
    $svg = '';
    switch ($set) {
        case 'wardrobe':
            $svg .= "<rect x='60' y='22' width='280' height='254' fill='$stroke'/>";
            for ($i = 0; $i < 4; $i++) {
                $x = 63 + $i * 69;
                $svg .= $door($x, 25, 66, 52, 'upper', $i % 2 === 0);
                $svg .= $door($x, 80, 66, 193, 'lower', $i % 2 === 0);
            }
            break;
        case 'living':
            $svg .= "<rect x='70' y='38' width='260' height='150' rx='2' fill='".($style === 'gloss' ? "url(#{$uid}s)" : ($style === 'dark' ? '#3a3b3d' : '#e6e1d6'))."'/>";
            $svg .= "<rect x='130' y='70' width='140' height='80' rx='3' fill='#141516'/>";
            $svg .= "<rect x='40' y='196' width='320' height='8' fill='".($style === 'dark' ? $pal['dark'] : $pal['stone'])."' stroke='$stroke'/>";
            for ($i = 0; $i < 4; $i++) $svg .= $door(40 + $i * 80, 204, 80, 52, $i % 2 ? 'upper' : 'lower', $i % 2 === 0);
            break;
        case 'office':
            $svg .= "<rect x='70' y='40' width='260' height='60' fill='$stroke'/>";
            for ($i = 0; $i < 3; $i++) $svg .= $door(73 + $i * 85.5, 43, 82, 54, 'upper', $i % 2 === 0);
            $svg .= "<rect x='40' y='168' width='320' height='10' fill='".($style === 'dark' ? $pal['dark'] : $pal['stone'])."' stroke='$stroke'/>";
            for ($i = 0; $i < 3; $i++) $svg .= $door(270, 180 + $i * 32, 86, 30, 'lower', false);
            $svg .= "<rect x='46' y='178' width='8' height='96' fill='$stroke'/>";
            break;
        case 'bath':
            $svg .= "<rect x='120' y='34' width='160' height='100' rx='50' fill='#dfe6ea' stroke='$stroke'/>";
            $svg .= "<rect x='80' y='168' width='240' height='10' fill='".($style === 'dark' ? $pal['dark'] : $pal['stone'])."' stroke='$stroke'/>";
            $svg .= "<ellipse cx='200' cy='166' rx='46' ry='9' fill='#fff' stroke='$stroke'/>";
            $svg .= $door(83, 180, 234, 24, 'upper', false);
            $svg .= $door(83, 207, 115, 55, 'lower', true) . $door(202, 207, 115, 55, 'lower', false);
            break;
        default: // sideboard / any cabinet
            $svg .= "<rect x='50' y='140' width='300' height='10' fill='".($style === 'dark' ? $pal['dark'] : $pal['stone'])."' stroke='$stroke'/>";
            for ($i = 0; $i < 3; $i++) $svg .= $door(52 + $i * 99, 152, 97, 108, $i === 1 ? 'upper' : 'lower', $i !== 2);
    }
@endphp
<svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
    <defs>
        <linearGradient id="{{ $uid }}g" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="#c39467"/><stop offset=".35" stop-color="#ad7f52"/><stop offset=".6" stop-color="#c79a6c"/><stop offset="1" stop-color="#a87a4e"/>
        </linearGradient>
        <linearGradient id="{{ $uid }}s" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#ffffff"/><stop offset=".42" stop-color="#f1f1f3"/><stop offset=".5" stop-color="#ffffff"/><stop offset=".58" stop-color="#e9e9ec"/><stop offset="1" stop-color="#f7f7f9"/>
        </linearGradient>
    </defs>
    <rect width="400" height="300" fill="#f6f2ea"/>
    <rect y="276" width="400" height="24" fill="#e4dccd"/>
    {!! $svg !!}
</svg>
