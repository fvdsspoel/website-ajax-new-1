{{-- Facebook page feed + all social channels --}}
@php $social = config('company.social'); @endphp
<section class="section section--sand" id="social">
    <div class="wrap social-grid">
        <div data-reveal>
            <span class="eyebrow">{{ __('site.social.eyebrow') }}</span>
            <h2 class="h2" style="margin-top:14px">{{ __('site.social.title') }}</h2>
            <p class="lead" style="margin-top:16px">{{ __('site.social.text') }}</p>
            <div class="social-buttons">
                <a class="sbtn sbtn--facebook" href="{{ $social['facebook'] }}" target="_blank" rel="noopener"><i>@include('partials.icon', ['name' => 'facebook'])</i><span>Facebook<small>Ajax Trading Corp.</small></span></a>
                <a class="sbtn sbtn--instagram" href="{{ $social['instagram'] }}" target="_blank" rel="noopener"><i>@include('partials.icon', ['name' => 'instagram'])</i><span>Instagram<small>@ajaxtradingcorporation</small></span></a>
                <a class="sbtn sbtn--tiktok" href="{{ $social['tiktok'] }}" target="_blank" rel="noopener"><i>@include('partials.icon', ['name' => 'tiktok'])</i><span>TikTok<small>@ajaxtradingcorpor</small></span></a>
                <a class="sbtn sbtn--youtube" href="{{ $social['youtube'] }}" target="_blank" rel="noopener"><i>@include('partials.icon', ['name' => 'youtube'])</i><span>YouTube<small>Factory videos</small></span></a>
                <a class="sbtn sbtn--shopee" href="{{ $social['shopee'] }}" target="_blank" rel="noopener"><i>@include('partials.icon', ['name' => 'bag'])</i><span>Shopee<small>Ajax shop</small></span></a>
                <a class="sbtn sbtn--x" href="{{ $social['x'] }}" target="_blank" rel="noopener"><i>@include('partials.icon', ['name' => 'x'])</i><span>X<small>@ajaxtradingco</small></span></a>
            </div>
            <div style="margin-top:22px;display:flex;flex-wrap:wrap;gap:10px">
                <a href="{{ $social['facebook'] }}" target="_blank" rel="noopener" class="btn btn--primary">@include('partials.icon', ['name' => 'facebook']) {{ __('site.social.follow') }}</a>
                <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" class="btn btn--line" data-track="Contact">@include('partials.icon', ['name' => 'messenger']) {{ __('site.social.message') }}</a>
            </div>
        </div>
        <div class="fb-frame" data-reveal style="--d:.12s">
            {{-- Shown until (or if ever not) Facebook's own feed loads on top of it. --}}
            <a class="fb-under" href="{{ $social['facebook'] }}" target="_blank" rel="noopener" aria-label="Ajax Trading Corporation on Facebook">
                <span class="pics">
                    @foreach (['18/02', '19/03', '15/01', '04/01'] as $ph)<img src="{{ asset('images/projects/'.$ph.'-sm.webp') }}" alt="" loading="lazy">@endforeach
                </span>
                <span class="bar"><i>@include('partials.icon', ['name' => 'facebook'])</i><span><strong>Ajax Trading Corporation</strong><small>{{ __('site.social.follow') }}</small></span></span>
            </a>
            {{-- Facebook's own Page plugin: the latest posts of the Ajax page, loaded only when it scrolls into view. --}}
            <iframe data-fb-src="https://www.facebook.com/plugins/page.php?href={{ urlencode(config('company.facebook_page')) }}&tabs=timeline&width=500&height=560&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true"
                    title="Ajax Trading Corporation on Facebook" loading="lazy" scrolling="no" allow="encrypted-media; clipboard-write"></iframe>
        </div>
    </div>
</section>
@push('scripts')
<script>
(function () {
    var f = document.querySelector('iframe[data-fb-src]');
    if (!f) return;
    var load = function () { if (!f.src) f.src = f.dataset.fbSrc; };
    if ('IntersectionObserver' in window) {
        var o = new IntersectionObserver(function (e) { if (e[0].isIntersecting) { load(); o.disconnect(); } }, { rootMargin: '400px' });
        o.observe(f);
    } else { load(); }
})();
</script>
@endpush
