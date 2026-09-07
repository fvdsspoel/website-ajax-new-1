@extends('admin.layout')
@section('title', $highlight->exists ? 'Edit highlight' : 'Add highlight')
@section('content')
<h1>{{ $highlight->exists ? 'Edit highlight' : 'Add highlight' }}</h1>
<form method="POST" action="{{ $highlight->exists ? route('admin.highlights.update', $highlight) : route('admin.highlights.store') }}" enctype="multipart/form-data" class="admin-form">
    @csrf
    @if ($highlight->exists) @method('PUT') @endif

    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $highlight->title) }}" required>

    <label for="body">Body</label>
    <textarea id="body" name="body" rows="4">{{ old('body', $highlight->body) }}</textarea>

    <label for="image">Photo</label>
    <input type="file" id="image" name="image" accept="image/*">
    @if ($highlight->image_url)
        <p class="muted">Current: <img src="{{ $highlight->image_url }}" class="admin-thumb"></p>
    @endif

    <label for="published_at">Publish date (blank = draft, hidden from the homepage)</label>
    <input type="date" id="published_at" name="published_at" value="{{ old('published_at', $highlight->published_at?->format('Y-m-d')) }}">

    <button type="submit" class="admin-btn">Save</button>
</form>
@endsection
