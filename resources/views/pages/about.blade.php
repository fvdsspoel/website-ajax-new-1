@extends('layouts.app')

@section('title', __('site.about.eyebrow').' — Ajax Trading Corporation')
@section('meta_description', __('site.about.lead'))

@section('content')
<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">{{ __('site.about.eyebrow') }}</span>
        <h1>{{ __('site.about.title') }}</h1>
        <p class="lead">{{ __('site.about.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap">
        <div class="about-blocks">
            @foreach (__('site.about.blocks') as $block)
                <div class="about-block reveal">
                    <h2 style="font-size: 1.35rem">{{ $block['title'] }}</h2>
                    <p>{{ $block['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section section--paper">
    <div class="wrap">
        <h2 class="reveal">{{ __('site.home.process_title') }}</h2>
        <ol class="process" style="margin-top: 32px">
            @foreach (__('site.home.process') as $step)
                <li class="reveal">
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['body'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2 class="reveal">{{ __('site.about.locations_title') }}</h2>
        <div class="locations" style="margin-top: 24px">
            @foreach (__('site.about.locations') as $loc)
                <div class="location reveal">
                    <h3>{{ $loc['title'] }}</h3>
                    <p>{{ $loc['body'] }}</p>
                </div>
            @endforeach
        </div>
        <div class="btn-row" style="margin-top: 36px">
            <a href="{{ route('configurator') }}" class="btn btn--primary">{{ __('site.nav.build') }}</a>
            <a href="{{ route('machines') }}" class="btn btn--ghost">{{ __('site.home.factory_cta') }}</a>
        </div>
    </div>
</section>
@endsection
