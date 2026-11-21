@extends('layouts.app')
@section('title', __('site.about.eyebrow').' — Ajax Trading Corporation')

@section('content')
<section class="page-hero has-image">
    <img src="{{ asset('images/factory/cnc-operator.webp') }}" alt="">
    <div class="wrap">
        <span class="eyebrow">{{ __('site.about.eyebrow') }}</span>
        <h1>{{ __('site.about.title') }}</h1>
        <p class="lead">{{ __('site.about.lead') }}</p>
    </div>
</section>

<section class="stats" aria-label="Ajax in numbers">
    <div class="wrap"><div class="stats-grid" data-counters>
        @foreach (config('ajax.stats') as $s)
            <div class="stat"><strong><span data-count="{{ $s['value'] }}">{{ number_format($s['value']) }}</span><em>{{ $s['suffix'] }}</em></strong><span>{{ __('site.stats.'.$s['key']) }}</span></div>
        @endforeach
    </div></div>
</section>

<section class="section">
    <div class="wrap split">
        <div data-reveal>
            <span class="eyebrow">{{ __('site.about.story_title') }}</span>
            <div class="prose" style="margin-top:18px">
                @foreach (__('site.about.story') as $p)<p>{{ $p }}</p>@endforeach
            </div>
        </div>
        <img src="{{ asset('images/factory/assembly.webp') }}" alt="" loading="lazy" data-reveal style="--d:.1s;aspect-ratio:4/4.4">
    </div>
</section>

<section class="section section--sand">
    <div class="wrap">
        <div class="mv" data-reveal>
            <div><h3>{{ __('site.about.mission_title') }}</h3><p>{{ __('site.about.mission') }}</p></div>
            <div><h3>{{ __('site.about.vision_title') }}</h3><p>{{ __('site.about.vision') }}</p></div>
        </div>
        <div class="section-head" data-reveal style="margin-top:72px">
            <h2>{{ __('site.about.values_title') }}</h2>
        </div>
        <div class="features">
            @foreach (__('site.about.values') as $i => $v)
                <div class="feature" data-reveal style="--d:{{ $i * .07 }}s">
                    <div class="feature-icon">@include('partials.icon', ['name' => ['ruler', 'check', 'shield', 'home'][$i] ?? 'star'])</div>
                    <h3>{{ $v['title'] }}</h3><p>{{ $v['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('pages.partials.visit')
@endsection
