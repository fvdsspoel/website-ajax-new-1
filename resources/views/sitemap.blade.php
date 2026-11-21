{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($names as $name => $priority)
@php $u = route($name); @endphp
@foreach (['' => 'en-PH', '?lang=tl' => 'tl-PH', '?lang=ceb' => 'ceb'] as $q => $code)
    <url>
        <loc>{{ $u.$q }}</loc>
        <lastmod>{{ $lastmod }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>{{ $q === '' ? $priority : number_format($priority - 0.1, 1) }}</priority>
        <xhtml:link rel="alternate" hreflang="en-PH" href="{{ $u }}"/>
        <xhtml:link rel="alternate" hreflang="tl-PH" href="{{ $u }}?lang=tl"/>
        <xhtml:link rel="alternate" hreflang="ceb" href="{{ $u }}?lang=ceb"/>
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $u }}"/>
    </url>
@endforeach
@endforeach
</urlset>
