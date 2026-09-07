{{--
    Replaces the old full-feed homepage dump (30+ posts before any
    product content — report Section 2). Shows a small recent strip
    only; the full feed, if wanted, belongs on its own /highlights
    page, not the homepage.
--}}
<section class="highlights-strip">
    <h2>Recent from Ajax</h2>
    <div class="highlights-grid">
        @forelse ($highlights ?? [] as $highlight)
            <a href="{{ route('home') }}#" class="highlight-card">
                <img src="{{ $highlight->image_url ?? asset('images/placeholder.webp') }}" alt="">
                <p>{{ $highlight->title }}</p>
            </a>
        @empty
            <p class="muted">Recent updates will appear here.</p>
        @endforelse
    </div>
</section>
