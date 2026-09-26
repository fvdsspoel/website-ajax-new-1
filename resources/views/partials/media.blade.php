{{--
    Image or tasteful placeholder. Until real photos are uploaded via
    /admin, cards show a labelled wood-tone block instead of a broken image.
    Params: $src (nullable), $alt, $label (optional), $dark (bool), $eager (bool)
--}}
@if (!empty($src))
    <img src="{{ $src }}" alt="{{ $alt ?? '' }}" loading="{{ !empty($eager) ? 'eager' : 'lazy' }}" decoding="async">
@else
    <div class="ph {{ !empty($dark) ? 'ph--dark' : '' }}" role="img" aria-label="{{ $alt ?? __('site.common.photo_soon') }}">
        <span>@include('partials.icon', ['name' => 'photo']){{ $label ?? __('site.common.photo_soon') }}</span>
    </div>
@endif
