<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- static pages --}}
    @foreach ($staticPages as $url)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ now()->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach

    {{-- porsts --}}
    @foreach ($posts as $post)
        <url>
            <loc>{{ url('/blog/article/' . $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- products --}}
    @foreach ($products as $product)
        <url>
            <loc>{{ url('/shop/product/' . $product->sku) }}</loc>
            <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

</urlset>
