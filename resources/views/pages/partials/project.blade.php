{{-- One project card; a click opens the whole gallery in the lightbox --}}
@php
    $gallery = $item->gallery();
    $cat = __('site.portfolio.categories.'.$item->category);
    $meta = trim(implode(' · ', array_filter([$item->location, $cat, count($gallery).' '.__('site.portfolio.photos')])));
@endphp
<button type="button" class="project" data-cat="{{ $item->category }}" @if (! empty($hidden)) hidden @endif data-reveal style="--d:{{ $delay ?? 0 }}s"
        data-title="{{ $item->title }}" data-meta="{{ $meta }}{{ $item->description ? ' — '.$item->description : '' }}"
        data-gallery='@json($gallery)' aria-label="{{ __('site.portfolio.view') }}: {{ $item->title }}">
    <div class="project-media">
        <img src="{{ $item->coverThumbUrl() ?? asset('images/site/showroom.webp') }}" alt="{{ $item->title }}" loading="lazy">
    </div>
    @if (count($gallery) > 1)
        <span class="project-count">@include('partials.icon', ['name' => 'photo']) {{ count($gallery) }}</span>
    @endif
    <div class="project-info">
        <h3>{{ $item->title }}</h3>
        <div class="project-meta">
            @if ($item->location)<span>@include('partials.icon', ['name' => 'pin']) {{ $item->location }}</span>@endif
            <span>{{ $cat }}</span>
        </div>
    </div>
</button>
