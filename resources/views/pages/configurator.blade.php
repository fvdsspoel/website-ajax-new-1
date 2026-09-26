@extends('layouts.app')

@section('title', __('site.builder.title').' — Ajax Trading Corporation')
@section('meta_description', __('site.builder.lead'))

@php
    // Visual swatches only — the chosen colour is sent to sales with the design.
    $colours = [
        'white' => '#f4f2ee',
        'latte' => '#d8c3a5',
        'oak' => '#c89a64',
        'walnut' => '#7a5436',
        'grey' => '#4a4d55',
        'navy' => '#1e2a4a',
    ];
    $firstSubstrate = array_key_first($substrates);
@endphp

@section('content')
<section class="page-head" style="padding-bottom: 24px">
    <div class="wrap">
        <h1>{{ __('site.builder.title') }}</h1>
        <p class="lead">{{ __('site.builder.lead') }}</p>
    </div>
</section>

<section class="section" style="padding-top: 0">
    <div class="wrap builder">
        {{-- ---------- Controls ---------- --}}
        <div>
            <fieldset class="builder-step" style="border: 0; padding: 0; margin: 0 0 28px">
                <legend class="field-label"><span class="step-num">1</span> {{ __('site.builder.step_layout') }}</legend>
                <div class="choice-grid">
                    @foreach (__('site.builder.layouts') as $key => $label)
                        <label class="choice">
                            <input type="radio" name="layout" value="{{ $key }}" @checked($loop->first)>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <fieldset class="builder-step" style="border: 0; padding: 0; margin: 0 0 28px">
                <legend class="field-label"><span class="step-num">2</span> {{ __('site.builder.step_material') }}</legend>
                <div class="choice-grid">
                    @foreach ($substrates as $key => $substrate)
                        <label class="choice">
                            <input type="radio" name="substrate" value="{{ $key }}" @checked($key === $firstSubstrate)>
                            <span>{{ trans()->has('site.builder.materials.'.$key) ? __('site.builder.materials.'.$key) : $substrate['label'] }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <fieldset class="builder-step" style="border: 0; padding: 0; margin: 0 0 28px">
                <legend class="field-label"><span class="step-num">3</span> {{ __('site.builder.step_colour') }}</legend>
                <div class="swatches">
                    @foreach ($colours as $key => $hex)
                        <label class="swatch">
                            <input type="radio" name="colour" value="{{ $key }}" data-hex="{{ $hex }}" @checked($loop->first)>
                            <span><i style="background: {{ $hex }}"></i>{{ __('site.builder.colours.'.$key) }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <div class="builder-step">
                <p class="field-label"><span class="step-num">4</span> {{ __('site.builder.step_modules') }}</p>
                <div class="module-buttons">
                    @foreach ($moduleTypes as $key => $type)
                        <button type="button" class="module-add" data-type="{{ $key }}">+ {{ __('site.builder.modules.'.$key) }}</button>
                    @endforeach
                </div>
            </div>

            @if ($accessories->isNotEmpty())
                <fieldset class="builder-step" style="border: 0; padding: 0; margin: 0 0 28px">
                    <legend class="field-label"><span class="step-num">5</span> {{ __('site.builder.step_accessories') }} <span class="muted" style="font-weight: 400">({{ __('site.builder.optional') }})</span></legend>
                    <div class="choice-grid">
                        @foreach ($accessories as $product)
                            <label class="choice">
                                <input type="checkbox" name="accessories[]" value="{{ $product->name }}">
                                <span>{{ $product->localizedName() }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endif
        </div>

        {{-- ---------- Live preview + send ---------- --}}
        <div class="builder-preview">
            <div class="preview-card">
                <div class="preview-head">
                    <h2>{{ __('site.builder.preview') }}</h2>
                    <span class="muted"><strong id="module-count">0</strong> {{ __('site.builder.count') }}</span>
                </div>

                <div class="elev" id="elev" aria-live="polite">
                    <div class="elev-row elev-wall" id="elev-wall"></div>
                    <div class="elev-counter" id="elev-counter" hidden></div>
                    <div class="elev-row" id="elev-base"></div>
                    <p class="elev-empty" id="elev-empty">{{ __('site.builder.empty') }}</p>
                    <div class="elev-floor"></div>
                </div>
                <ul class="module-list" id="module-list"></ul>

                <form id="submit-form" novalidate>
                    <h3>{{ __('site.builder.send_title') }}</h3>
                    <div class="field">
                        <label for="name">{{ __('site.builder.name') }}</label>
                        <input type="text" id="name" name="name" required autocomplete="name">
                    </div>
                    <div class="field">
                        <label for="contact">{{ __('site.builder.contact') }}</label>
                        <input type="text" id="contact" name="contact" required autocomplete="tel" inputmode="tel">
                    </div>
                    <button type="submit" class="btn btn--primary btn--block">{{ __('site.builder.submit') }}</button>
                    <p id="form-message" role="status" class="form-note"></p>
                    <p class="form-note">{{ __('site.builder.note') }}</p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script id="builder-i18n" type="application/json">{!! json_encode([
    'modules' => __('site.builder.modules'),
    'remove' => __('site.builder.remove'),
    'needModule' => __('site.builder.need_module'),
    'needContact' => __('site.quote.name').' / '.__('site.quote.contact'),
    'sending' => __('site.builder.sending'),
    'success' => __('site.builder.success'),
    'error' => __('site.builder.error'),
], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
<script src="{{ asset('js/configurator.js') }}?v=2" data-submit-url="{{ route('configurator.submit') }}" data-csrf="{{ csrf_token() }}"></script>
@endpush
