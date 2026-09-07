@extends('layouts.app')

@section('title', 'Showrooms — Ajax Trading Corporation')
@section('meta_description', 'Visit Ajax Trading Corporation in Makati City or our production facility in San Pablo City, Laguna.')

@section('content')
<section class="showrooms-page">
    <h1>Visit us</h1>
    <div class="showroom-list">
        @foreach ($locations as $location)
            <div class="showroom-card">
                <h2>{{ $location->name }}</h2>
                <p>{{ $location->address }}</p>
                @if ($location->phone)
                    <p><a href="tel:{{ $location->phone }}">{{ $location->phone }}</a></p>
                @endif
                @if ($location->is_factory)
                    <span class="badge">Production facility</span>
                @endif
                @if ($location->is_headquarters)
                    <span class="badge">Head office</span>
                @endif
            </div>
        @endforeach
    </div>
</section>
@endsection
