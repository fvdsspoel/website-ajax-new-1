{{-- Our boards — kept simple: what we make, two colours on a board, waterproof marine boards (price on request) --}}
<section class="section section--sand" id="boards">
    <div class="wrap">
        <div class="section-head section-head--split" data-reveal>
            <div>
                <span class="eyebrow">{{ __('site.boards.eyebrow') }}</span>
                <h2 style="margin-top:14px">{{ __('site.boards.title') }}</h2>
            </div>
            <p class="lead">{{ __('site.boards.lead') }}</p>
        </div>
        <div class="boards">
            <figure class="boards-photo" data-reveal>
                <img src="{{ asset('images/site/boards.webp') }}" alt="" loading="lazy">
            </figure>
            <div class="boards-list">
                @foreach (__('site.boards.items') as $i => $b)
                    <div class="feature" data-reveal style="--d:{{ $i * .08 }}s">
                        <div class="feature-icon">@include('partials.icon', ['name' => ['layers', 'brush', 'drop'][$i] ?? 'layers'])</div>
                        <h3>{{ $b['title'] }} @if ($i === 2)<span class="tag">{{ __('site.boards.price_on_request') }}</span>@endif</h3>
                        <p>{{ $b['text'] }}</p>
                    </div>
                @endforeach
                <a href="{{ route('quote.create', ['interest' => 'boards']) }}" class="btn btn--primary btn--lg" data-reveal>{{ __('site.boards.cta') }} <span class="arrow">@include('partials.icon', ['name' => 'arrow'])</span></a>
            </div>
        </div>
    </div>
</section>
