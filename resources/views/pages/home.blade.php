@extends('layouts.app')

@section('content')
<section class="hero">
    <h1>Premium melamine boards & modular kitchens</h1>
    <p>Manufactured in the Philippines. Design your own kitchen online before you ever talk to a salesperson.</p>
    <a href="{{ route('configurator') }}" class="hero-cta">Build your own kitchen</a>
</section>

<section class="featured-categories">
    <a href="{{ route('products') }}?category=hardware">Universal Hardware System</a>
    <a href="{{ route('products') }}?category=storage">Storage Application</a>
    <a href="{{ route('products') }}?category=boards">Boards</a>
</section>

<section class="why-choose-us">
    <h2>Why choose us</h2>
    <ul>
        <li><strong>Quality assurance</strong> — melamine boards resistant to wear, easy to clean, built to last.</li>
        <li><strong>Variety</strong> — a wide range of designs, colors, and textures.</li>
        <li><strong>In-house importing</strong> — we import our own materials for strict quality control.</li>
    </ul>
</section>

{{-- Condensed highlights strip, not a full-page feed dump — report Section 2 --}}
@include('pages.partials.highlights-strip')

<section class="quote-cta">
    <h2>Get a quote</h2>
    <p>Talk to a designer, or start with the configurator and we'll follow up.</p>
    <a href="{{ route('quote.create') }}">Get a quote</a>
</section>
@endsection
