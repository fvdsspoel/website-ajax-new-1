@extends('layouts.app')
@section('title', __('site.seo.factory.title'))
@section('meta_description', __('site.seo.factory.description'))

@section('content')
<section class="page-hero has-image">
    {{-- Real clips from our factory (silent, 21 s, ~2 MB); the photo shows until it plays and for visitors who prefer less motion. --}}
    <img src="{{ asset('video/factory-reel-poster.webp') }}" alt="">
    <video class="hero-video" autoplay muted loop playsinline preload="metadata" poster="{{ asset('video/factory-reel-poster.webp') }}" aria-hidden="true">
        <source src="{{ asset('video/factory-reel.mp4') }}" type="video/mp4">
    </video>
    <div class="wrap">
        <span class="eyebrow">{{ __('site.factory.eyebrow') }}</span>
        <h1>{{ __('site.factory.title') }}</h1>
        <p class="lead">{{ __('site.factory.lead') }}</p>
    </div>
</section>

<section class="section section--tight">
    <div class="wrap">
        <div class="reel" data-reveal>
            @foreach (config('ajax.factory_reel') as [$src, $label])
                @php $cap = trans()->has('site.factory.reel.'.$label) ? __('site.factory.reel.'.$label) : (trans()->has('site.factory.machines.'.$label.'.name') ? __('site.factory.machines.'.$label.'.name') : __('site.factory.boards_title')); @endphp
                <figure><img src="{{ asset($src) }}" alt="{{ $cap }}" loading="lazy">
                    <figcaption>{{ $cap }}</figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:24px">
    <div class="wrap">
        <div class="mgroups">
            @foreach (config('ajax.machine_groups') as $group => $keys)
                <div class="mgroup">
                    <h3 data-reveal>{{ __('site.factory.groups.'.$group) }} <span>{{ count($keys) }}</span></h3>
                    <div class="machines">
                        @foreach ($keys as $i => $m)
                            @php $photo = config('ajax.machine_photos.'.$m); @endphp
                            <article class="machine" data-reveal style="--d:{{ $i * .06 }}s">
                                <div class="machine-img @if ($photo) cover @endif"><img src="{{ asset($photo ?? 'images/machines/'.$m.'.webp') }}" alt="{{ __('site.factory.machines.'.$m.'.name') }}" loading="lazy"></div>
                                <div class="machine-body"><h4>{{ __('site.factory.machines.'.$m.'.name') }}</h4><p>{{ __('site.factory.machines.'.$m.'.text') }}</p></div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section section--dark">
    <div class="wrap factory-grid">
        <div data-reveal>
            <span class="eyebrow">{{ __('site.factory.eyebrow') }}</span>
            <h2 class="h2" style="margin-top:14px">{{ __('site.factory.boards_title') }}</h2>
            <p class="lead" style="margin-top:16px">{{ __('site.factory.boards_text') }}</p>
            <div class="factory-points">
                <div class="factory-point">@include('partials.icon', ['name' => 'stone'])<div><h3>{{ __('site.factory.stone_title') }}</h3><p>{{ __('site.factory.stone_text') }}</p></div></div>
            </div>
        </div>
        <div class="collage" data-reveal style="--d:.12s">
            <figure><img src="{{ asset('images/factory/hot-press-10.webp') }}" alt="" loading="lazy"><figcaption>{{ __('site.factory.machines.multi_press.name') }}</figcaption></figure>
            <figure><img src="{{ asset('images/factory/colour-rack.webp') }}" alt="" loading="lazy"></figure>
            <figure><img src="{{ asset('images/factory/warehouse-1.webp') }}" alt="" loading="lazy"></figure>
        </div>
    </div>
</section>

@include('pages.partials.upload-band')
@endsection
