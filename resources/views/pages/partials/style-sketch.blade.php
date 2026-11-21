{{-- Front-view drawing of one style for one room type — used for every tile in step 3 of
     "Design your space" (same look everywhere; a back-office upload can replace one).
     Light comes from the top left: soft shading on every panel, metal handles, real wood
     grain, stone counter edge, floor shadow, LED light under kitchen wall cabinets.
     $set: kitchen | wardrobe | living | office | bath | other
     $style: handleless | handles | wood | dark | gloss | twotone --}}
@php
    $u = ($prefix ?? 'sk').'-'.$set.'-'.$style;   // own ids per use, so a copy elsewhere on the page never borrows hidden gradients
    $C = ['line' => '#bfb5a4', 'white' => '#f6f4ef', 'dark' => "url(#$u-dark)", 'darkEdge' => '#151618', 'glass' => "url(#$u-mirror)"];
    $isDark = $style === 'dark';
    $handles = $style === 'handles';
    $fill = fn ($part = 'base') => match ($style) {
        'wood' => "url(#$u-wood)",
        'dark' => $C['dark'],
        'gloss' => "url(#$u-gloss)",
        'twotone' => $part === 'top' ? $C['white'] : "url(#$u-wood)",
        default => $C['white'],
    };
    $edge = $isDark ? $C['darkEdge'] : $C['line'];
    $groove = $isDark ? '#0c0c0d' : 'rgba(70,52,34,.45)';

    // Panel with soft light (top-left bright, bottom darker) and a gloss streak for high-gloss.
    $panel = function ($x, $y, $w, $h, $part) use ($fill, $edge, $style, $u) {
        $s = "<rect x='$x' y='$y' width='$w' height='$h' rx='1.4' fill='{$fill($part)}' stroke='$edge' stroke-width='1'/>";
        $s .= "<rect x='$x' y='$y' width='$w' height='$h' rx='1.4' fill='url(#$u-".($style === 'dark' ? 'shadeDark' : 'shade').")'/>";   // matt dark: almost no sheen
        if ($style === 'gloss') {
            $s .= "<path d='M".($x + $w * .14).' '.($y + 3).'H'.($x + $w * .34).'L'.($x + $w * .12).' '.($y + $h - 3).'H'.($x + 3).'V'.($y + $h * .55)."Z' fill='#fff' opacity='.7'/>";
            $s .= "<path d='M".($x + $w * .44).' '.($y + 3).'H'.($x + $w * .5).'L'.($x + $w * .3).' '.($y + $h - 3).'H'.($x + $w * .24)."Z' fill='#fff' opacity='.5'/>";
        }
        return $s;
    };
    $bar = fn ($x, $y, $w, $h) => "<rect x='".($x + .8)."' y='".($y + 1)."' width='$w' height='$h' rx='1.5' fill='rgba(0,0,0,.18)'/><rect x='$x' y='$y' width='$w' height='$h' rx='1.5' fill='url(#$u-metal)'/>";
    $door = function ($x, $y, $w, $h, $part = 'base', $openRight = true) use ($panel, $bar, $handles, $groove) {
        $s = $panel($x, $y, $w, $h, $part);
        if ($handles) {
            $hl = min(46, $h * .42);
            $hx = $openRight ? $x + $w - 8 : $x + 5;
            $hy = $h > 120 ? $y + ($h - $hl) / 2 : ($part === 'top' ? $y + $h - $hl - 6 : $y + 6);
            $s .= $bar($hx, $hy, 3.2, $hl);
        } else {
            $s .= "<rect x='".($x + 1.5)."' y='".($y + 1.2)."' width='".($w - 3)."' height='2.8' fill='$groove'/>";
        }
        return $s;
    };
    $drawer = function ($x, $y, $w, $h, $part = 'base') use ($panel, $bar, $handles, $groove) {
        $s = $panel($x, $y, $w, $h, $part);
        $s .= $handles ? $bar($x + $w * .3, $y + 5, $w * .4, 3.2) : "<rect x='".($x + 1.5)."' y='".($y + 1.2)."' width='".($w - 3)."' height='2.6' fill='$groove'/>";
        return $s;
    };
    // Stone counter: top surface, lit front edge, shadow line underneath.
    $counter = fn ($x, $y, $w) => "<rect x='$x' y='".($y + 7)."' width='$w' height='3' fill='rgba(0,0,0,.12)'/>"
        ."<rect x='$x' y='$y' width='$w' height='7' rx='1' fill='url(#$u-stone)'/>"
        ."<rect x='$x' y='$y' width='$w' height='1.4' fill='#fff' opacity='".($isDark ? '.18' : '.9')."'/>";
    $plinth = fn ($x, $y, $w) => "<rect x='".($x + 3)."' y='$y' width='".($w - 6)."' height='8' fill='".($isDark ? '#141516' : '#cfc4b1')."'/>";
    $floorShadow = fn ($x, $y, $w) => "<ellipse cx='".($x + $w / 2)."' cy='$y' rx='".($w / 2 + 10)."' ry='6' fill='rgba(50,35,20,.22)' filter='url(#$u-blur)'/>";
    $side = fn ($x, $y, $h) => "<rect x='$x' y='$y' width='4' height='$h' fill='".($isDark ? '#1f2023' : '#e4ddd0')."' stroke='$edge' stroke-width='.6'/>";

    $svg = '';
    switch ($set) {
        case 'kitchen':
            $svg .= "<rect x='44' y='120' width='312' height='58' fill='url(#$u-tile)'/>";
            $svg .= "<rect x='44' y='120' width='312' height='14' fill='url(#$u-led)'/>";          // warm LED under the wall cabinets
            $svg .= $door(44, 46, 76, 74, 'top', false) . $door(122, 46, 76, 74, 'top', true);
            $svg .= "<path d='M214 46H266V92L280 116H200L214 92Z' fill='url(#$u-steel)' stroke='#a9adb1' stroke-width='.8'/><rect x='200' y='114' width='80' height='4' fill='#8d9296'/>";
            $svg .= $door(280, 46, 76, 74, 'top', false);
            $svg .= "<rect x='44' y='120' width='312' height='2' fill='rgba(0,0,0,.14)'/>";
            $svg .= $floorShadow(44, 268, 312);
            $svg .= $counter(40, 178, 320);
            $svg .= "<rect x='142' y='175' width='54' height='4' rx='2' fill='#b9bfc5'/><path d='M170 175V158Q170 154 175 154H180' stroke='url(#$u-steel)' stroke-width='3' fill='none' stroke-linecap='round'/>";
            $svg .= $door(44, 188, 62, 70, 'base', true) . $door(108, 188, 62, 70, 'base', false) . $door(172, 188, 62, 70, 'base', true);
            $svg .= $drawer(236, 188, 120, 22) . $drawer(236, 212, 120, 22) . $drawer(236, 236, 120, 22);
            $svg .= $plinth(44, 258, 312);
            break;
        case 'wardrobe':
            $svg .= $floorShadow(62, 268, 276);
            $svg .= $side(62, 28, 240) . $side(334, 28, 240);
            for ($i = 0; $i < 4; $i++) {
                $x = 66 + $i * 67;
                $svg .= $door($x, 28, 66, 46, 'top', $i % 2 === 1);
                $svg .= $door($x, 76, 66, 184, 'base', $i % 2 === 1);
            }
            $svg .= $plinth(66, 260, 268);
            break;
        case 'living':
            $wall = match ($style) { 'gloss' => "url(#$u-marble)", 'dark' => "url(#$u-dark)", 'wood', 'twotone' => "url(#$u-wood)", default => '#e8e1d4' };
            $svg .= "<rect x='92' y='26' width='216' height='176' rx='2' fill='$wall' stroke='$edge' stroke-width='.8'/><rect x='92' y='26' width='216' height='176' fill='url(#$u-shade)'/>";
            $svg .= "<rect x='92' y='196' width='216' height='6' fill='rgba(255,214,150,.55)' filter='url(#$u-blur)'/>";
            $svg .= "<rect x='134' y='60' width='132' height='78' rx='3' fill='#0f1113'/><rect x='138' y='64' width='124' height='70' rx='2' fill='url(#$u-screen)'/>";
            $svg .= $floorShadow(56, 262, 288);
            $svg .= $counter(56, 202, 288);
            $p = $style === 'twotone' ? 'top' : 'base';
            $svg .= $drawer(56, 212, 70, 40, $p) . $door(128, 212, 70, 40, 'base', true) . $door(200, 212, 70, 40, 'base', false) . $drawer(272, 212, 72, 40, $p);
            break;
        case 'bedroom':
            // headboard wall panel · bed · two floating side tables with a drawer · pendant lights
            $wallPanel = $style === 'twotone' ? $C['white'] : ($style === 'gloss' ? "url(#$u-gloss)" : $fill('top'));
            $svg .= "<rect x='98' y='64' width='204' height='140' rx='2' fill='$wallPanel' stroke='$edge' stroke-width='.8'/><rect x='98' y='64' width='204' height='140' fill='url(#$u-".($isDark ? 'shadeDark' : 'shade').")'/>";
            for ($k = 1; $k < 6; $k++) $svg .= "<rect x='".(98 + $k * 34)."' y='64' width='1' height='140' fill='rgba(0,0,0,.08)'/>";   // panel joints
            foreach ([76, 324] as $lx) $svg .= "<path d='M$lx 0V104' stroke='#6b6157' stroke-width='1'/><path d='M".($lx - 9)." 116L$lx 104L".($lx + 9)." 116Z' fill='#2c2b29'/><ellipse cx='$lx' cy='118' rx='12' ry='5' fill='rgba(255,214,150,.55)' filter='url(#$u-blur)'/>";
            $svg .= $floorShadow(108, 264, 184);
            $svg .= "<rect x='108' y='204' width='184' height='52' rx='3' fill='{$fill('base')}' stroke='$edge'/><rect x='108' y='204' width='184' height='52' rx='3' fill='url(#$u-".($isDark ? 'shadeDark' : 'shade').")'/>";
            $svg .= "<path d='M104 188Q200 176 296 188V214H104Z' fill='#fbfaf7' stroke='#d9d3c8'/><path d='M104 200Q200 190 296 200' stroke='#e7e1d6' fill='none'/>";
            $svg .= "<rect x='124' y='168' width='62' height='22' rx='9' fill='#f3efe8' stroke='#d9d3c8'/><rect x='214' y='168' width='62' height='22' rx='9' fill='#f3efe8' stroke='#d9d3c8'/>";
            $svg .= "<rect x='240' y='200' width='52' height='14' rx='4' fill='".($isDark ? '#5b5f66' : '#c9b9a0')."' opacity='.85'/>";   // throw
            foreach ([50, 302] as $nx) $svg .= $drawer($nx, 186, 48, 26, 'base') . "<rect x='".($nx + 4)."' y='212' width='40' height='3' fill='rgba(0,0,0,.12)' filter='url(#$u-blur)'/>";
            break;
        case 'whole':
            // a condo in one view: kitchen on the left, TV wall on the right
            $svg .= "<rect x='32' y='120' width='150' height='58' fill='url(#$u-tile)'/><rect x='32' y='120' width='150' height='12' fill='url(#$u-led)'/>";
            $svg .= $door(32, 50, 74, 70, 'top', false) . $door(108, 50, 74, 70, 'top', true);
            $svg .= $floorShadow(32, 268, 150);
            $svg .= $counter(28, 178, 158);
            $svg .= "<rect x='60' y='175' width='44' height='4' rx='2' fill='#b9bfc5'/>";
            $svg .= $door(32, 188, 56, 70, 'base', true) . $door(90, 188, 40, 70, 'base', false);
            $svg .= $drawer(132, 188, 50, 22) . $drawer(132, 212, 50, 22) . $drawer(132, 236, 50, 22);
            $svg .= $plinth(32, 258, 150);
            $svg .= "<rect x='202' y='40' width='1' height='226' fill='rgba(0,0,0,.06)'/>";
            $svg .= "<rect x='236' y='88' width='112' height='66' rx='3' fill='#0f1113'/><rect x='240' y='92' width='104' height='58' rx='2' fill='url(#$u-screen)'/>";
            $svg .= $floorShadow(214, 262, 156);
            $svg .= $counter(214, 202, 156);
            $svg .= $drawer(214, 212, 51, 40) . $door(267, 212, 51, 40, 'base', true) . $drawer(320, 212, 50, 40);
            break;
        case 'office':
            $svg .= $door(70, 34, 85, 56, 'top', true) . $door(157, 34, 85, 56, 'top', false) . $door(244, 34, 86, 56, 'top', true);
            $svg .= "<rect x='70' y='90' width='260' height='3' fill='rgba(0,0,0,.1)'/>";
            $svg .= $floorShadow(44, 268, 312);
            $svg .= "<rect x='118' y='128' width='74' height='40' rx='3' fill='#121416'/><rect x='121' y='131' width='68' height='33' rx='2' fill='url(#$u-screen)'/><rect x='150' y='166' width='10' height='6' fill='#2a2d31'/>";
            $svg .= $counter(44, 172, 312);
            $svg .= "<rect x='52' y='182' width='8' height='84' fill='".($isDark ? '#1a1b1d' : '#cfc6b6')."'/>";
            $svg .= $drawer(256, 182, 96, 27) . $drawer(256, 211, 96, 27) . $drawer(256, 240, 96, 26);
            break;
        case 'bath':
            $svg .= "<rect x='126' y='26' width='148' height='98' rx='49' fill='{$C['glass']}' stroke='#b8bfc4' stroke-width='2'/>";
            $svg .= "<path d='M150 44L176 36L150 110L138 96Z' fill='#fff' opacity='.45'/>";
            $svg .= "<rect x='86' y='150' width='228' height='4' rx='2' fill='rgba(255,214,150,.0)'/>";
            $svg .= $floorShadow(86, 266, 228);
            $svg .= $counter(86, 160, 228);
            $svg .= "<ellipse cx='200' cy='159' rx='40' ry='7' fill='#fff' stroke='#c9cdd1'/><path d='M200 152V141Q200 137 205 137H210' stroke='url(#$u-steel)' stroke-width='3' fill='none' stroke-linecap='round'/>";
            $svg .= $drawer(86, 170, 228, 24, $style === 'twotone' ? 'top' : 'base');
            $svg .= $door(86, 196, 113, 56, 'base', true) . $door(201, 196, 113, 56, 'base', false);
            break;
        default:   // sideboard on legs
            $svg .= $floorShadow(60, 268, 280);
            $svg .= $counter(60, 138, 280);
            $svg .= $door(60, 148, 92, 104, 'base', true) . $door(154, 148, 92, 104, $style === 'twotone' ? 'top' : 'base', false) . $door(248, 148, 92, 104, 'base', false);
            $svg .= "<rect x='72' y='252' width='6' height='15' rx='1' fill='url(#$u-metal)'/><rect x='322' y='252' width='6' height='15' rx='1' fill='url(#$u-metal)'/>";
    }
