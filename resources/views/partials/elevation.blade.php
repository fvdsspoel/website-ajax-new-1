{{--
    Hero artwork used until a real hero photo is placed at
    public/images/hero.jpg: a cabinetmaker's elevation drawing of an
    Ajax kitchen — wall units, tall pantry, hood, base units and
    dimension lines. Pure SVG, so it's sharp on every screen and weighs ~3 KB.
--}}
<svg class="elevation" viewBox="0 0 480 408" role="img" aria-label="Elevation drawing of a modular kitchen" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <pattern id="grain" width="6" height="40" patternUnits="userSpaceOnUse">
            <path d="M3 0v40" stroke="#9a6532" stroke-opacity=".12" stroke-width="1"/>
        </pattern>
        <pattern id="grid" width="16" height="16" patternUnits="userSpaceOnUse">
            <path d="M16 0H0v16" fill="none" stroke="#1e2a4a" stroke-opacity=".05"/>
        </pattern>
    </defs>
    <rect width="480" height="408" fill="#fffdf9"/>
    <rect width="480" height="408" fill="url(#grid)"/>

    <!-- wall line + floor -->
    <path d="M40 352h400" stroke="#1e2a4a" stroke-width="2"/>
    <path d="M40 360h400" stroke="#1e2a4a" stroke-opacity=".25" stroke-dasharray="4 6"/>

    <!-- tall pantry -->
    <rect x="52" y="82" width="70" height="270" fill="#c89259"/>
    <rect x="52" y="82" width="70" height="270" fill="url(#grain)"/>
    <rect x="58" y="88" width="58" height="126" fill="none" stroke="#1e2a4a" stroke-opacity=".35"/>
    <rect x="58" y="220" width="58" height="126" fill="none" stroke="#1e2a4a" stroke-opacity=".35"/>

    <!-- wall cabinets -->
    <g fill="#e9e3d8" stroke="#1e2a4a" stroke-opacity=".45">
        <rect x="126" y="82" width="74" height="98"/>
        <rect x="316" y="82" width="74" height="98"/>
        <rect x="394" y="82" width="36" height="98"/>
    </g>
    <path d="M163 82v98M353 82v98" stroke="#1e2a4a" stroke-opacity=".3"/>
    <!-- LED strip -->
    <path d="M126 184h74M316 184h114" stroke="#c89259" stroke-width="3" stroke-linecap="round"/>

    <!-- hood -->
    <path d="M222 82h72v58l14 34h-100l14-34Z" fill="#dcd6cc" stroke="#1e2a4a" stroke-opacity=".45"/>

    <!-- backsplash -->
    <rect x="126" y="186" width="304" height="62" fill="#f0ebe2"/>
    <path d="M126 217h304" stroke="#1e2a4a" stroke-opacity=".08"/>

    <!-- counter -->
    <rect x="122" y="248" width="312" height="10" fill="#2b2e36"/>
    <!-- cooktop -->
    <path d="M232 247h52" stroke="#9aa0ad" stroke-width="3"/>

    <!-- base cabinets -->
    <g stroke="#1e2a4a" stroke-opacity=".45">
        <rect x="126" y="258" width="74" height="86" fill="#1e2a4a"/>
        <rect x="204" y="258" width="108" height="86" fill="#1e2a4a"/>
        <rect x="316" y="258" width="114" height="86" fill="#1e2a4a"/>
    </g>
    <!-- drawer lines / fronts -->
    <g stroke="#fffdf9" stroke-opacity=".28">
        <path d="M204 286h108M204 314h108"/>
        <path d="M373 258v86"/>
        <path d="M163 258v86"/>
    </g>
    <!-- handles -->
    <g stroke="#c89259" stroke-width="3" stroke-linecap="round">
        <path d="M244 272h28M244 300h28M244 328h28"/>
        <path d="M156 266v14M170 266v14M366 266v14M380 266v14"/>
    </g>
    <!-- toe kick -->
    <rect x="126" y="344" width="304" height="8" fill="#141a2e"/>

    <!-- sink tap -->
    <path d="M340 248v-18a8 8 0 0 1 16 0" fill="none" stroke="#9aa0ad" stroke-width="3" stroke-linecap="round"/>

    <!-- dimension lines -->
    <g stroke="#9a6532" stroke-width="1" fill="none">
        <path d="M52 44h378M52 38v12M430 38v12"/>
        <path d="M456 82v270M450 82h12M450 352h12"/>
        <path d="M126 380h304M126 374v12M430 374v12"/>
    </g>
    <g fill="#9a6532" font-family="Instrument Sans, system-ui, sans-serif" font-size="11" font-weight="600" letter-spacing=".06em" text-anchor="middle">
        <text x="241" y="34">3,780</text>
        <text x="278" y="398">3,040 mm</text>
        <text x="468" y="222" transform="rotate(90 468 222)">2,700</text>
    </g>
    <text x="40" y="24" fill="#1e2a4a" fill-opacity=".55" font-family="Instrument Sans, system-ui, sans-serif" font-size="10" font-weight="700" letter-spacing=".16em">ELEVATION A · AJAX</text>
</svg>
