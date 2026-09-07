@extends('admin.layout')
@section('title', 'Products')
@section('content')
<div class="admin-header">
    <h1>Products ({{ $products->count() }})</h1>
    <a href="{{ route('admin.products.create') }}" class="admin-btn">Add product</a>
</div>
<table class="admin-table">
    <thead><tr><th>Photo</th><th>Name</th><th>Category</th><th></th></tr></thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>@if ($product->image_url)<img src="{{ $product->image_url }}" class="admin-thumb">@else<span class="muted">No photo</span>@endif</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category }}</td>
            <td class="admin-actions">
                <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Remove this product?')">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
