@extends('layouts.app')

@section('title', 'About Us — Ajax Trading Corporation')
@section('meta_description', 'Ajax Trading Corporation is a Philippine manufacturer of melamine boards and custom modular kitchen cabinets, headquartered in Makati City with a CNC production facility in San Pablo City, Laguna.')

@section('content')
<section class="about-page">
    <h1>About Ajax Trading Corporation</h1>
    <p class="lead">Ajax Trading Corporation is a premium modular furniture manufacturer and materials trading company, headquartered in Makati City with a dedicated CNC production facility in San Pablo City, Laguna.</p>

    <div class="about-grid">
        <div class="about-block">
            <h2>What we make</h2>
            <p>Modular kitchens, wardrobes, cabinets, and custom furniture, produced at up to 3,000 linear meters per month. We also produce our own melamine and pressed boards in-house.</p>
        </div>
        <div class="about-block">
            <h2>Quality control</h2>
            <p>We import our own materials rather than relying on third-party suppliers — this keeps quality control in our hands from raw material to finished product.</p>
        </div>
        <div class="about-block">
            <h2>Design</h2>
            <p>Our design team works with every client from concept to execution, blending aesthetics with functionality for every modular kitchen we build.</p>
        </div>
    </div>

    <div class="about-cta">
        <p>Want to see what we can build for your space?</p>
        <a href="{{ route('configurator') }}">Build your own kitchen</a>
        <a href="{{ route('quote.create') }}">Get in touch</a>
    </div>
</section>
@endsection
