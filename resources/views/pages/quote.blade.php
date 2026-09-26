@extends('layouts.app')

@section('title', __('site.quote.title').' — Ajax Trading Corporation')
@section('meta_description', __('site.quote.lead'))

@php
    $selectedInterest = old('interest', request('interest', 'kitchen'));
    $prefill = request('product') ? request('product').' — ' : '';
@endphp

@section('content')
<section class="page-head">
    <div class="wrap">
        <h1>{{ __('site.quote.title') }}</h1>
        <p class="lead">{{ __('site.quote.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap form-layout">
        <div class="form-card">
            @if (session('success'))
                <p class="alert alert--ok" role="status">{{ __('site.quote.success') }}</p>
            @endif
            @if (session('error'))
                <p class="alert alert--err" role="alert">{{ __('site.quote.error') }}</p>
            @endif

            <form method="POST" action="{{ route('quote.store') }}" novalidate>
                @csrf
                <fieldset class="field" style="border: 0; padding: 0; margin: 0 0 18px">
                    <legend class="field-label" style="margin-bottom: 8px">{{ __('site.quote.interest') }}</legend>
                    <div class="choice-grid">
                        @foreach (__('site.quote.interests') as $key => $label)
                            <label class="choice">
                                <input type="radio" name="interest" value="{{ $key }}" @checked($selectedInterest === $key)>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <div class="field-row">
                    <div class="field">
                        <label for="name">{{ __('site.quote.name') }}</label>
                        <input type="text" id="name" name="name" required autocomplete="name" value="{{ old('name') }}">
                        @error('name')<span class="hint" style="color: var(--err)">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label for="contact">{{ __('site.quote.contact') }}</label>
                        <input type="text" id="contact" name="contact" required autocomplete="tel" inputmode="tel" value="{{ old('contact') }}">
                        @error('contact')<span class="hint" style="color: var(--err)">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="field">
                    <label for="city">{{ __('site.quote.city') }}</label>
                    <input type="text" id="city" name="city" autocomplete="address-level2" value="{{ old('city') }}">
                </div>

                <div class="field">
                    <label for="message">{{ __('site.quote.message') }}</label>
                    <span class="hint" id="message-hint">{{ __('site.quote.message_hint') }}</span>
                    <textarea id="message" name="message" rows="5" aria-describedby="message-hint">{{ old('message', $prefill) }}</textarea>
                </div>

                <button type="submit" class="btn btn--primary btn--block">{{ __('site.quote.submit') }}</button>
                <p class="form-note">{{ __('site.quote.privacy') }}</p>
            </form>
        </div>

        <aside class="contact-aside">
            <h2>{{ __('site.quote.or_reach') }}</h2>
            <div class="contact-list" style="display: grid; gap: 10px">
                @include('partials.channels', ['variant' => 'light', 'withWhatsapp' => true])
            </div>
            <ul class="contact-list">
                <li style="display: flex; gap: 10px"><span style="width: 20px; flex: none; color: var(--oak)">@include('partials.icon', ['name' => 'phone'])</span>{{ config('company.phone_primary') }} / {{ config('company.phone_secondary') }}</li>
                @if (config('company.email'))
                    <li style="display: flex; gap: 10px"><span style="width: 20px; flex: none; color: var(--oak)">@include('partials.icon', ['name' => 'mail'])</span><a href="mailto:{{ config('company.email') }}">{{ config('company.email') }}</a></li>
                @endif
                <li style="display: flex; gap: 10px"><span style="width: 20px; flex: none; color: var(--oak)">@include('partials.icon', ['name' => 'pin'])</span>{{ config('company.address') }}, Laguna</li>
            </ul>
        </aside>
    </div>
</section>
@endsection
