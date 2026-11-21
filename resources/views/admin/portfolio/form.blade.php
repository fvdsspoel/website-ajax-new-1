@extends('admin.layout')
@section('title', $item->exists ? 'Edit project' : 'Add project')
@section('content')
<h1>{{ $item->exists ? 'Edit project' : 'Add project' }}</h1>
<form method="POST" action="{{ $item->exists ? route('admin.portfolio.update', $item) : route('admin.portfolio.store') }}" enctype="multipart/form-data" class="admin-form">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $item->title) }}" required>

    <label for="location">Location (e.g. Sta. Rosa, Laguna)</label>
    <input type="text" id="location" name="location" value="{{ old('location', $item->location) }}">

    <label for="category">Category</label>
    <select id="category" name="category" required>
        @foreach ($categories as $key => $label)
            <option value="{{ $key }}" @selected(old('category', $item->category) === $key)>{{ $label }}</option>
        @endforeach
    </select>

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $item->description) }}</textarea>

    <label for="image">Photo</label>
    <input type="file" id="image" name="image" accept="image/*">

    <label for="gallery">More photos for the gallery (you can choose several)</label>
    <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
    @if (! empty($item->images))
        <p class="muted">{{ count($item->images) }} photo(s) in the gallery now.</p>
    @endif
    @if ($item->image_url)
        <p class="muted">Current: <img src="{{ $item->coverThumbUrl() }}" class="admin-thumb"></p>
    @endif

    <label class="checkbox-label"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured))> Featured on homepage</label>

    <button type="submit" class="admin-btn">Save</button>
</form>
@endsection
