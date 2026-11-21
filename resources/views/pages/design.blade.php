@extends('layouts.app')
@section('title', __('site.seo.design.title'))
@section('meta_description', __('site.seo.design.description'))
@section('body_class', 'page-solid page-design')

@php
    $d = __('site.design');
    $steps = $d['steps'];
    $boardColours = \App\Support\BoardColours::all();
    $layoutSets = $d['layouts'];
    $i18n = ['step' => $d['step'], 'of' => $d['of'], 'sending' => $d['sending'], 'submit' => $d['submit'], 'error' => $d['error'], 'too_big' => $d['file_too_big'], 'bad_type' => $d['file_type'], 'too_many' => $d['too_many'], 'required' => $d['required']];
    $topSwatch = ['sintered' => 'linear-gradient(135deg,#fff,#e9e9e9 40%,#bdbdbd 41%,#fff 43%,#f2f2f2)', 'marble' => 'linear-gradient(135deg,#f6f3ee,#d9d2c5 45%,#9e9689 47%,#efe9df)', 'granite' => 'radial-gradient(circle at 30% 30%,#7b7b7b,#2c2c2c 60%)', 'board' => 'linear-gradient(135deg,#d9c3a0,#b38c5a)', 'none' => 'repeating-linear-gradient(45deg,#eee 0 4px,#fff 4px 8px)'];
    $sumRows = ['room' => $steps[0], 'layout' => $steps[1], 'style' => $steps[2], 'board' => $d['board_label'], 'finish' => $steps[3], 'colour' => $d['q_colour'], 'top' => $d['q_top'], 'files' => $steps[4]];
@endphp

