@extends('layouts.app')

@section('title', 'Build Your Own Kitchen — Ajax Trading Corporation')
@section('meta_description', 'Design your own modular kitchen online. Add cabinet modules, choose your board finish, and see a live price estimate before you talk to a designer.')

@section('content')
<section class="configurator">
    <h1>Build your own kitchen</h1>
    <p class="lead">Add modules, pick a finish, and see your estimate update live. This is a starting point for your designer, not a final quote.</p>

    <div class="configurator-layout">
        <div class="configurator-controls">
            <label for="substrate">Board substrate</label>
            <select id="substrate" name="substrate">
                @foreach ($substrates as $key => $substrate)
                    <option value="{{ $key }}">{{ $substrate['label'] }} — ₱{{ number_format($substrate['rate_per_lm']) }}/lm</option>
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
            <div class="summary-row"><span>Total run length</span><span id="lm-out">0.0 lm</span></div>
            <div class="summary-row summary-price"><span>Estimated price</span><span id="price-out">₱0</span></div>
            <p class="disclaimer">Live estimate only — final price confirmed with a designer.</p>

            <form id="submit-form">
                <label for="name">Your name</label>
                <input type="text" id="name" name="name" required>

                <label for="contact">Phone or email</label>
                <input type="text" id="contact" name="contact" required>

                <button type="submit">Request this design</button>
                <p id="form-message" role="status"></p>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/configurator.js') }}" data-price-url="{{ route('configurator.price') }}" data-submit-url="{{ route('configurator.submit') }}" data-csrf="{{ csrf_token() }}"></script>
@endpush
