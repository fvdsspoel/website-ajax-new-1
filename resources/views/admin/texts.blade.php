@extends('admin.layout')
@section('title', 'Website texts')
@section('content')
@php
    $label = fn ($k) => ucfirst(str_replace(['_', '.'], [' ', ' › '], \Illuminate\Support\Str::after($k, '.')));
@endphp
<div class="admin-header">
    <div>
        <h1>Website texts</h1>
        <p class="lead" style="margin:0">Change any text in English, Tagalog and Bisaya. A green box is changed by your team; <b>"Back to original" (or an empty box) brings the original text back</b>. Changes show on the website right after saving.</p>
    </div>
    <input type="search" id="text-filter" placeholder="Search a word in this section…" style="max-width:280px">
</div>

<nav class="sec-tabs" aria-label="Sections">
    @foreach ($sections as $key => $name)
        <a href="{{ route('admin.texts.index', ['section' => $key]) }}" class="{{ $key === $section ? 'is-active' : '' }}">{{ $name }}@if(($counts[$key] ?? 0) > 0)<i>{{ $counts[$key] }}</i>@endif</a>
    @endforeach
</nav>

<form method="POST" action="{{ route('admin.texts.update') }}" class="card" id="texts-form">
    @csrf
    <input type="hidden" name="section" value="{{ $section }}">
    <div class="text-head"><div>Text</div>@foreach ($locales as $code => $name)<div>{{ $name }}</div>@endforeach</div>
    @foreach ($keys as $k)
        <div class="text-row" data-search="{{ \Illuminate\Support\Str::lower($k.' '.collect(array_keys($locales))->map(fn ($l) => $changed[$l][$k]->value ?? $defaults[$l][$k] ?? '')->implode(' ')) }}">
            <div class="k"><b>{{ $label($k) }}</b>{{ $k }}</div>
            @foreach ($locales as $l => $name)
                @php
                    $orig = $defaults[$l][$k] ?? ($defaults['en'][$k] ?? '');
                    $cur = $changed[$l][$k]->value ?? null;
                    $field = 't['.$l.']['.str_replace('.', '__', $k).']';
                    $rows = max(1, min(8, (int) ceil(mb_strlen($cur ?? $orig) / 30)));
                @endphp
                <div>
                    <textarea name="{{ $field }}" rows="{{ $rows }}" data-orig="{{ $orig }}" data-lang="{{ $name }}" aria-label="{{ $label($k) }} — {{ $name }}" class="{{ $cur !== null ? 'is-changed' : '' }}">{{ $cur ?? $orig }}</textarea>
                    @if ($cur !== null)<button type="button" class="reset" data-reset>Back to original</button>@endif
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="save-bar">
        <button type="submit" class="btn">Save {{ $sections[$section] }}</button>
        <span class="muted" id="dirty-note" hidden>You have changes that are not saved yet.</span>
    </div>
</form>

<script>
(function () {
    var form = document.getElementById('texts-form'), note = document.getElementById('dirty-note'), dirty = false;
    form.addEventListener('input', function (e) {
        if (e.target.tagName !== 'TEXTAREA') return;
        e.target.classList.toggle('is-changed', e.target.value.trim() !== e.target.dataset.orig.trim());
        dirty = true; note.hidden = false;
    });
    form.addEventListener('click', function (e) {
        if (!e.target.matches('[data-reset]')) return;
        var t = e.target.previousElementSibling; t.value = t.dataset.orig; t.classList.remove('is-changed'); dirty = true; note.hidden = false;
    });
    form.addEventListener('submit', function () { dirty = false; });
    window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });
    document.getElementById('text-filter').addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        form.querySelectorAll('.text-row').forEach(function (r) { r.hidden = q && r.dataset.search.indexOf(q) === -1; });
    });
})();
</script>
@endsection
