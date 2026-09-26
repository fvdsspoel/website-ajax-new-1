@extends('layouts.app')

@section('title', __('site.accessories.title').' — Ajax Trading Corporation')
@section('meta_description', __('site.accessories.lead'))

@section('content')
<section class="page-head">
    <div class="wrap">
        <h1>{{ __('site.accessories.title') }}</h1>
        <p class="lead">{{ __('site.accessories.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap">
        <div class="chips" role="group" aria-label="{{ __('site.accessories.title') }}" data-filter-group="acc-grid">
            <button type="button" class="chip" data-filter="all" aria-pressed="true">{{ __('site.portfolio.all') }}</button>
            @foreach ($categories as $key => $label)
                @if ($products->where('category', $key)->isNotEmpty())
                    <button type="button" class="chip" data-filter="{{ $key }}" aria-pressed="false">{{ __('site.accessories.categories.'.$key) }}</button>
                @endif
            @endforeach
        </div>

        <div class="grid grid--4" id="acc-grid">
            @foreach ($products as $product)
                <article class="card acc-card" data-category="{{ $product->category }}">
                    <div class="card-media">
                        @include('partials.media', ['src' => $product->image_url, 'alt' => $product->localizedName()])
                    </div>
                    <div class="card-body">
                        <span class="card-tag">{{ __('site.accessories.categories.'.$product->category) }}</span>
                        <h3>{{ $product->localizedName() }}</h3>
                        <p>{{ $product->localizedDescription() }}</p>
                        <div class="card-foot">
                            <a class="link-arrow" href="{{ route('quote.create', ['interest' => 'accessories', 'product' => $product->name]) }}">{{ __('site.common.ask_about') }}</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="muted" style="margin-top: 32px">
            {{ __('site.accessories.shop_note') }}
            <a href="{{ config('company.social.shopee') }}" target="_blank" rel="noopener">{{ __('site.accessories.shop_cta') }} →</a>
        </p>
    </div>
</section>
@endsection