@endphp
<svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
    <defs>
        <linearGradient id="{{ $u }}-wall" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#f8f4ec"/><stop offset="1" stop-color="#ece5d8"/></linearGradient>
        <linearGradient id="{{ $u }}-floor" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#d9ccb6"/><stop offset="1" stop-color="#e6dccb"/></linearGradient>
        <linearGradient id="{{ $u }}-shade" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff" stop-opacity=".22"/><stop offset=".5" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#000" stop-opacity=".1"/></linearGradient>
        <linearGradient id="{{ $u }}-shadeDark" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff" stop-opacity=".05"/><stop offset="1" stop-color="#000" stop-opacity=".12"/></linearGradient>
        <linearGradient id="{{ $u }}-dark" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#3a3c40"/><stop offset="1" stop-color="#25272a"/></linearGradient>
        <linearGradient id="{{ $u }}-gloss" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#ffffff"/><stop offset=".6" stop-color="#eef0f3"/><stop offset="1" stop-color="#dfe3e7"/></linearGradient>
        <linearGradient id="{{ $u }}-metal" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#55585c"/><stop offset=".45" stop-color="#1b1c1e"/><stop offset="1" stop-color="#3b3d40"/></linearGradient>
        <linearGradient id="{{ $u }}-steel" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#e7e9eb"/><stop offset=".5" stop-color="#b7bcc1"/><stop offset="1" stop-color="#d8dbde"/></linearGradient>
        <linearGradient id="{{ $u }}-stone" x1="0" y1="0" x2="1" y2="0">
            @if ($isDark)<stop offset="0" stop-color="#3b3c3f"/><stop offset="1" stop-color="#2b2c2e"/>@else<stop offset="0" stop-color="#f1efea"/><stop offset=".5" stop-color="#e6e3dc"/><stop offset="1" stop-color="#f0ede8"/>@endif
        </linearGradient>
        <linearGradient id="{{ $u }}-led" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#ffd690" stop-opacity=".75"/><stop offset="1" stop-color="#ffd690" stop-opacity="0"/></linearGradient>
        <linearGradient id="{{ $u }}-screen" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2c333a"/><stop offset=".45" stop-color="#15191d"/><stop offset=".46" stop-color="#1c2126"/><stop offset="1" stop-color="#0d0f11"/></linearGradient>
        <linearGradient id="{{ $u }}-mirror" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#eef3f6"/><stop offset="1" stop-color="#c9d4db"/></linearGradient>
        <pattern id="{{ $u }}-tile" width="26" height="14" patternUnits="userSpaceOnUse"><rect width="26" height="14" fill="#efebe3"/><path d="M0 13.5H26M25.5 0V14" stroke="#ddd6c9" stroke-width="1"/></pattern>
        <pattern id="{{ $u }}-marble" width="216" height="176" patternUnits="userSpaceOnUse"><rect width="216" height="176" fill="#f5f3ef"/><path d="M-10 40C40 30 70 70 120 50S200 20 230 40M-10 120C50 100 90 150 150 120S210 100 230 130M40 0C60 50 30 90 70 176" stroke="#c9c3b8" stroke-width="1.2" fill="none" opacity=".8"/></pattern>
        <pattern id="{{ $u }}-wood" width="48" height="300" patternUnits="userSpaceOnUse">
            <rect width="48" height="300" fill="#b7875a"/>
            <rect x="0" width="14" height="300" fill="#bf9064" opacity=".7"/><rect x="26" width="10" height="300" fill="#a87b4f" opacity=".6"/>
            <path d="M5 0C8 70 2 150 6 300M15 0C12 90 19 190 15 300M24 0C27 70 21 170 25 300M33 0C31 100 36 200 32 300M42 0C45 80 39 160 43 300" stroke="#94673d" stroke-width="1" fill="none" opacity=".55"/>
            <path d="M10 0C12 120 8 220 11 300M29 0C27 110 31 230 28 300M38 0C40 60 36 140 39 300" stroke="#d2a678" stroke-width=".8" fill="none" opacity=".7"/>
            <ellipse cx="20" cy="140" rx="2.2" ry="7" fill="none" stroke="#8c6038" stroke-width=".8" opacity=".5"/>
        </pattern>
        <filter id="{{ $u }}-blur" x="-20%" y="-200%" width="140%" height="500%"><feGaussianBlur stdDeviation="3"/></filter>
    </defs>
    <rect width="400" height="300" fill="url(#{{ $u }}-wall)"/>
    <rect y="266" width="400" height="34" fill="url(#{{ $u }}-floor)"/>
    <path d="M0 266H400M0 280H400M120 266L112 300M260 266L268 300" stroke="#cdbfa7" stroke-width=".8" opacity=".6"/>
    {!! $svg !!}
</svg>
