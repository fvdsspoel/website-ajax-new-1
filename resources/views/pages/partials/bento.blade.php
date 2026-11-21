{{-- "What we make" tiles — every furniture type, real photos --}}
<div class="bento">
    @foreach (config('ajax.furniture') as $key => $f)
        <a href="{{ route('portfolio', ['type' => $f['filter']]) }}" class="tile @if ($f['size']) tile--{{ $f['size'] }} @endif" data-reveal style="--d:{{ ($loop->index % 4) * .07 }}s">
            @php $sm = str_replace('.webp', '-sm.webp', $f['image']); @endphp
            <img src="{{ asset($f['size'] !== 'big' && file_exists(public_path($sm)) ? $sm : $f['image']) }}" alt="{{ __('site.make.items.'.$key.'.title') }}" loading="lazy">
            <span class="tile-icon">@include('partials.icon', ['name' => $f['icon']])</span>
            <span class="go">@include('partials.icon', ['name' => 'arrow'])</span>
            <h3>{{ __('site.make.items.'.$key.'.title') }}</h3>
            <p>{{ __('site.make.items.'.$key.'.text') }}</p>
        </a>
    @endforeach
</div>
