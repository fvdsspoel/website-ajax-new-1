@extends('layouts.app')
@section('title', __('site.seo.colours.title'))
@section('meta_description', __('site.seo.colours.description'))

@php $c = __('site.colours'); $groups = config('colours'); @endphp

@section('content')
<section class="page-hero has-image">
    <img src="{{ asset('images/factory/colour-fan.webp') }}" alt="">
    <div class="wrap">
        <span class="eyebrow">{{ $c['eyebrow'] }}</span>
        <h1>{{ $c['title'] }}</h1>
        <p class="lead">{{ $c['lead'] }}</p>
    </div>
</section>

<section class="section" id="colours">
    <div class="wrap">
        <div class="ctabs" role="tablist" aria-label="{{ $c['title'] }}">
            @foreach ($c['tabs'] as $key => $label)
                <button type="button" role="tab" class="ctab" id="tab-{{ $key }}" aria-controls="panel-{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $label }} <span>{{ count($groups[$key]) }}</span>
                </button>
            @endforeach
        </div>
        <div class="filters" data-finish-filters>
            @foreach ($c['finishes'] as $key => $label)
                <button type="button" class="filter" data-finish="{{ $key }}" aria-pressed="{{ $key === 'all' ? 'true' : 'false' }}">{{ $label }}</button>
            @endforeach
        </div>

        @foreach ($groups as $key => $colours)
            <div class="cpanel" role="tabpanel" id="panel-{{ $key }}" aria-labelledby="tab-{{ $key }}" @if (! $loop->first) hidden @endif>
                @if ($key === 'board')<p class="cnote">@include('partials.icon', ['name' => 'layers']) {{ $c['board_note'] }}</p>@endif
                @if ($key === 'hpl')<p class="cnote">@include('partials.icon', ['name' => 'check']) {{ $c['hpl_note'] }}</p>@endif
                <div class="swatch-grid">
                    @foreach ($colours as $col)
                        <figure class="sw" data-finish="{{ $col['finish'] }}">
                            <div class="sw-chip @if ($col['finish'] === 'gloss') is-gloss @endif" style="background:{{ $col['hex'] }}">
                                @if (! empty($col['image']))<img src="{{ asset($col['image']) }}" alt="" loading="lazy">@endif
                                @if ($key === 'hpl')<span class="sw-edge" style="background:{{ $col['hex'] }}" title="{{ $c['edge'] }}"></span>@endif
                            </div>
                            <figcaption>
                                <strong>{{ $col['name'] }}</strong>
                                <span>{{ $c['finishes'][$col['finish']] }} · <code>{{ $col['code'] }}</code></span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        @endforeach

        <p class="hint" style="margin-top:24px">{{ $c['note'] }}</p>
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:18px">
            <a href="{{ route('design') }}" class="btn btn--primary btn--lg">@include('partials.icon', ['name' => 'sparkle']) {{ $c['cta'] }}</a>
            <a href="{{ route('showrooms') }}" class="btn btn--line btn--lg">@include('partials.icon', ['name' => 'pin']) {{ $c['samples'] }}</a>
        </div>
    </div>
</section>

@include('pages.partials.boards')
@endsection

@push('scripts')
<script>
(function () {
    var tabs = document.querySelectorAll('.ctab'), panels = document.querySelectorAll('.cpanel'), finish = 'all';
    function apply() {
        document.querySelectorAll('.sw').forEach(function (s) { s.hidden = finish !== 'all' && s.dataset.finish !== finish; });
    }
    tabs.forEach(function (t, i) {
        t.addEventListener('click', function () {
            tabs.forEach(function (x, j) { x.setAttribute('aria-selected', i === j ? 'true' : 'false'); panels[j].hidden = i !== j; });
        });
    });
    document.querySelector('[data-finish-filters]').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-finish]'); if (!b) return;
        finish = b.dataset.finish;
        this.querySelectorAll('button').forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
        apply();
    });
})();
</script>
@endpush
