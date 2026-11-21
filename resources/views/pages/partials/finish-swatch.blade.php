{{-- Drawing of a finish (step 4 of "Design your space"), same look as the style drawings. $key: melamine | gloss | hpl | paint | unsure --}}
@php $u = 'fs-'.$key; @endphp
<svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
    <defs>
        <linearGradient id="{{ $u }}-bg" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#f8f4ec"/><stop offset="1" stop-color="#ebe3d5"/></linearGradient>
        <linearGradient id="{{ $u }}-shade" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff" stop-opacity=".3"/><stop offset=".5" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#000" stop-opacity=".12"/></linearGradient>
        <pattern id="{{ $u }}-wood" width="48" height="300" patternUnits="userSpaceOnUse"><rect width="48" height="300" fill="#c19267"/><path d="M5 0C8 70 2 150 6 300M15 0C12 90 19 190 15 300M24 0C27 70 21 170 25 300M33 0C31 100 36 200 32 300M42 0C45 80 39 160 43 300" stroke="#9c6f45" stroke-width="1" fill="none" opacity=".55"/><path d="M10 0C12 120 8 220 11 300M29 0C27 110 31 230 28 300" stroke="#d8ad80" stroke-width=".8" fill="none" opacity=".7"/></pattern>
        <pattern id="{{ $u }}-stone" width="200" height="200" patternUnits="userSpaceOnUse"><rect width="200" height="200" fill="#e9e7e2"/><path d="M-10 50C40 30 80 80 130 55S190 30 210 50M20 200C40 140 90 150 120 90" stroke="#b9b4aa" stroke-width="1.2" fill="none"/></pattern>
        <linearGradient id="{{ $u }}-gloss" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#fff"/><stop offset=".6" stop-color="#eef0f3"/><stop offset="1" stop-color="#dfe3e7"/></linearGradient>
        <linearGradient id="{{ $u }}-paint" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#3f7d66"/><stop offset=".55" stop-color="#2f6a55"/><stop offset="1" stop-color="#245644"/></linearGradient>
        <filter id="{{ $u }}-blur" x="-20%" y="-50%" width="140%" height="200%"><feGaussianBlur stdDeviation="5"/></filter>
    </defs>
    <rect width="400" height="300" fill="url(#{{ $u }}-bg)"/>
    @switch($key)
        @case('melamine')
            {{-- three sample boards: white matt, wood, stone look --}}
            <ellipse cx="200" cy="262" rx="150" ry="12" fill="rgba(50,35,20,.2)" filter="url(#{{ $u }}-blur)"/>
            <g transform="rotate(-8 120 160)"><rect x="60" y="60" width="120" height="190" rx="3" fill="#f6f4ef" stroke="#cfc6b6"/><rect x="60" y="60" width="120" height="190" rx="3" fill="url(#{{ $u }}-shade)"/></g>
            <g><rect x="140" y="52" width="120" height="200" rx="3" fill="url(#{{ $u }}-wood)" stroke="#9c7650"/><rect x="140" y="52" width="120" height="200" rx="3" fill="url(#{{ $u }}-shade)"/></g>
            <g transform="rotate(8 280 160)"><rect x="220" y="60" width="120" height="190" rx="3" fill="url(#{{ $u }}-stone)" stroke="#bdb7ac"/><rect x="220" y="60" width="120" height="190" rx="3" fill="url(#{{ $u }}-shade)"/></g>
            @break
        @case('gloss')
            <ellipse cx="200" cy="262" rx="110" ry="12" fill="rgba(50,35,20,.2)" filter="url(#{{ $u }}-blur)"/>
            <rect x="100" y="40" width="200" height="216" rx="4" fill="url(#{{ $u }}-gloss)" stroke="#c9ced3"/>
            <path d="M128 46H176L132 250H104V170Z" fill="#fff" opacity=".85"/><path d="M196 46H214L170 250H152Z" fill="#fff" opacity=".6"/>
            <path d="M232 46H290V96Z" fill="#fff" opacity=".4"/>
            <rect x="100" y="256" width="200" height="10" fill="rgba(200,205,210,.35)" filter="url(#{{ $u }}-blur)"/>
            @break
        @case('hpl')
            {{-- a sheet seen from the corner: textured face + the thin dark core layers --}}
            <ellipse cx="200" cy="262" rx="140" ry="12" fill="rgba(50,35,20,.2)" filter="url(#{{ $u }}-blur)"/>
            <path d="M80 90L250 54L330 110L160 150Z" fill="#d9d4cb" stroke="#b5ad9f"/>
            <path d="M80 90L160 150L160 162L80 102Z" fill="#3b3530"/><path d="M80 94L160 154M80 98L160 158" stroke="#7a6f62" stroke-width="1"/>
            <path d="M160 150L330 110V122L160 162Z" fill="#2e2925"/><path d="M160 154L330 114M160 158L330 118" stroke="#6b6156" stroke-width="1"/>
            <path d="M110 92L240 64M130 104L270 74M150 116L300 86M170 128L310 98" stroke="#c7c0b4" stroke-width="1.2" opacity=".8"/>
            @break
        @case('paint')
            <ellipse cx="200" cy="262" rx="110" ry="12" fill="rgba(50,35,20,.2)" filter="url(#{{ $u }}-blur)"/>
            <rect x="110" y="44" width="180" height="212" rx="4" fill="url(#{{ $u }}-paint)"/>
            <rect x="110" y="44" width="180" height="212" rx="4" fill="url(#{{ $u }}-shade)"/>
            <path d="M120 70Q200 60 280 72" stroke="#fff" stroke-width="10" opacity=".08" fill="none" stroke-linecap="round"/>
            <g transform="rotate(-30 300 90)"><rect x="268" y="60" width="64" height="26" rx="6" fill="#2f6a55" stroke="#1f4a3b"/><rect x="296" y="86" width="8" height="40" fill="#9c8a6e"/><rect x="292" y="124" width="16" height="44" rx="5" fill="#3b342d"/></g>
            @break
        @default
            {{-- a fan of colour samples + pencil: our designer helps you choose --}}
            <ellipse cx="200" cy="262" rx="130" ry="12" fill="rgba(50,35,20,.2)" filter="url(#{{ $u }}-blur)"/>
            @foreach (['#f6f4ef', '#d9d2c5', '#c19267', '#6e4a2f', '#2e3033', '#2f6a55'] as $i => $c)
                <g transform="rotate({{ -36 + $i * 14 }} 200 240)"><rect x="182" y="70" width="36" height="170" rx="6" fill="{{ $c }}" stroke="rgba(0,0,0,.15)"/></g>
            @endforeach
            <circle cx="200" cy="240" r="7" fill="#8b7a63"/>
            <g transform="rotate(35 300 150)"><rect x="294" y="70" width="12" height="130" rx="2" fill="#e3b553"/><path d="M294 200L300 218L306 200Z" fill="#e9d2b0"/><rect x="294" y="70" width="12" height="12" fill="#c7867a"/></g>
    @endswitch
</svg>
