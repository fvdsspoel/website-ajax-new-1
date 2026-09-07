@extends('layouts.app')

@section('title', 'Our Portfolio — Ajax Trading Corporation')
@section('meta_description', 'Browse completed kitchen, wardrobe, and commercial modular furniture projects by Ajax Trading Corporation.')

@section('content')
<section class="portfolio-page">
    <h1>Our portfolio</h1>
    <div class="portfolio-filters">
        <button type="button" data-filter="kitchen">Kitchens</button>
        <button type="button" data-filter="wardrobe">Wardrobes</button>
        <button type="button" data-filter="commercial">Commercial</button>
    </div>
    <div class="portfolio-grid" id="portfolio-grid">
        {{-- Populated from the products/portfolio data source once wired up --}}
    </div>
</section>
@endsection
