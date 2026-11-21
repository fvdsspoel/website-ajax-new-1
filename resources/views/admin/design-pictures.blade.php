@extends('admin.layout')
@section('title', 'Design pictures')
@section('content')
<div class="admin-header">
    <div>
        <h1>Design pictures</h1>
        <p class="lead">The pictures in step 3 "Which style do you like?" of <a href="{{ route('design') }}" target="_blank" rel="noopener">Design your space</a>. Each room type has its own six styles. Every tile shows a clean drawing by default. Only upload a photo if it shows exactly this furniture in exactly this style — it is cropped to the tile shape and goes live straight away; Remove brings the drawing back.</p>
    </div>
</div>
<div class="sec-tabs">
    @foreach ($sets as $set => $label)<a href="#{{ $set }}">{{ $label }}</a>@endforeach
</div>

@foreach ($sets as $set => $label)
    <section class="card" id="{{ $set }}">
        <h2 style="margin:0 0 14px;font-size:19px">{{ $label }}</h2>
        <div class="dp-grid">
            @foreach ($styles as $style => $name)
                @php $src = \App\Support\DesignPictures::source($set, $style); $url = \App\Support\DesignPictures::url($set, $style); @endphp
                <div class="dp-tile">
                    <div class="dp-img">
                        @if ($url)<img src="{{ $url }}" alt="">@else @include('pages.partials.style-sketch', ['set' => $set, 'style' => $style]) @endif
                    </div>
                    <div class="dp-body">
                        <b>{{ $name }}</b>
                        <span class="tag {{ $src === 'upload' ? 'tag--changed' : '' }}">{{ ['upload' => 'Uploaded photo', 'sketch' => 'Drawing'][$src] }}</span>
                        <form method="POST" action="{{ route('admin.design.store') }}" enctype="multipart/form-data" class="dp-form">
                            @csrf
                            <input type="hidden" name="set" value="{{ $set }}"><input type="hidden" name="style" value="{{ $style }}">
                            <label class="btn btn--sm btn--ghost">{{ $src === 'upload' ? 'Replace' : 'Upload photo' }}
                                <input type="file" name="image" accept="image/*" hidden onchange="this.form.submit()">
                            </label>
                        </form>
                        @if ($src === 'upload')
                            <form method="POST" action="{{ route('admin.design.destroy') }}" onsubmit="return confirm('Remove this uploaded picture?')">
                                @csrf @method('DELETE')
                                <input type="hidden" name="set" value="{{ $set }}"><input type="hidden" name="style" value="{{ $style }}">
                                <button type="submit" class="btn btn--danger">Remove</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endforeach
@endsection
