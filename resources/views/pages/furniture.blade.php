@extends('layouts.app')
@section('title', __('site.seo.furniture.title'))
@section('meta_description', __('site.seo.furniture.description'))

@section('content')
<section class="page-hero has-image">
    <img src="{{ asset('images/projects/18/02.webp') }}" alt="">
    <div class="wrap">
        <span class="eyebrow">{{ __('site.make.eyebrow') }}</span>
        <h1>{{ __('site.make.title') }}</h1>
        <p class="lead">{{ __('site.make.lead') }}</p>
        <div class="hero-ctas"><a href="{{ route('design') }}" class="btn btn--gold btn--lg">@include('partials.icon', ['name' => 'sparkle']) {{ __('site.nav.design') }}</a></div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        @include('pages.partials.bento')
    </div>
</section>

<section class="section section--sand">
    <div class="wrap">
        <div class="section-head" data-reveal>
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

@include('pages.partials.boards')

@include('pages.partials.upload-band')
@endsection
