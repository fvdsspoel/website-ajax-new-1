<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    @php
        // One clean address per language for Google: English = no ?lang, Tagalog/Bisaya = ?lang=tl / ?lang=ceb.
        $loc = app()->getLocale();
        $base = url()->current();
        $canonical = $loc === 'en' ? $base : $base.'?lang='.$loc;
        $ogLocale = ['en' => 'en_PH', 'tl' => 'tl_PH', 'ceb' => 'cx_PH'][$loc] ?? 'en_PH';
    @endphp
    <title>@yield('title', __('site.seo.home.title'))</title>
    <meta name="description" content="@yield('meta_description', __('site.seo.home.description'))">
    <meta name="theme-color" content="#0b2218">
    @if (config('company.noindex'))
        <meta name="robots" content="noindex, nofollow">
    @endif

    {{-- Facebook / Messenger / Viber link previews --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ajax Trading Corporation">
    <meta property="og:title" content="@yield('title', __('site.seo.home.title'))">
    <meta property="og:description" content="@yield('meta_description', __('site.seo.home.description'))">
    <meta property="og:image" content="{{ asset('images/site/og-cover.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="canonical" href="{{ $canonical }}">
    <link rel="alternate" hreflang="en-PH" href="{{ $base }}">
    <link rel="alternate" hreflang="tl-PH" href="{{ $base }}?lang=tl">
    <link rel="alternate" hreflang="ceb" href="{{ $base }}?lang=ceb">
    <link rel="alternate" hreflang="x-default" href="{{ $base }}">

    <link rel="preload" href="{{ asset('fonts/plus-jakarta-sans-latin-wght-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
    @stack('head')
    <script>document.documentElement.classList.add('js')</script>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FurnitureStore',
        'name' => 'Ajax Trading Corporation',
        'description' => __('site.seo.home.description'),
        'email' => config('company.email') ?: null,
        'priceRange' => 'Free quotation',
        'hasMap' => config('company.map_url'),
        'currenciesAccepted' => 'PHP',
        'url' => 'https://www.ajaxtradingcorp.com',
        'logo' => asset('images/site/logo.png'),
        'image' => asset('images/site/og-cover.jpg'),
        'telephone' => [config('company.phone_primary'), config('company.phone_secondary')],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '281 Purok 6, Santisimo Road, Brgy. Soledad',
            'addressLocality' => 'San Pablo City',
            'addressRegion' => 'Laguna',
            'addressCountry' => 'PH',
        ],
        'openingHours' => 'Mo-Sa 07:00-19:00',
        'areaServed' => ['Metro Manila', 'Laguna', 'Cavite', 'Batangas', 'Rizal', 'Quezon', 'Calabarzon'],
        'knowsAbout' => ['Modular kitchens', 'Kitchen cabinets', 'Wardrobes', 'Walk-in closets', 'Custom furniture', 'Marine plywood boards', 'HPL', 'Sintered stone countertops'],
        'sameAs' => array_values(config('company.social')),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    @stack('schema')

    @if (config('company.meta_pixel_id'))
        {{-- Meta Pixel: lets Facebook ads see who sent a quote request (event "Lead") --}}
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', @json(config('company.meta_pixel_id'))); fbq('track', 'PageView');
        </script>
    @endif
    @if (config('company.ga4_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('company.ga4_id') }}"></script>
        <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config',@json(config('company.ga4_id')));</script>
    @endif
</head>
@php
    $nav = [
        ['route' => 'furniture', 'label' => __('site.nav.make')],
        ['route' => 'portfolio', 'label' => __('site.nav.portfolio')],
        ['route' => 'colours', 'label' => __('site.nav.colours')],
        ['route' => 'factory', 'label' => __('site.nav.factory')],
        ['route' => 'about', 'label' => __('site.nav.about')],
        ['route' => 'showrooms', 'label' => __('site.nav.showroom')],
        ['route' => 'quote.create', 'label' => __('site.nav.contact')],
    ];
    $tel = 'tel:+63'.ltrim(preg_replace('/\D+/', '', config('company.phone_primary')), '0');
    $social = config('company.social');
@endphp
<body class="@yield('body_class')">
    <a href="#main" class="visually-hidden">Skip to content</a>

    <header class="site-header" id="site-header">
        <div class="wrap">
            <a href="{{ route('home') }}" class="brand" aria-label="Ajax Trading Corporation — {{ __('site.nav.home') }}">
                @include('partials.logo')
            </a>

            <nav class="main-nav" id="main-nav" aria-label="Main">
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" @if (request()->routeIs($item['route'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ route('design') }}" class="btn btn--gold nav-mobile-only">@include('partials.icon', ['name' => 'sparkle']) {{ __('site.nav.design') }}</a>
                <div class="socials nav-mobile-only" style="margin-top:22px">
                    @foreach (['facebook', 'instagram', 'tiktok', 'youtube'] as $key)
                        <a href="{{ $social[$key] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($key) }}">@include('partials.icon', ['name' => $key])</a>
                    @endforeach
                </div>
            </nav>

            <div class="header-actions">
                <div class="lang-toggle" role="group" aria-label="{{ __('site.nav.language') }}">
                    @foreach (config('company.locales') as $code => $name)
                        <a href="{{ route('lang.switch', $code) }}" hreflang="{{ $code }}" lang="{{ $code }}" title="{{ $name }}"
                           @if (app()->getLocale() === $code) aria-current="true" @endif><span>{{ config('company.locale_short.'.$code, strtoupper($code)) }}</span></a>
                    @endforeach
                </div>
                <a href="{{ route('design') }}" class="btn btn--primary btn--sm header-cta">{{ __('site.nav.cta_short') }} @include('partials.icon', ['name' => 'arrow'])</a>
                <button type="button" class="nav-toggle" aria-controls="main-nav" aria-expanded="false" aria-label="{{ __('site.nav.menu') }}"
                        data-label-open="{{ __('site.nav.menu') }}" data-label-close="{{ __('site.nav.close') }}">
                    <span class="icon-open">@include('partials.icon', ['name' => 'menu'])</span>
                    <span class="icon-close" hidden>@include('partials.icon', ['name' => 'close'])</span>
                </button>
            </div>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="wrap">
            <div class="footer-grid">
                <div>
                    <a href="{{ route('home') }}" class="brand" style="color:#fff">
                        @include('partials.logo')
                    </a>
                    <p class="footer-tagline">{{ __('site.footer.tagline') }}</p>
                    <p class="footer-area">@include('partials.icon', ['name' => 'truck']) {{ __('site.footer.area') }}</p>
                </div>
                <div>
                    <h3>{{ __('site.footer.explore') }}</h3>
                    <ul>
                        <li><a href="{{ route('design') }}">{{ __('site.nav.design') }}</a></li>
                        @foreach ($nav as $item)
                            <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3>{{ __('site.footer.contact') }}</h3>
                    <ul>
                        <li>{{ config('company.address') }}</li>
                        <li><a href="{{ $tel }}">{{ config('company.phone_primary') }}</a> · <a href="tel:+63{{ ltrim(preg_replace('/\D+/', '', config('company.phone_secondary')), '0') }}">{{ config('company.phone_secondary') }}</a></li>
                        @if (config('company.email'))
                            <li><a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></li>
                        @endif
                        <li>{{ config('company.hours') }}</li>
                        <li>{{ __('site.showroom.office') }}</li>
                    </ul>
                </div>
                <div>
                    <h3>{{ __('site.footer.follow') }}</h3>
                    <div class="socials">
                        @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'x' => 'X', 'shopee' => 'Shopee'] as $key => $label)
                            <a href="{{ $social[$key] }}" target="_blank" rel="noopener" aria-label="{{ $label }}">
                                @include('partials.icon', ['name' => $key === 'shopee' ? 'bag' : $key])
                            </a>
                        @endforeach
                        <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" aria-label="Messenger">@include('partials.icon', ['name' => 'messenger'])</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Ajax Trading Corporation. {{ __('site.footer.rights') }}</span>
                <span>Makati City · San Pablo City, Laguna</span>
            </div>
        </div>
    </footer>

    {{-- Floating contact: Messenger, Viber, call — and the live chat with Maya (answers via the CRM) --}}
    <div class="fab-dock">
        <div class="fab-mini">
            <a class="fab fab--messenger" href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" data-track="Contact">@include('partials.icon', ['name' => 'messenger'])<span class="tip">{{ __('site.float.messenger') }}</span></a>
            <a class="fab fab--viber" href="viber://chat?number=%2B{{ config('company.viber_number') }}" data-track="Contact">@include('partials.icon', ['name' => 'viber'])<span class="tip">{{ __('site.float.viber') }}</span></a>
            <a class="fab fab--call" href="{{ $tel }}" data-track="Contact">@include('partials.icon', ['name' => 'phone'])<span class="tip">{{ __('site.float.call') }}</span></a>
        </div>
        {{-- Maya only when the CRM chat key is set; until then Messenger, Viber and Call do the job. --}}
        @if (config('services.crm.webchat_key'))
        <div class="chat" id="chat"
             data-send-url="{{ route('chat.send') }}"
             data-poll-url="{{ route('chat.poll') }}"
             data-csrf="{{ csrf_token() }}"
             data-started="{{ session()->has('chat_token') ? '1' : '0' }}">
            <section class="chat-panel" id="chat-panel" role="dialog" aria-modal="false" aria-labelledby="chat-title" hidden>
                <header class="chat-head">
                    <span class="chat-avatar" aria-hidden="true">M</span>
                    <div>
                        <h2 id="chat-title">{{ __('site.chat.title') }}</h2>
                        <p>{{ __('site.chat.subtitle') }}</p>
                    </div>
                    <button type="button" class="chat-close" id="chat-close" aria-label="{{ __('site.chat.close') }}">@include('partials.icon', ['name' => 'close'])</button>
                </header>
                <div class="chat-log" id="chat-log" aria-live="polite">
                    <div class="msg msg--ajax"><span class="msg-name">Ajax</span><p>{{ __('site.chat.greeting') }}</p></div>
                </div>
                <p class="chat-typing" id="chat-typing" hidden>{{ __('site.chat.typing') }}</p>
                <p class="chat-error" id="chat-error" role="alert" hidden>{{ __('site.chat.error') }}</p>
                <form class="chat-form" id="chat-form">
                    <label for="chat-input" class="visually-hidden">{{ __('site.chat.placeholder') }}</label>
                    <textarea id="chat-input" rows="1" maxlength="2000" placeholder="{{ __('site.chat.placeholder') }}" autocomplete="off"></textarea>
                    <button type="submit" class="chat-send" aria-label="{{ __('site.chat.send') }}">@include('partials.icon', ['name' => 'arrow'])</button>
                </form>
                <p class="chat-foot">
                    {{ __('site.chat.or') }}
                    <a href="{{ $tel }}">{{ config('company.phone_primary') }}</a>
                    · <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener">Messenger</a>
                </p>
            </section>
            <button type="button" class="float-chat-btn" id="chat-toggle" aria-expanded="false" aria-controls="chat-panel">
                @include('partials.icon', ['name' => 'chat']) <span class="float-chat-label">{{ __('site.chat.open') }}</span><span class="visually-hidden">{{ __('site.float.chat') }}</span>
                <span class="chat-dot" id="chat-dot" hidden></span>
            </button>
        </div>
        @endif
    </div>
    <script type="application/json" id="chat-i18n">{!! json_encode(['you' => __('site.chat.you'), 'human' => __('site.chat.human')], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
    <script src="{{ asset('js/ui.js') }}?v={{ filemtime(public_path('js/ui.js')) }}" defer></script>
    @stack('scripts')
</body>
</html>
