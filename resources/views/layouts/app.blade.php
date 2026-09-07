<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Fixed: previously read "Ajax Trading Corporation. - Property Business" --}}
    <title>@yield('title', 'Ajax Trading Corporation — Modular Kitchens & Melamine Boards, Philippines')</title>
    <meta name="description" content="@yield('meta_description', 'Ajax Trading Corporation manufactures premium melamine boards, laminated marine plywood, and custom modular kitchen cabinets in San Pablo City, Philippines. Design your own kitchen online.')">
    <meta name="keywords" content="melamine boards Philippines, modular kitchen cabinets, laminated marine plywood, custom furniture San Pablo City, Ajax Trading Corporation">
    <meta name="theme-color" content="#3454d1">

    {{-- Open Graph — also previously said "Property Business" --}}
    <meta property="og:type" content="business.business">
    <meta property="og:title" content="@yield('og_title', 'Ajax Trading Corporation — Modular Kitchens & Melamine Boards')">
    <meta property="og:description" content="@yield('og_description', 'Premium melamine boards and custom modular kitchen cabinets, manufactured in the Philippines. Design your own kitchen online with our Build Your Own tool.')">
    <meta property="og:image" content="{{ asset('images/og-cover.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- LocalBusiness structured data — none existed before --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HomeAndConstructionBusiness",
        "name": "Ajax Trading Corporation",
        "url": "https://www.ajaxtradingcorp.com",
        "logo": "{{ asset('images/logo.webp') }}",
        "telephone": ["{{ config('company.phone_primary') }}", "{{ config('company.phone_secondary') }}"],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ config('company.address') }}",
            "addressLocality": "San Pablo City",
            "addressCountry": "PH"
        },
        "sameAs": [
            "https://www.facebook.com/profile.php?id=61559238760421",
            "https://www.instagram.com/ajaxtradingcorporation/",
            "https://x.com/ajaxtradingco",
            "https://www.tiktok.com/@ajaxtradingcorpor"
        ]
    }
    </script>

    @stack('schema')
</head>
<body>
    <header class="site-header">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset('images/logo.webp') }}" alt="Ajax Trading Corporation" height="40">
        </a>
        <nav class="main-nav" aria-label="Main navigation">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('portfolio') }}">Portfolio</a>
            <a href="{{ route('configurator') }}" class="nav-cta">Build Your Own</a>
            <a href="{{ route('products') }}">Products</a>
            <a href="{{ route('showrooms') }}">Showrooms</a>
            <a href="{{ route('quote.create') }}">Get a Quote</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-col">
            <h3>Ajax Trading Corporation</h3>
            <p>{{ config('company.address') }}</p>
            <p>{{ config('company.phone_primary') }} / {{ config('company.phone_secondary') }}</p>
        </div>
        <div class="footer-col">
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('quote.create') }}">Contact Us</a>
        </div>
        {{-- Admin login intentionally NOT in public nav — see report Section 2 --}}
        <p class="copyright">&copy; {{ date('Y') }} Ajax Trading Corp.</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
