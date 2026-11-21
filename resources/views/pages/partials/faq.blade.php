{{-- Questions people search on Google — also given to Google as FAQ data (schema.org FAQPage). --}}
@php $faq = __('site.faq'); @endphp
<section class="section" id="faq">
    <div class="wrap faq-wrap">
        <div class="section-head" data-reveal>
            <span class="eyebrow">FAQ</span>
            <h2 style="margin-top:14px">{{ $faq['title'] }}</h2>
        </div>
        <div class="faq-list">
            @foreach ($faq['items'] as $i => $item)
                <details class="faq-item" data-reveal style="--d:{{ $i * .05 }}s" @if ($i === 0) open @endif>
                    <summary>{{ $item['q'] }}<span class="faq-plus" aria-hidden="true"></span></summary>
                    <p>{{ $item['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faq['items'])->map(fn ($i) => ['@type' => 'Question', 'name' => $i['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $i['a']]])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
@endpush
