@extends('layouts.app')

@section('title', 'Products — Ajax Trading Corporation')
@section('meta_description', 'Melamine boards, laminated marine plywood, and modular kitchen hardware manufactured by Ajax Trading Corporation.')

@section('content')
<section class="products-page">
    <h1>Products</h1>
    <p class="lead">What we make — get in touch for current pricing, since we quote per project rather than sell online.</p>

    @foreach ($categories as $key => $label)
        <div class="product-category">
            <h2>{{ $label }}</h2>
            <div class="products-grid">
                @foreach ($products->where('category', $key) as $product)
                    <div class="product-card">
                        <img src="{{ $product->image_url ?? asset('images/placeholder.webp') }}" alt="{{ $product->name }}">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="products-cta">
        <a href="{{ route('quote.create') }}">Ask about a product</a>
    </div>
</section>
@endsection
