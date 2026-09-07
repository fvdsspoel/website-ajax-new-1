@extends('layouts.app')

@section('title', 'Showroom — Ajax Trading Corporation')
@section('meta_description', 'Visit the Ajax Trading Corporation showroom at our San Pablo City factory. A Manila showroom is coming soon.')

@section('content')
<section class="showrooms-page">
    <h1>Visit our showroom</h1>
    <div class="showroom-list">
        @foreach ($locations as $location)
            <div class="showroom-card {{ $location->is_upcoming ? 'upcoming' : '' }}">
                <h2>{{ $location->name }}</h2>
                <p>{{ $location->address }}</p>
                @if ($location->phone)
                    <p><a href="tel:{{ $location->phone }}">{{ $location->phone }}</a></p>
                @endif
                @if ($location->is_upcoming)
                    <span class="badge badge-upcoming">Opening soon</span>
                @else
                    <span class="badge">Open now</span>
                @endif
                @if ($location->is_factory)
                    <span class="badge">Co-located with our factory</span>
                @endif
            </div>
        @endforeach
    </div>
</section>
@endsection
