@extends('layouts.app')
@section('title', __('site.quote.title').' — Ajax Trading Corporation')

@php
    $q = __('site.quote');
    $tel = 'tel:+63'.ltrim(preg_replace('/\D+/', '', config('company.phone_primary')), '0');
@endphp

@section('content')
<section class="page-hero has-image">
    <img src="{{ asset('images/projects/15/01.webp') }}" alt="">
    <div class="wrap">
        <span class="eyebrow">{{ $q['eyebrow'] }}</span>
        <h1>{{ $q['title'] }}</h1>
        <p class="lead">{{ $q['lead'] }}</p>
    </div>
</section>

<section class="section">
    <div class="wrap contact-layout">
        <form class="form-card" method="POST" action="{{ route('quote.store') }}" enctype="multipart/form-data" data-reveal>
            @csrf
            <div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
            @if (session('success'))
                <div class="alert alert--ok" role="status">@include('partials.icon', ['name' => 'check']) {{ $q['success'] }}</div>
                @if (config('company.meta_pixel_id'))<script>window.addEventListener('load', function () { window.fbq && fbq('track', 'Lead'); });</script>@endif
            @elseif (session('error'))
                <div class="alert alert--err" role="alert">{{ $q['error'] }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert--err" role="alert">{{ $errors->first() }}</div>
            @endif

            <div class="field-row">
                <div class="field"><label for="name">{{ $q['name'] }} *</label><input id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="150" required></div>
                <div class="field"><label for="contact">{{ $q['contact'] }} *</label><input id="contact" name="contact" value="{{ old('contact') }}" autocomplete="tel" maxlength="150" required></div>
            </div>
            <div class="field-row">
                <div class="field"><label for="interest">{{ $q['interest'] }}</label>
                    <select id="interest" name="interest">
                        @foreach ($q['interests'] as $k => $label)
                            <option value="{{ $k }}" @selected(old('interest', $interest) === $k)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field"><label for="city">{{ $q['city'] }}</label><input id="city" name="city" value="{{ old('city') }}" maxlength="120"></div>
            </div>
            <div class="field"><label for="message">{{ $q['message'] }}</label><textarea id="message" name="message" maxlength="2000" placeholder="{{ $q['message_ph'] }}">{{ old('message') }}</textarea></div>
            <div class="field">
                <label for="files">{{ $q['files'] }}</label>
                <input id="files" type="file" name="files[]" multiple accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf">
                <span class="hint">{{ __('site.design.upload_hint') }}</span>
            </div>
            <p class="hint" style="margin-bottom:16px">{{ __('site.design.consent') }}</p>
            <button type="submit" class="btn btn--primary btn--lg btn--block">{{ $q['submit'] }} <span class="arrow">@include('partials.icon', ['name' => 'arrow'])</span></button>
        </form>

        <aside data-reveal style="--d:.1s">
            <h2 style="font-size:24px;margin-bottom:16px">{{ $q['or_title'] }}</h2>
            <div class="quick">
                <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" data-track="Contact"><i style="background:linear-gradient(135deg,#00b2ff,#006aff)">@include('partials.icon', ['name' => 'messenger'])</i><span>Messenger<small>Ajax Trading Corporation</small></span></a>
                <a href="viber://chat?number=%2B{{ config('company.viber_number') }}" data-track="Contact"><i style="background:#7360f2">@include('partials.icon', ['name' => 'viber'])</i><span>Viber<small>{{ config('company.phone_primary') }}</small></span></a>
                <a href="https://wa.me/{{ config('company.whatsapp_number') }}" target="_blank" rel="noopener" data-track="Contact"><i style="background:#25d366">@include('partials.icon', ['name' => 'whatsapp'])</i><span>WhatsApp<small>{{ config('company.phone_secondary') }}</small></span></a>
                <a href="{{ $tel }}" data-track="Contact"><i style="background:var(--green)">@include('partials.icon', ['name' => 'phone'])</i><span>{{ __('site.showroom.call') }}<small>{{ config('company.phone_primary') }} · {{ config('company.phone_secondary') }}</small></span></a>
                <a href="{{ route('design') }}"><i style="background:linear-gradient(135deg,var(--gold-2),var(--gold));color:var(--forest)">@include('partials.icon', ['name' => 'sparkle'])</i><span>{{ __('site.nav.design') }}<small>{{ __('site.upload.cta') }}</small></span></a>
            </div>
            <div class="visit-card" style="margin-top:16px">
                <div class="info-row">@include('partials.icon', ['name' => 'pin'])<div><strong>{{ __('site.showroom.name') }}</strong>{{ config('company.address') }}</div></div>
                <div class="info-row">@include('partials.icon', ['name' => 'clock'])<div><strong>{{ __('site.showroom.hours') }}</strong>{{ config('company.hours') }}</div></div>
            </div>
        </aside>
    </div>
</section>
@endsection
