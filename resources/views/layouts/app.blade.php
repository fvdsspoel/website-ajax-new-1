<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'tl' ? 'tl' : 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', __('site.meta.title'))</title>
    <meta name="description" content="@yield('meta_description', __('site.meta.description'))">
    <meta name="theme-color" content="#1e2a4a">
    @if (config('company.noindex'))
        <meta name="robots" content="noindex, nofollow">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Ajax Trading Corporation">
    <meta property="og:title" content="@yield('og_title', __('site.meta.og_title'))">
    <meta property="og:description" content="@yield('meta_description', __('site.meta.description'))">
    <meta property="og:image" content="{{ asset('images/og-cover.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'tl' ? 'tl_PH' : 'en_PH' }}">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">
    <link rel="alternate" hreflang="tl" href="{{ url()->current() }}?lang=tl">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,500&family=Instrument+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=3">
    <script>document.documentElement.classList.add('js')</script>

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FurnitureStore',
        'name' => 'Ajax Trading Corporation',
        'description' => __('site.meta.description'),
        'url' => 'https://www.ajaxtradingcorp.com',
        'logo' => asset('images/logo.webp'),
        'telephone' => [config('company.phone_primary'), config('company.phone_secondary')],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => config('company.address'),
            'addressLocality' => 'San Pablo City',
            'addressRegion' => 'Laguna',
            'addressCountry' => 'PH',
        ],
        'areaServed' => 'PH',
        'sameAs' => array_values(config('company.social')),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    @stack('schema')
</head>
@php
    $nav = [
        ['route' => 'portfolio', 'label' => __('site.nav.portfolio')],
        ['route' => 'machines', 'label' => __('site.nav.machines')],
        ['route' => 'products', 'label' => __('site.nav.accessories')],
        ['route' => 'about', 'label' => __('site.nav.about')],
        ['route' => 'showrooms', 'label' => __('site.nav.showroom')],
        ['route' => 'quote.create', 'label' => __('site.nav.contact')],
    ];
    $hasLogo = file_exists(public_path('images/logo.webp'));
@endphp
<body>
    <a href="#main" class="visually-hidden">Skip to content</a>

    <header class="site-header">
        <div class="wrap">
            <a href="{{ route('home') }}" class="brand" aria-label="Ajax Trading Corporation — {{ __('site.nav.home') }}">
                @if ($hasLogo)
                    <img src="{{ asset('images/logo.webp') }}" alt="" width="120" height="40">
                @else
                    <span class="brand-mark" aria-hidden="true">A</span>
                    <span class="brand-text"><strong>AJAX</strong><span>Trading Corp.</span></span>
                @endif
            </a>

            <nav class="main-nav" id="main-nav" aria-label="Main">
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" @if (request()->routeIs($item['route'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <a href="{{ route('configurator') }}" class="btn btn--primary nav-cta-mobile">{{ __('site.nav.build') }}</a>
            </nav>

            <div class="header-actions">
                <div class="lang-toggle" role="group" aria-label="{{ __('site.nav.language') }}">
                    @foreach (config('company.locales') as $code => $name)
                        <a href="{{ route('lang.switch', $code) }}" hreflang="{{ $code }}" lang="{{ $code }}" title="{{ $name }}"
                           @if (app()->getLocale() === $code) aria-current="true" @endif>{{ strtoupper($code) }}</a>
                    @endforeach
                </div>
                <a href="{{ route('configurator') }}" class="btn btn--primary btn--sm">{{ __('site.nav.build_short') }}</a>
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
                    <a href="{{ route('home') }}" class="brand">
                        <span class="brand-mark" aria-hidden="true">A</span>
                        <span class="brand-text"><strong>AJAX</strong><span>Trading Corporation</span></span>
                    </a>
                    <p class="footer-tagline">{{ __('site.footer.tagline') }}</p>
                </div>
                <div>
                    <h3>{{ __('site.footer.explore') }}</h3>
                    <ul>
                        <li><a href="{{ route('configurator') }}">{{ __('site.nav.build') }}</a></li>
                        @foreach ($nav as $item)
                            <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3>{{ __('site.footer.contact') }}</h3>
                    <ul>
                        <li>{{ config('company.address') }}, Laguna</li>
                        <li><a href="tel:{{ preg_replace('/\D+/', '', config('company.phone_primary')) }}">{{ config('company.phone_primary') }}</a> · <a href="tel:{{ preg_replace('/\D+/', '', config('company.phone_secondary')) }}">{{ config('company.phone_secondary') }}</a></li>
                        @if (config('company.email'))
                            <li><a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></li>
                        @endif
                        <li><a href="{{ route('quote.create') }}">{{ __('site.nav.quote') }} →</a></li>
                    </ul>
                </div>
                <div>
                    <h3>{{ __('site.footer.follow') }}</h3>
                    <div class="socials">
                        @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'shopee' => 'Shopee'] as $key => $label)
                            <a href="{{ config('company.social.'.$key) }}" target="_blank" rel="noopener" aria-label="{{ $label }}">
                                @include('partials.icon', ['name' => $key === 'shopee' ? 'bag' : $key])
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Ajax Trading Corporation. {{ __('site.footer.rights') }}</span>
                <span>Makati City · San Pablo City, Laguna</span>
            </div>
        </div>
    </footer>

    {{-- Live chat with Maya (answers via the CRM; staff can take over there) --}}
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
                <button type="submit" class="chat-send" aria-label="{{ __('site.chat.send') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h15M13 6l6 6-6 6"/></svg>
                </button>
            </form>
            <p class="chat-foot">
                {{ __('site.chat.or') }}
                <a href="tel:{{ preg_replace('/\D+/', '', config('company.phone_primary')) }}">{{ config('company.phone_primary') }}</a>
                · <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener">Messenger</a>
            </p>
        </section>
        <button type="button" class="float-chat-btn" id="chat-toggle" aria-expanded="false" aria-controls="chat-panel">
            @include('partials.icon', ['name' => 'chat']) <span class="float-chat-label">{{ __('site.chat.open') }}</span>
            <span class="chat-dot" id="chat-dot" hidden></span>
        </button>
    </div>
    <script type="application/json" id="chat-i18n">{!! json_encode(['you' => __('site.chat.you'), 'human' => __('site.chat.human')], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>

    <script src="{{ asset('js/app.js') }}?v=3" defer></script>
    @stack('scripts')
</body>
</html>
