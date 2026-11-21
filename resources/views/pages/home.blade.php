@extends('layouts.app')

@section('content')
@php
    $slides = config('ajax.hero_slides');
    $words = __('site.hero.words');
@endphp

{{-- HERO: real Ajax kitchens, rotating word, two clear actions --}}
<section class="hero">
    <div class="hero-slides" aria-hidden="true">
        @foreach ($slides as $i => $src)
            <div class="hero-slide @if ($i === 0) is-active @endif">
                <img @if ($i === 0) src="{{ asset($src) }}" fetchpriority="high" @else data-src="{{ asset($src) }}" @endif alt="">
            </div>
        @endforeach
    </div>
    <div class="wrap hero-inner">
        <span class="eyebrow">{{ __('site.hero.eyebrow') }}</span>
        <h1>
            {{ __('site.hero.title_a') }}
            <span class="rotator grad" data-rotator>
                @foreach ($words as $i => $w)<span class="serif @if ($i === 0) is-active @endif">{{ $w }}</span>@endforeach
            </span><br>
            {{ __('site.hero.title_b') }}
        </h1>
        <p class="hero-lead">{{ __('site.hero.lead') }}</p>
        <div class="hero-ctas">
            <a href="{{ route('design') }}" class="btn btn--gold btn--lg">@include('partials.icon', ['name' => 'sparkle']) {{ __('site.hero.cta_design') }}</a>
            <a href="{{ route('design') }}#upload" class="btn btn--ghost btn--lg">@include('partials.icon', ['name' => 'upload']) {{ __('site.hero.cta_upload') }}</a>
        </div>
        <ul class="chips">
            @foreach (__('site.hero.chips') as $chip)
                <li class="chip">@include('partials.icon', ['name' => 'check']) {{ $chip }}</li>
            @endforeach
        </ul>
    </div>
    <div class="hero-dots" aria-hidden="true">
        @foreach ($slides as $i => $src)<button type="button" tabindex="-1" @class(['is-active' => $i === 0])></button>@endforeach
    </div>
</section>

{{-- STATS --}}
<section class="stats" aria-label="Ajax in numbers">
    <div class="wrap">
        <div class="stats-grid" data-counters>
            @foreach (config('ajax.stats') as $s)
                <div class="stat">
                    <strong><span data-count="{{ $s['value'] }}">{{ number_format($s['value']) }}</span><em>{{ $s['suffix'] }}</em></strong>
                    <span>{{ __('site.stats.'.$s['key']) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- WHAT WE MAKE --}}
<section class="section" id="make">
    <div class="wrap">
        <div class="section-head section-head--split" data-reveal>
            <div>
                <span class="eyebrow">{{ __('site.make.eyebrow') }}</span>
                <h2 style="margin-top:14px">{{ __('site.make.title') }}</h2>
            </div>
            <p class="lead">{{ __('site.make.lead') }}</p>
        </div>
        @include('pages.partials.bento')
    </div>
</section>

{{-- FACTORY (dark) --}}
<section class="section section--dark">
    <div class="wrap">
        <div class="factory-grid">
            <div data-reveal>
                <span class="eyebrow">{{ __('site.factory.eyebrow') }}</span>
                <h2 class="h2" style="margin-top:14px">{{ __('site.factory.title') }}</h2>
                <p class="lead" style="margin-top:18px">{{ __('site.factory.lead') }}</p>
                <div class="factory-points">
                    <div class="factory-point">@include('partials.icon', ['name' => 'layers'])<div><h3>{{ __('site.factory.boards_title') }}</h3><p>{{ __('site.factory.boards_text') }}</p></div></div>
                    <div class="factory-point">@include('partials.icon', ['name' => 'stone'])<div><h3>{{ __('site.factory.stone_title') }}</h3><p>{{ __('site.factory.stone_text') }}</p></div></div>
                </div>
                <a href="{{ route('factory') }}" class="btn btn--ghost" style="margin-top:26px">{{ __('site.factory.cta') }} <span class="arrow">@include('partials.icon', ['name' => 'arrow'])</span></a>
            </div>
            <div class="collage" data-reveal style="--d:.15s">
                <figure><img src="{{ asset('images/factory/press-line.webp') }}" alt="{{ __('site.factory.machines.multi_press.name') }}" loading="lazy"><figcaption>{{ __('site.factory.groups.pressing') }}</figcaption></figure>
                <figure><img src="{{ asset('images/factory/cnc-router.webp') }}" alt="{{ __('site.factory.machines.cnc_router.name') }}" loading="lazy"><figcaption>{{ __('site.factory.machines.cnc_router.name') }}</figcaption></figure>
                <figure><img src="{{ asset('images/factory/stone-calacatta.webp') }}" alt="{{ __('site.factory.machines.stone_cutter.name') }}" loading="lazy"><figcaption>{{ __('site.factory.groups.stone') }}</figcaption></figure>
            </div>
        </div>
        <div class="marquee" aria-hidden="true">
            <div class="marquee-track">
                @foreach ([1, 2] as $_)
                    @foreach (collect(config('ajax.machine_groups'))->flatten() as $m)
                        <span class="mchip"><img src="{{ asset(config('ajax.machine_photos.'.$m) ?? 'images/machines/'.$m.'.webp') }}" alt="" loading="lazy">{{ __('site.factory.machines.'.$m.'.name') }}</span>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- OUR BOARDS --}}
