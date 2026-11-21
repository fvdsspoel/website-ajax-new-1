@extends('layouts.app')
@section('title', __('site.seo.portfolio.title'))
@section('meta_description', __('site.seo.portfolio.description'))

@section('content')
<section class="page-hero has-image">
    <img src="{{ asset('images/projects/19/01.webp') }}" alt="">
    <div class="wrap">
        <span class="eyebrow">{{ __('site.portfolio.eyebrow') }}</span>
        <h1>{{ __('site.portfolio.title') }}</h1>
        <p class="lead">{{ __('site.portfolio.lead') }}</p>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="filters" data-filters role="group" aria-label="{{ __('site.portfolio.title') }}">
            <button type="button" class="filter" data-filter="all" aria-pressed="{{ $type ? 'false' : 'true' }}">{{ __('site.portfolio.all') }} · {{ $items->count() }}</button>
            @foreach (array_keys($categories) as $cat)
                @php $n = $items->where('category', $cat)->count(); @endphp
                @if ($n)
                    <button type="button" class="filter" data-filter="{{ $cat }}" aria-pressed="{{ $type === $cat ? 'true' : 'false' }}">{{ __('site.portfolio.categories.'.$cat) }} · {{ $n }}</button>
                @endif
            @endforeach
        </div>
        <div class="projects">
            @foreach ($items as $i => $item)
                @include('pages.partials.project', ['item' => $item, 'delay' => ($i % 3) * .07, 'hidden' => $type && $item->category !== $type])
            @endforeach
        </div>
    </div>
</section>

@include('pages.partials.upload-band')
@include('pages.partials.lightbox')
@endsection
