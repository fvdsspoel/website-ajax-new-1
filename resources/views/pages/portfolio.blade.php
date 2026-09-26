@extends('layouts.app')

@section('title', __('site.portfolio.title').' — Ajax Trading Corporation')
@section('meta_description', __('site.portfolio.lead'))

@section('content')
<section class="page-head">
    <div class="wrap">
        <h1>{{ __('site.portfolio.title') }}</h1>
        <p class="lead">{{ __('site.portfolio.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap">
        <div class="chips" role="group" aria-label="{{ __('site.portfolio.title') }}" data-filter-group="portfolio-grid">
            <button type="button" class="chip" data-filter="all" aria-pressed="true">{{ __('site.portfolio.all') }} ({{ $items->count() }})</button>
            @foreach ($categories as $key => $label)
                @php $n = $items->where('category', $key)->count(); @endphp
                @if ($n)
                    <button type="button" class="chip" data-filter="{{ $key }}" aria-pressed="false">{{ __('site.portfolio.categories.'.$key) }} ({{ $n }})</button>
                @endif
            @endforeach
        </div>

        @if ($items->isEmpty())
            <p class="muted">{{ __('site.portfolio.empty') }}</p>
        @else
            <div class="grid grid--3" id="portfolio-grid">
                @foreach ($items as $item)
                    <article class="card" data-category="{{ $item->category }}">
                        <div class="card-media">
                            @include('partials.media', ['src' => $item->image_url, 'alt' => $item->title])
                        </div>
                        <div class="card-body">
                            <span class="card-tag">{{ __('site.portfolio.categories.'.$item->category) }}</span>
                            <h3>{{ $item->title }}</h3>
                            @if ($item->description)
                                <p>{{ $item->description }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap">
        <div class="cta-band">
            <div>
                <h2>{{ __('site.portfolio.cta_title') }}</h2>
                <p>{{ __('site.portfolio.cta_body') }}</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('configurator') }}" class="btn btn--oak btn--block">{{ __('site.nav.build') }}</a>
                <div class="cta-channels">@include('partials.channels')</div>
            </div>
        </div>
    </div>
</section>
@endsection
