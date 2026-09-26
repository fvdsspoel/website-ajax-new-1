@extends('layouts.app')

@section('title', __('site.showroom.title').' — Ajax Trading Corporation')
@section('meta_description', __('site.showroom.lead'))

@php
    $open = $locations->firstWhere('is_upcoming', false);
    $mapQuery = urlencode($open->address ?? config('company.address').', San Pablo City, Laguna');
@endphp

@section('content')
<section class="page-head">
    <div class="wrap">
        <h1>{{ __('site.showroom.title') }}</h1>
        <p class="lead">{{ __('site.showroom.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap showrooms">
        <div>
            @foreach ($locations as $location)
                <article class="showroom-card {{ $location->is_upcoming ? 'upcoming' : '' }}">
                    <div class="badges">
                        @if ($location->is_upcoming)
                            <span class="badge badge--soon">{{ __('site.showroom.soon') }}</span>
                        @else
                            <span class="badge">{{ __('site.showroom.open') }}</span>
                        @endif
                        @if ($location->is_factory)
                            <span class="badge badge--neutral">{{ __('site.showroom.factory') }}</span>
                        @endif
                    </div>
                    <h2>{{ $location->name }}</h2>
                    <p style="display: flex; gap: 8px; align-items: flex-start">
                        <span style="width: 20px; flex: none; color: var(--oak)">@include('partials.icon', ['name' => 'pin'])</span>
                        {{ $location->address }}
                    </p>
                    @unless ($location->is_upcoming)
                        <p class="muted">{{ __('site.showroom.call_ahead') }}</p>
                        <div class="btn-row">
                            <a class="btn btn--primary btn--sm" href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($location->address) }}" target="_blank" rel="noopener">{{ __('site.showroom.directions') }}</a>
                            @if ($location->phone)
                                <a class="btn btn--ghost btn--sm" href="tel:{{ preg_replace('/\D+/', '', $location->phone) }}">{{ $location->phone }}</a>
                            @endif
                        </div>
                    @endunless
                </article>
            @endforeach
        </div>

        <div class="map">
            <iframe title="{{ __('site.showroom.map_title') }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ $mapQuery }}&output=embed"></iframe>
        </div>
    </div>
</section>
@endsection
