@extends('admin.layout')
@section('title', 'Showrooms')
@section('content')
<div class="admin-header">
    <h1>Locations ({{ $locations->count() }})</h1>
    <a href="{{ route('admin.showrooms.create') }}" class="admin-btn">Add location</a>
</div>
<table class="admin-table">
    <thead><tr><th>Name</th><th>Address</th><th>Flags</th><th></th></tr></thead>
    <tbody>
        @foreach ($locations as $location)
        <tr>
            <td>{{ $location->name }}</td>
            <td>{{ $location->address }}</td>
            <td>
                @if ($location->is_showroom) <span class="tag">Showroom</span> @endif
                @if ($location->is_upcoming) <span class="tag">Upcoming</span> @endif
                @if ($location->is_factory) <span class="tag">Factory</span> @endif
                @if ($location->is_headquarters) <span class="tag">HQ</span> @endif
                @if (! $location->is_active) <span class="tag">Inactive</span> @endif
            </td>
            <td class="admin-actions">
                <a href="{{ route('admin.showrooms.edit', $location) }}">Edit</a>
                <form method="POST" action="{{ route('admin.showrooms.destroy', $location) }}" onsubmit="return confirm('Remove this location?')">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
