@extends('layouts.app')

@section('title', __('site.machines.title').' — Ajax Trading Corporation')
@section('meta_description', __('site.machines.lead'))

@section('content')
<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">{{ __('site.machines.eyebrow') }}</span>
        <h1>{{ __('site.machines.title') }}</h1>
        <p class="lead">{{ __('site.machines.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap">
        {{-- Photos: drop files named machine-1.jpg … machine-5.jpg into public/images/ (same order as the list). --}}
        @foreach (__('site.machines.list') as $i => $machine)
            @php
                $n = $i + 1;
                $photo = file_exists(public_path("images/machine-{$n}.jpg")) ? asset("images/machine-{$n}.jpg") : null;
            @endphp
            <article class="machine reveal">
                <div class="machine-media">
                    @include('partials.media', ['src' => $photo, 'alt' => $machine['title'], 'label' => __('site.machines.photo_note')])
                </div>
                <div>
                    <span class="machine-num">{{ str_pad($n, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2 style="font-size: clamp(1.5rem, 2.6vw, 2rem)">{{ $machine['title'] }}</h2>
                    <p>{{ $machine['body'] }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap">
        <div class="cta-band">
            <div>
                <h2>{{ __('site.machines.cta_title') }}</h2>
                <p>{{ __('site.machines.cta_body') }}</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('showrooms') }}" class="btn btn--oak btn--block">{{ __('site.machines.cta_button') }}</a>
                <div class="cta-channels">@include('partials.channels')</div>
            </div>
        </div>
    </div>
</section>
@endsection
