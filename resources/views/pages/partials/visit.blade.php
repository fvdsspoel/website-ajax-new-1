{{-- Showroom & factory visit: address, hours, map, call --}}
@php $tel = 'tel:+63'.ltrim(preg_replace('/\D+/', '', config('company.phone_primary')), '0'); @endphp
<section class="section" id="visit">
    <div class="wrap">
        <div class="section-head section-head--split" data-reveal>
            <div>
                <span class="eyebrow">{{ __('site.showroom.eyebrow') }}</span>
                <h2 style="margin-top:14px">{{ __('site.showroom.title') }}</h2>
            </div>
            <p class="lead">{{ __('site.showroom.lead') }}</p>
        </div>
        <div class="visit">
            <div class="visit-card" data-reveal>
                <h3>{{ __('site.showroom.name') }}</h3>
                <div class="info-row">@include('partials.icon', ['name' => 'pin'])<div><strong>{{ __('site.showroom.floor') }}</strong>{{ config('company.address') }}</div></div>
                <div class="info-row">@include('partials.icon', ['name' => 'clock'])<div><strong>{{ __('site.showroom.hours') }}</strong>{{ config('company.hours') }}</div></div>
                <div class="info-row">@include('partials.icon', ['name' => 'phone'])<div><strong>{{ __('site.showroom.call') }}</strong><a href="{{ $tel }}">{{ config('company.phone_primary') }}</a> · {{ config('company.phone_secondary') }}@if (config('company.phone_fm')) · {{ config('company.phone_fm') }}@endif</div></div>
                <div class="info-row">@include('partials.icon', ['name' => 'truck'])<div><strong>{{ __('site.showroom.area_title') }}</strong>{{ __('site.showroom.area') }}</div></div>
                <div style="display:flex;flex-wrap:wrap;gap:10px">
                    <a href="{{ config('company.map_url') }}" target="_blank" rel="noopener" class="btn btn--primary">@include('partials.icon', ['name' => 'pin']) {{ __('site.showroom.directions') }}</a>
                    <a href="{{ $tel }}" class="btn btn--line" data-track="Contact">@include('partials.icon', ['name' => 'phone']) {{ __('site.showroom.call') }}</a>
                </div>
            </div>
            <div class="map" data-reveal style="--d:.08s">
                <iframe src="{{ config('company.map_embed') }}" title="Map — Ajax showroom San Pablo City" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="showroom-photo" data-reveal style="--d:.16s">
                <img src="{{ asset('images/site/showroom-kitchen-sm.webp') }}" alt="{{ __('site.showroom.name') }}" loading="lazy">
            </div>
        </div>
    </div>
</section>
