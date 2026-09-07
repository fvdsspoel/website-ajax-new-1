@extends('layouts.app')

@section('title', 'Build Your Own Kitchen — Ajax Trading Corporation')
@section('meta_description', 'Design your own modular kitchen online, then request a quote and talk to our sales team — no online pricing or checkout, just a starting point for a real conversation.')

@section('content')
<section class="configurator">
    <h1>Build your own kitchen</h1>
    <p class="lead">Add modules and pick a finish to sketch out your idea. When you're ready, send it to us and a designer will call you with a real quote — no price shown here, this is just a starting point.</p>

    <div class="configurator-layout">
        <div class="configurator-controls">
            <label for="substrate">Board finish</label>
            <select id="substrate" name="substrate">
                @foreach ($substrates as $key => $substrate)
                    <option value="{{ $key }}">{{ $substrate['label'] }}</option>
                @endforeach
            </select>

            <p class="section-label">Modules</p>
            <div id="module-list" aria-live="polite"></div>

            <div class="module-buttons">
                @foreach ($moduleTypes as $key => $type)
                    <button type="button" class="add-module" data-type="{{ $key }}">+ {{ $type['label'] }}</button>
                @endforeach
            </div>
        </div>

        <div class="configurator-summary">
            <div class="summary-row"><span>Modules in your design</span><span id="lm-out">0</span></div>
            <p class="disclaimer">We'll follow up with a proper quote — nothing is charged or ordered here.</p>

            <form id="submit-form">
                <label for="name">Your name</label>
                <input type="text" id="name" name="name" required>

                <label for="contact">Email or phone number</label>
                <input type="text" id="contact" name="contact" required>

                <button type="submit">Request a quote — talk to sales</button>
                <p id="form-message" role="status"></p>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script id="module-lm-data" type="application/json">{!! json_encode(collect($moduleTypes)->map(fn($t) => $t['lm']))->toJson() !!}</script>
<script src="{{ asset('js/configurator.js') }}" data-submit-url="{{ route('configurator.submit') }}" data-csrf="{{ csrf_token() }}"></script>
@endpush