@section('content')
<section class="section" style="padding-top:calc(var(--head) + 40px)">
    <div class="wrap">
        <div class="section-head" style="margin-bottom:28px">
            <span class="eyebrow">{{ $d['eyebrow'] }}</span>
            <h1 class="h2" style="font-size:clamp(32px,5.5vw,56px)">{{ $d['title'] }}</h1>
            <p class="lead">{{ $d['lead'] }}</p>
        </div>

        <div class="designer">
            <form class="form-card" id="designer" data-steps="{{ json_encode($steps, JSON_UNESCAPED_UNICODE) }}" action="{{ route('design.submit') }}" method="POST" enctype="multipart/form-data" novalidate
                  data-i18n="{{ json_encode($i18n, JSON_UNESCAPED_UNICODE) }}">
                @csrf
                <div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

                <div class="stepper" aria-hidden="true">@foreach ($steps as $i => $s)<span @class(['is-current' => $i === 0])></span>@endforeach</div>
                <p class="step-label" id="step-label">{{ $d['step'] }} 1 {{ $d['of'] }} {{ count($steps) }} · {{ $steps[0] }}</p>

                {{-- 1. What --}}
                <fieldset class="pane is-active" data-step="0" style="border:0;padding:0;margin:0">
                    <legend class="q">{{ $d['q_room'] }}</legend>
                    <div class="options">
                        @foreach ($d['rooms'] as $key => $label)
                            <div class="opt opt--img opt--room">
                                <input type="radio" name="room" value="{{ $key }}" id="room-{{ $key }}" data-label="{{ $label }}">
                                <label for="room-{{ $key }}"><span class="opt-img">@if (is_file(public_path("images/design/rooms/$key.webp")))<img src="{{ asset("images/design/rooms/$key.webp") }}?v={{ filemtime(public_path("images/design/rooms/$key.webp")) }}" alt="" loading="lazy">@else @include('pages.partials.style-sketch', ['set' => $key, 'style' => 'twotone', 'prefix' => 'rm']) @endif</span><span class="opt-text"><strong>{{ $label }}</strong></span></label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>

                {{-- 2. Layout + size --}}
                <fieldset class="pane" data-step="1" style="border:0;padding:0;margin:0">
                    <legend class="q">{{ $d['q_layout'] }}</legend>
                    @foreach ($layoutSets as $set => $layouts)
                        <div class="options {{ count($layouts) === 4 ? 'options--4' : 'options--3' }}" data-layouts="{{ $set }}" @if ($set !== 'kitchen') hidden @endif>
                            @foreach ($layouts as $key => $label)
                                <div class="opt opt--img opt--plan">
                                    <input type="radio" name="layout" value="{{ $key }}" id="layout-{{ $set }}-{{ $key }}" data-label="{{ $label }}" @if ($set !== 'kitchen') disabled @endif>
                                    <label for="layout-{{ $set }}-{{ $key }}"><span class="opt-img">@include('pages.partials.layout-icon', ['set' => $set, 'key' => $key])</span><span class="opt-text"><strong>{{ $label }}</strong></span></label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="field" style="margin-top:22px;max-width:320px">
                        <label for="size">{{ $d['q_size'] }}</label>
                        <input type="number" id="size" name="size_m" min="0.5" max="200" step="0.1" inputmode="decimal" placeholder="3.5">
                        <span class="hint">{{ $d['size_hint'] }}</span>
                    </div>
                </fieldset>

                {{-- 3. Style --}}
                <fieldset class="pane" data-step="2" style="border:0;padding:0;margin:0">
                    <legend class="q">{{ $d['q_style'] }}</legend>
                    <div class="options options--3">
                        @foreach ($d['styles'] as $key => $s)
                            <div class="opt opt--img">
                                <input type="radio" name="style" value="{{ $key }}" id="style-{{ $key }}" data-label="{{ $s['name'] }}">
                                <label for="style-{{ $key }}">
                                    <span class="opt-img">
                                        @foreach (array_keys(\App\Support\DesignPictures::SETS) as $set)
                                            @php $pic = \App\Support\DesignPictures::url($set, $key); @endphp
                                            <span class="opt-art" data-style-set="{{ $set }}" @if ($set !== 'kitchen') hidden @endif>
                                                @if ($pic)
                                                    <img src="{{ $pic }}" alt="" loading="lazy">
                                                @else
                                                    @include('pages.partials.style-sketch', ['set' => $set, 'style' => $key])
                                                @endif
                                            </span>
                                        @endforeach
                                    </span>
                                    <span class="opt-text"><strong>{{ $s['name'] }}</strong><small>{{ $s['text'] }}</small></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>

                {{-- 4. Finish, colour, countertop --}}
                <fieldset class="pane" data-step="3" style="border:0;padding:0;margin:0">
                    <legend class="q">{{ $d['q_finish'] }}</legend>
                    <p class="subq" style="margin-top:0">{{ $d['q_board'] }}</p>
                    <div class="options options--boards">
                        @foreach ($d['board_options'] as $key => $b)
                            @php $soon = in_array($key, ['pvc', 'aluminium'], true); @endphp
                            <div class="opt @if ($soon) opt--soon @endif">
                                <input type="radio" name="board" value="{{ $key }}" id="board-{{ $key }}" data-label="{{ $b['name'] }}{{ $soon ? ' ('.$d['board_soon'].')' : '' }}">
                                <label for="board-{{ $key }}"><strong>{{ $b['name'] }}@if ($soon) <em class="soon">{{ $d['board_soon'] }}</em>@endif</strong><small>{{ $b['text'] }}</small></label>
                            </div>
                        @endforeach
                    </div>
                    <p class="subq">{{ $d['finish_label'] }}</p>
                    <div class="options options--3">
                        @foreach ($d['finishes'] as $key => $f)
                            <div class="opt opt--img">
                                <input type="radio" name="finish" value="{{ $key }}" id="finish-{{ $key }}" data-label="{{ $f['name'] }}">
                                <label for="finish-{{ $key }}"><span class="opt-img">@include('pages.partials.finish-swatch', ['key' => $key])</span><span class="opt-text"><strong>{{ $f['name'] }}</strong><small>{{ $f['text'] }}</small></span></label>
                            </div>
                        @endforeach
                    </div>
                    <div class="colour-pick" data-colour-pick>
                        <p class="subq">{{ $d['q_colour'] }} <a href="{{ route('colours') }}" target="_blank" class="link-arrow" style="font-size:14px;margin-left:8px">{{ __('site.colours.title') }} @include('partials.icon', ['name' => 'arrow'])</a></p>
                        <p class="hint" style="margin:-4px 0 12px">{{ $d['colour_hint'] }}</p>
                        <p class="hint colour-paint" data-paint-note hidden>{{ $d['colour_paint'] }}</p>
                        <div class="cp-tabs" data-cp-groups>
                            <button type="button" class="filter filter--sm" data-group="all" aria-pressed="false">{{ __('site.colours.finishes.all') }}</button>
                            @foreach (__('site.colours.tabs') as $g => $glabel)
                                <button type="button" class="filter filter--sm" data-group="{{ $g }}" aria-pressed="{{ $g === 'board' ? 'true' : 'false' }}">{{ $glabel }}</button>
                            @endforeach
                        </div>
                        <div class="cp-tabs cp-tabs--finish" data-cp-finishes>
                            @foreach (__('site.colours.finishes') as $f => $flabel)
                                <button type="button" class="filter filter--sm" data-cfinish="{{ $f }}" aria-pressed="{{ $f === 'all' ? 'true' : 'false' }}">{{ $flabel }}</button>
                            @endforeach
                        </div>
                        <div class="cp-grid">
                            <div class="cp" data-group="any" data-cfinish="any">
                                <input type="radio" name="colour" value="advise" id="colour-advise" data-label="{{ $d['colour_advise'] }}">
                                <label for="colour-advise"><i class="cp-chip cp-chip--advise" aria-hidden="true">?</i><b>{{ $d['colour_advise'] }}</b></label>
                            </div>
                            @foreach ($boardColours as $code => $col)
                                @php $cname = $col['name'].($col['finish'] === 'gloss' && ! str_contains($col['name'], 'Gloss') ? ' Gloss' : ''); @endphp
                                <div class="cp" data-group="{{ $col['group'] }}" data-cfinish="{{ $col['finish'] }}">
                                    <input type="radio" name="colour" value="{{ $code }}" id="colour-{{ $loop->index }}" data-label="{{ $cname }}{{ $col['group'] === 'hpl' ? ' · HPL' : '' }}">
                                    <label for="colour-{{ $loop->index }}" title="{{ $cname }} · {{ $code }}"><i class="cp-chip @if ($col['finish'] === 'gloss') is-gloss @endif" style="background:{{ $col['hex'] }}">@if (! empty($col['image']))<img src="{{ asset($col['image']) }}" alt="" loading="lazy">@endif</i><b>{{ $cname }}</b><small>{{ $code }}</small></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div data-top-block>
                        <p class="subq">{{ $d['q_top'] }}</p>
                        <div class="swatches">
                            @foreach ($d['tops'] as $key => $label)
                                <div class="swatch">
                                    <input type="radio" name="top" value="{{ $key }}" id="top-{{ $key }}" data-label="{{ $label }}">
                                    <label for="top-{{ $key }}"><i style="background:{{ $topSwatch[$key] }}"></i>{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </fieldset>

                {{-- 5. Upload --}}
                <fieldset class="pane" data-step="4" id="upload" style="border:0;padding:0;margin:0">
                    <legend class="q">{{ $d['q_upload'] }}</legend>
                    <label class="dropzone" id="dropzone">
                        <input type="file" name="files[]" id="files" multiple accept=".jpg,.jpeg,.png,.webp,.pdf,image/jpeg,image/png,image/webp,application/pdf">
                        <span class="dz-icon">@include('partials.icon', ['name' => 'upload'])</span>
                        <strong>{{ $d['upload_btn'] }}</strong>
                        <span class="hint">{{ $d['upload_drop'] }}</span>
                        <span class="hint" style="max-width:52ch">{{ $d['upload_hint'] }}</span>
                    </label>
                    <div class="file-list" id="file-list"></div>
                    <p class="hint" style="margin-top:12px">{{ $d['upload_none'] }}</p>
                    <div class="field" style="margin-top:22px">
                        <label for="note">{{ $d['q_note'] }}</label>
                        <textarea id="note" name="note" maxlength="2000" placeholder="{{ $d['note_ph'] }}"></textarea>
                    </div>
                </fieldset>

                {{-- 6. Contact + what happens next --}}
                <fieldset class="pane" data-step="5" style="border:0;padding:0;margin:0">
                    <legend class="q">{{ $d['q_contact'] }}</legend>
                    <div class="field-row">
                        <div class="field"><label for="name">{{ $d['name'] }} *</label><input id="name" name="name" autocomplete="name" maxlength="150" required></div>
                        <div class="field"><label for="mobile">{{ $d['mobile'] }} *</label><input id="mobile" name="mobile" type="tel" inputmode="tel" autocomplete="tel" placeholder="09XX XXX XXXX" maxlength="40" required></div>
                    </div>
                    <div class="field-row">
                        <div class="field"><label for="email">{{ $d['email'] }}</label><input id="email" name="email" type="email" autocomplete="email" maxlength="150"></div>
                        <div class="field"><label for="city">{{ $d['city'] }}</label><input id="city" name="city" autocomplete="address-level2" maxlength="120" placeholder="Sta. Rosa, Laguna"></div>
                    </div>
                    <p class="subq" style="margin-top:6px">{{ $d['next_q'] }}</p>
                    <div class="options options--list" style="margin-bottom:8px">
                        @foreach ($d['next_options'] as $key => $n)
                            <div class="opt">
                                <input type="radio" name="next" value="{{ $key }}" id="next-{{ $key }}" data-label="{{ $n['name'] }}" @checked($key === 'call')>
                                <label for="next-{{ $key }}">@php $nextIcon = ['call' => 'phone', 'measure' => 'ruler', 'showroom' => 'home'][$key]; @endphp<span class="oi">@include('partials.icon', ['name' => $nextIcon])</span><strong>{{ $n['name'] }}</strong><small>{{ $n['text'] }}</small></label>
                            </div>
                        @endforeach
                    </div>
                    <div class="field-row" data-visit-fields hidden>
                        <div class="field"><label for="visit_date">{{ $d['visit_date'] }}</label><input id="visit_date" name="visit_date" type="date" min="{{ now('Asia/Manila')->addDay()->toDateString() }}"></div>
                        <div class="field"><label for="visit_time">{{ $d['visit_time'] }}</label>
                            <select id="visit_time" name="visit_time">@foreach ($d['visit_times'] as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field"><label for="prefer">{{ $d['prefer'] }}</label>
                            <select id="prefer" name="prefer">@foreach ($d['prefer_options'] as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select>
                        </div>
                        <div class="field"><label for="when">{{ $d['when'] }}</label>
                            <select id="when" name="when">@foreach ($d['when_options'] as $k => $t)<option value="{{ $k }}">{{ $t }}</option>@endforeach</select>
                        </div>
                    </div>
                    {{-- On phones the side summary is hidden: show the choices here before sending. --}}
                    <div class="review" id="review" hidden><p class="subq">{{ $d['summary'] }}</p><dl></dl></div>
                    <p class="hint">{{ $d['consent'] }}</p>
                    <div class="alert alert--err" id="form-error" role="alert" hidden></div>
                </fieldset>

                <div class="pane-nav">
                    <button type="button" class="btn btn--line" data-back hidden>{{ $d['back'] }}</button>
                    <button type="button" class="skip" data-skip>{{ $d['skip'] }}</button>
                    <span class="spacer"></span>
                    <button type="button" class="btn btn--primary" data-next>{{ $d['next'] }} <span class="arrow">@include('partials.icon', ['name' => 'arrow'])</span></button>
                    <button type="submit" class="btn btn--gold btn--lg" data-submit hidden>@include('partials.icon', ['name' => 'phone']) {{ $d['submit'] }}</button>
                </div>

                <div class="done" id="done" hidden>
                    <span class="big-check">@include('partials.icon', ['name' => 'check'])</span>
                    <h2>{{ $d['success_title'] }}</h2>
                    <p>{{ $d['success_text'] }}</p>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center">
                        <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" class="btn btn--primary">@include('partials.icon', ['name' => 'messenger']) Messenger</a>
                        <a href="{{ route('portfolio') }}" class="btn btn--line">{{ __('site.portfolio.more') }}</a>
                    </div>
                </div>
            </form>

            {{-- Summary of the choices (desktop only; on phones they are shown on the last step) --}}
            <aside class="summary" aria-live="polite">
                <h3>{{ $d['summary'] }}</h3>
                <div class="sum-thumb" id="sum-thumb" hidden></div>
                <p class="sum-empty" id="sum-empty">{{ $d['summary_empty'] }}</p>
                <dl id="summary-list">
                    @foreach ($sumRows as $k => $label)
                        <div data-sum="{{ $k }}" hidden><dt>{{ $label }}</dt><dd></dd></div>
                    @endforeach
                </dl>
                <div class="contact-mini">
                    <span>{{ __('site.quote.or_title') }}</span>
                    <a href="tel:+63{{ ltrim(preg_replace('/\D+/', '', config('company.phone_primary')), '0') }}">@include('partials.icon', ['name' => 'phone']) {{ config('company.phone_primary') }}</a>
                    <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener">@include('partials.icon', ['name' => 'messenger']) Messenger</a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/design.js') }}?v={{ filemtime(public_path('js/design.js')) }}" defer></script>
@endpush
