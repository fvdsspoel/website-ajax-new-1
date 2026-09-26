@extends('layouts.app')

@php
    $heroPhoto = file_exists(public_path('images/hero.jpg')) ? asset('images/hero.jpg') : null;
    $factoryPhoto = file_exists(public_path('images/factory.jpg')) ? asset('images/factory.jpg') : null;
@endphp

@section('content')

{{-- ============ Hero ============ --}}
<section class="hero">
    <div class="wrap hero-grid">
        <div>
            <span class="eyebrow">{{ __('site.home.eyebrow') }}</span>
            <h1>{{ __('site.home.title') }}</h1>
            <p class="lead">{{ __('site.home.lead') }}</p>
            <div class="btn-row">
                <a href="{{ route('configurator') }}" class="btn btn--primary">{{ __('site.home.cta_primary') }}</a>
                <a href="{{ route('portfolio') }}" class="btn btn--ghost">{{ __('site.home.cta_secondary') }}</a>
            </div>

            <dl class="stats">
                @foreach (__('site.home.stats') as $stat)
                    <div class="stat">
                        <dt class="stat-value">{{ $stat['value'] }}@if ($stat['unit'])<small>{{ $stat['unit'] }}</small>@endif</dt>
                        <dd class="stat-label">{{ $stat['label'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="hero-art">
            @if ($heroPhoto)
                <img src="{{ $heroPhoto }}" alt="" fetchpriority="high">
            @else
                @include('partials.elevation')
            @endif
            <div class="hero-badge">
                <strong>San Pablo City</strong>
                {{ __('site.home.factory_eyebrow') }} · CNC
            </div>
        </div>
    </div>
</section>

{{-- ============ Three entry points ============ --}}
<section class="section--tight">
    <div class="wrap">
        <h2 class="reveal">{{ __('site.home.paths_title') }}</h2>
        <div class="paths" style="margin-top: 28px">
            <a class="path reveal" href="{{ route('configurator') }}">
                <span class="path-icon">@include('partials.icon', ['name' => 'kitchen'])</span>
                <h3>{{ __('site.home.paths.home.title') }}</h3>
                <p>{{ __('site.home.paths.home.body') }}</p>
                <span class="link-arrow">{{ __('site.home.paths.home.cta') }}</span>
            </a>
            <a class="path reveal" href="{{ route('quote.create', ['interest' => 'project']) }}">
                <span class="path-icon">@include('partials.icon', ['name' => 'building'])</span>
                <h3>{{ __('site.home.paths.projects.title') }}</h3>
                <p>{{ __('site.home.paths.projects.body') }}</p>
                <span class="link-arrow">{{ __('site.home.paths.projects.cta') }}</span>
            </a>
            <a class="path reveal" href="{{ route('products') }}">
                <span class="path-icon">@include('partials.icon', ['name' => 'drawer'])</span>
                <h3>{{ __('site.home.paths.accessories.title') }}</h3>
                <p>{{ __('site.home.paths.accessories.body') }}</p>
                <span class="link-arrow">{{ __('site.home.paths.accessories.cta') }}</span>
            </a>
        </div>
    </div>
</section>

{{-- ============ Recent work ============ --}}
@if ($featured->isNotEmpty())
<section class="section">
    <div class="wrap">
        <div class="section-head reveal">
            <div>
                <h2>{{ __('site.home.work_title') }}</h2>
                <p class="lead">{{ __('site.home.work_lead') }}</p>
            </div>
            <a href="{{ route('portfolio') }}" class="link-arrow">{{ __('site.common.see_all') }}</a>
        </div>
        <div class="work-grid">
            @foreach ($featured as $item)
                <article class="card reveal">
                    <div class="card-media">
                        @include('partials.media', ['src' => $item->image_url, 'alt' => $item->title])
                    </div>
                    <div class="card-body">
                        <span class="card-tag">{{ __('site.portfolio.categories.'.$item->category) }}</span>
                        <h3>{{ $item->title }}</h3>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ Process ============ --}}
<section class="section section--paper">
    <div class="wrap">
        <div class="section-head reveal">
            <div>
                <h2>{{ __('site.home.process_title') }}</h2>
                <p class="lead">{{ __('site.home.process_lead') }}</p>
            </div>
        </div>
        <ol class="process">
            @foreach (__('site.home.process') as $step)
                <li class="reveal">
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['body'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- ============ Factory ============ --}}
<section class="section section--ink">
    <div class="wrap factory">
        <div class="reveal">
            <span class="eyebrow">{{ __('site.home.factory_eyebrow') }}</span>
            <h2>{{ __('site.home.factory_title') }}</h2>
            <p class="lead">{{ __('site.home.factory_body') }}</p>
            <ul class="factory-list">
                @foreach (__('site.home.factory_points') as $point)
                    <li>@include('partials.icon', ['name' => 'check']) {{ $point }}</li>
                @endforeach
            </ul>
            <a href="{{ route('machines') }}" class="btn btn--light">{{ __('site.home.factory_cta') }}</a>
        </div>
        <div class="factory-art reveal">
            @include('partials.media', ['src' => $factoryPhoto, 'alt' => __('site.machines.title'), 'label' => __('site.machines.photo_note'), 'dark' => true])
        </div>
    </div>