@include('pages.partials.boards')

{{-- PROJECTS --}}
<section class="section">
    <div class="wrap">
        <div class="section-head section-head--split" data-reveal>
            <div>
                <span class="eyebrow">{{ __('site.portfolio.eyebrow') }}</span>
                <h2 style="margin-top:14px">{{ __('site.portfolio.title') }}</h2>
            </div>
            <div>
                <p class="lead">{{ __('site.portfolio.lead') }}</p>
                <a href="{{ route('portfolio') }}" class="link-arrow" style="margin-top:14px">{{ __('site.portfolio.more') }} @include('partials.icon', ['name' => 'arrow'])</a>
            </div>
        </div>
        <div class="projects projects--home">
            @foreach ($featured as $i => $item)
                @include('pages.partials.project', ['item' => $item, 'delay' => ($i % 3) * .08])
            @endforeach
        </div>
    </div>
</section>

{{-- WHY + PROCESS --}}
<section class="section section--sand">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <span class="eyebrow">{{ __('site.why.eyebrow') }}</span>
            <h2>{{ __('site.why.title') }}</h2>
        </div>
        <div class="features">
            @foreach (__('site.why.items') as $i => $f)
                <div class="feature" data-reveal style="--d:{{ $i * .08 }}s">
                    <div class="feature-icon">@include('partials.icon', ['name' => ['factory', 'ruler', 'drop', 'shield'][$i] ?? 'check'])</div>
                    <h3>{{ $f['title'] }}</h3>
                    <p>{{ $f['text'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="section-head" data-reveal style="margin-top:88px">
            <span class="eyebrow">{{ __('site.process.eyebrow') }}</span>
            <h2>{{ __('site.process.title') }}</h2>
        </div>
        <ol class="steps">
            @foreach (__('site.process.steps') as $i => $s)
                <li class="step" data-reveal style="--d:{{ $i * .08 }}s"><h3>{{ $s['title'] }}</h3><p>{{ $s['text'] }}</p></li>
            @endforeach
        </ol>
    </div>
</section>

{{-- UPLOAD YOUR PLAN --}}
<section class="section section--tight">
    <div class="wrap">
        <div class="band" data-reveal>
            <div class="band-grid">
                <div>
                    <h2>{{ __('site.upload.title') }}</h2>
                    <p>{{ __('site.upload.text') }}</p>
                    <div class="btns">
                        <a href="{{ route('design') }}#upload" class="btn btn--gold btn--lg">@include('partials.icon', ['name' => 'upload']) {{ __('site.upload.cta') }}</a>
                        <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" class="btn btn--ghost btn--lg" data-track="Contact">@include('partials.icon', ['name' => 'messenger']) Messenger</a>
                    </div>
                </div>
                <a href="{{ route('design') }}#upload" class="drop-visual" aria-hidden="true" tabindex="-1">
                    <div class="files"><span>@include('partials.icon', ['name' => 'file'])PDF</span><span>@include('partials.icon', ['name' => 'photo'])JPG</span><span>@include('partials.icon', ['name' => 'ruler'])PLAN</span></div>
                    <strong>{{ __('site.design.upload_btn') }}</strong>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- DEVELOPERS --}}
<section class="section">
    <div class="wrap dev-band">
        <div data-reveal>
            <span class="eyebrow">{{ __('site.developers.eyebrow') }}</span>
            <h2 class="h2" style="margin-top:14px">{{ __('site.developers.title') }}</h2>
            <p class="lead" style="margin-top:18px">{{ __('site.developers.text') }}</p>
            <div class="logos-row"><span>DDC LAND</span><span>CONCEPT BUILDERS</span><span>GREENFIELD</span><span>BGC OFFICE</span></div>
            <a href="{{ route('quote.create', ['interest' => 'project']) }}" class="btn btn--primary btn--lg" style="margin-top:28px">{{ __('site.developers.cta') }} <span class="arrow">@include('partials.icon', ['name' => 'arrow'])</span></a>
        </div>
        <div class="dev-photos" data-reveal style="--d:.15s">
            <img src="{{ asset('images/projects/06/01-sm.webp') }}" alt="DDC Land" loading="lazy">
            <img src="{{ asset('images/site/office-reception-sm.webp') }}" alt="Office reception and pantry" loading="lazy">
        </div>
    </div>
</section>

{{-- FACEBOOK / SOCIAL --}}
@include('pages.partials.social')

{{-- SHOWROOM --}}
@include('pages.partials.visit')

{{-- FINAL CTA --}}
<section class="section section--dark">
    <div class="wrap cta-final" data-reveal>
        <span class="eyebrow">Ajax Trading Corporation</span>
        <h2>{{ __('site.cta.title') }}</h2>
        <p class="lead">{{ __('site.cta.text') }}</p>
        <div class="btns">
            <a href="{{ route('design') }}" class="btn btn--gold btn--lg">@include('partials.icon', ['name' => 'sparkle']) {{ __('site.cta.primary') }}</a>
            <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" class="btn btn--ghost btn--lg" data-track="Contact">@include('partials.icon', ['name' => 'messenger']) {{ __('site.cta.secondary') }}</a>
        </div>
    </div>
</section>

@include('pages.partials.lightbox')
@endsection
