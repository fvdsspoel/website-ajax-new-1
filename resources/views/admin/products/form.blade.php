@extends('admin.layout')
@section('title', $product->exists ? 'Edit product' : 'Add product')
@section('content')
<h1>{{ $product->exists ? 'Edit product' : 'Add product' }}</h1>
<form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="admin-form">
    @csrf
    @if ($product->exists) @method('PUT') @endif

    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>

    <label for="category">Category</label>
    <select id="category" name="category" required>
        @foreach ($categories as $key => $label)
            <option value="{{ $key }}" @selected(old('category', $product->category) === $key)>{{ $label }}</option>
        @endforeach
    </select>

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>

    <label for="image">Photo</label>
    <input type="file" id="image" name="image" accept="image/*">
    @if ($product->image_url)
        <p class="muted">Current: <img src="{{ $product->image_url }}" class="admin-thumb"></p>
    @endif

    <button type="submit" class="admin-btn">Save</button>
</form>
@endsection
