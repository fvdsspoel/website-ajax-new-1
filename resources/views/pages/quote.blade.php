@extends('layouts.app')

@section('title', 'Get a Quote — Ajax Trading Corporation')
@section('meta_description', 'Request a quote from Ajax Trading Corporation for melamine boards, modular kitchens, or custom furniture.')

@section('content')
<section class="quote-page">
    <h1>Get a quote</h1>

    @if (session('success'))
        <p class="form-success">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p class="form-error">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('quote.store') }}">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required value="{{ old('name') }}">

        <label for="contact">Phone or email</label>
        <input type="text" id="contact" name="contact" required value="{{ old('contact') }}">

        <label for="message">What are you looking for?</label>
        <textarea id="message" name="message" rows="4">{{ old('message') }}</textarea>

        <button type="submit">Send inquiry</button>
    </form>
</section>
@endsection
