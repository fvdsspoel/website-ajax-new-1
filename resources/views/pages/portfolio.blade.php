@extends('layouts.app')

@section('title', 'Our Portfolio — Ajax Trading Corporation')
@section('meta_description', 'Browse completed kitchen, wardrobe, and commercial modular furniture projects by Ajax Trading Corporation.')

@section('content')
<section class="portfolio-page">
    <h1>Our portfolio</h1>

    <div class="portfolio-filters">
        <button type="button" class="filter-btn active" data-filter="all">All</button>
        @foreach ($categories as $key => $label)
            <button type="button" class="filter-btn" data-filter="{{ $key }}">{{ $label }}</button>
        @endforeach
    </div>

    <div class="portfolio-grid" id="portfolio-grid">
        @forelse ($items as $item)
            <div class="portfolio-card" data-category="{{ $item->category }}">
                <img src="{{ $item->image_url ?? asset('images/placeholder.webp') }}" alt="{{ $item->title }}">
                <div class="portfolio-card-body">
                    <h3>{{ $item->title }}</h3>
                    <p>{{ $item->description }}</p>
                </div>
            </div>
        @empty
            <p class="muted">Portfolio photos coming soon — <a href="{{ route('quote.create') }}">get in touch</a> to see completed projects.</p>
        @endforelse
    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.filter-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        document.querySelectorAll('.portfolio-card').forEach((card) => {
            card.style.display = (filter === 'all' || card.dataset.category === filter) ? '' : 'none';
        });
    });
});
</script>
@endpush
