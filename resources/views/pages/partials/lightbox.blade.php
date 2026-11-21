<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-hidden="true" aria-label="{{ __('site.portfolio.title') }}">
    <div class="lb-head">
        <div><h2></h2><p></p></div>
        <a href="{{ route('design') }}" class="btn btn--gold btn--sm lb-cta">{{ __('site.nav.cta') }}</a>
        <button type="button" class="lb-icon lb-close" aria-label="{{ __('site.portfolio.close') }}">@include('partials.icon', ['name' => 'close'])</button>
    </div>
    <div class="lb-stage">
        <img alt="">
        <button type="button" class="lb-icon lb-prev" aria-label="{{ __('site.portfolio.prev') }}">@include('partials.icon', ['name' => 'arrow'])</button>
        <button type="button" class="lb-icon lb-next" aria-label="{{ __('site.portfolio.next') }}">@include('partials.icon', ['name' => 'arrow'])</button>
    </div>
    <div class="lb-thumbs"></div>
</div>
