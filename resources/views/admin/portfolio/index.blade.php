@extends('admin.layout')
@section('title', 'Portfolio')
@section('content')
<div class="admin-header">
    <h1>Portfolio ({{ $items->count() }})</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="admin-btn">Add project</a>
</div>
<table class="admin-table">
    <thead><tr><th>Photo</th><th>Title</th><th>Category</th><th></th></tr></thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td>@if ($item->image_url)<img src="{{ $item->image_url }}" class="admin-thumb">@else<span class="muted">No photo</span>@endif</td>
            <td>{{ $item->title }}</td>
            <td>{{ ucfirst($item->category) }}</td>
            <td class="admin-actions">
                <a href="{{ route('admin.portfolio.edit', $item) }}">Edit</a>
                <form method="POST" action="{{ route('admin.portfolio.destroy', $item) }}" onsubmit="return confirm('Remove this project?')">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