</section>

{{-- ============ Accessories ============ --}}
@if ($accessories->isNotEmpty())
<section class="section">
    <div class="wrap">
        <div class="section-head reveal">
            <div>
                <h2>{{ __('site.home.accessories_title') }}</h2>
                <p class="lead">{{ __('site.home.accessories_lead') }}</p>
            </div>
            <a href="{{ route('products') }}" class="link-arrow">{{ __('site.common.see_all') }}</a>
        </div>
        <div class="grid grid--3">
            @foreach ($accessories as $product)
                <article class="card acc-card reveal">
                    <div class="card-media">
                        @include('partials.media', ['src' => $product->image_url, 'alt' => $product->localizedName()])
                    </div>
                    <div class="card-body">
                        <span class="card-tag">{{ __('site.accessories.categories.'.$product->category) }}</span>
                        <h3>{{ $product->localizedName() }}</h3>
                        <p>{{ $product->localizedDescription() }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ Materials ============ --}}
<section class="section section--paper">
    <div class="wrap">
        <h2 class="reveal" style="max-width: 18ch; margin-bottom: 40px">{{ __('site.home.materials_title') }}</h2>
        <div class="features">
            @foreach (__('site.home.materials') as $i => $feature)
                <div class="feature reveal">
                    <span class="feature-icon">@include('partials.icon', ['name' => ['drop', 'layers', 'hinge'][$i] ?? 'check'])</span>
                    <h3>{{ $feature['title'] }}</h3>
                    <p>{{ $feature['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ Latest updates (small strip; replaces the old 30-post feed) ============ --}}
@if ($highlights->isNotEmpty())
<section class="section--tight">
    <div class="wrap">
        <h2 class="reveal" style="font-size: 1.6rem; margin-bottom: 20px">{{ __('site.home.updates_title') }}</h2>
        <div class="updates">
            @foreach ($highlights as $highlight)
                <a class="update reveal" href="{{ config('company.social.facebook') }}" target="_blank" rel="noopener">
                    <div class="card-media">
                        @include('partials.media', ['src' => $highlight->image_url, 'alt' => ''])
                    </div>
                    <p>{{ $highlight->title }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CTA ============ --}}
<section class="section">
    <div class="wrap">
        <div class="cta-band reveal">
            <div>
                <h2>{{ __('site.home.cta_title') }}</h2>
                <p>{{ __('site.home.cta_body') }}</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('quote.create') }}" class="btn btn--oak btn--block">{{ __('site.nav.quote') }}</a>
                <div class="cta-channels">
                    @include('partials.channels')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
