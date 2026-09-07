@extends('admin.layout')
@section('title', $location->exists ? 'Edit location' : 'Add location')
@section('content')
<h1>{{ $location->exists ? 'Edit location' : 'Add location' }}</h1>
<form method="POST" action="{{ $location->exists ? route('admin.showrooms.update', $location) : route('admin.showrooms.store') }}" class="admin-form">
    @csrf
    @if ($location->exists) @method('PUT') @endif

    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $location->name) }}" required>

    <label for="address">Address</label>
    <input type="text" id="address" name="address" value="{{ old('address', $location->address) }}" required>

    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="{{ old('phone', $location->phone) }}">

    <label class="checkbox-label"><input type="checkbox" name="is_showroom" value="1" @checked(old('is_showroom', $location->is_showroom))> Is a showroom (shows on /showrooms)</label>
    <label class="checkbox-label"><input type="checkbox" name="is_upcoming" value="1" @checked(old('is_upcoming', $location->is_upcoming))> Opening soon (not open yet — shows "Opening soon" badge)</label>
    <label class="checkbox-label"><input type="checkbox" name="is_factory" value="1" @checked(old('is_factory', $location->is_factory))> Production facility</label>
    <label class="checkbox-label"><input type="checkbox" name="is_headquarters" value="1" @checked(old('is_headquarters', $location->is_headquarters))> Head office</label>
    <label class="checkbox-label"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $location->is_active ?? true))> Active</label>

    <button type="submit" class="admin-btn">Save</button>
</form>
@endsection
