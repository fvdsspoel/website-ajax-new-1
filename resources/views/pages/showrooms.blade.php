@extends('layouts.app')
@section('title', __('site.seo.showrooms.title'))
@section('meta_description', __('site.seo.showrooms.description'))

@section('content')
<section class="page-hero has-image">
    <img src="{{ asset('images/site/showroom-island.webp') }}" alt="">
    <div class="wrap">
        <span class="eyebrow">{{ __('site.showroom.eyebrow') }}</span>
        <h1>{{ __('site.showroom.title') }}</h1>
        <p class="lead">{{ __('site.showroom.lead') }}</p>
    </div>
</section>
@include('pages.partials.visit')
@include('pages.partials.social')
@endsection
