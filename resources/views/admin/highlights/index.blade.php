@extends('admin.layout')
@section('title', 'Highlights')
@section('content')
<div class="admin-header">
    <h1>Highlights ({{ $highlights->count() }})</h1>
    <a href="{{ route('admin.highlights.create') }}" class="admin-btn">Add highlight</a>
</div>
<table class="admin-table">
    <thead><tr><th>Photo</th><th>Title</th><th>Published</th><th></th></tr></thead>
    <tbody>
        @foreach ($highlights as $highlight)
        <tr>
            <td>@if ($highlight->image_url)<img src="{{ $highlight->image_url }}" class="admin-thumb">@else<span class="muted">No photo</span>@endif</td>
            <td>{{ $highlight->title }}</td>
            <td>{{ $highlight->published_at?->format('M j, Y') ?? 'Draft' }}</td>
            <td class="admin-actions">
                <a href="{{ route('admin.highlights.edit', $highlight) }}">Edit</a>
                <form method="POST" action="{{ route('admin.highlights.destroy', $highlight) }}" onsubmit="return confirm('Remove this highlight?')">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
