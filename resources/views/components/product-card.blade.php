<article class="card-surface product-card overflow-hidden p-4">
    <a href="{{ route('site.product.detail', $product->slug) }}" class="block">
        @if ($product->image)
            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="h-56 w-full rounded-[1.75rem] object-cover">
        @else
            <div class="grid h-56 place-items-center rounded-[1.75rem] bg-stone-900 text-sm text-stone-500">
                No image
            </div>
        @endif
    </a>

    <div class="mt-5">
        <p class="text-xs uppercase tracking-[0.25em] text-stone-500">Sản phẩm</p>
        <a href="{{ route('site.product.detail', $product->slug) }}" class="mt-2 block text-xl font-bold text-white transition hover:text-amber-300">
            {{ $product->name }}
        </a>
        <div class="mt-3 flex items-center gap-3">
            <p class="text-2xl font-black text-amber-300">{{ number_format($product->price_sale ?: $product->price_buy, 0, ',', '.') }} đ</p>
            @if ($product->price_sale)
                <p class="text-sm text-stone-500 line-through">{{ number_format($product->price_buy, 0, ',', '.') }} đ</p>
            @endif
        </div>
    </div>

    <form action="{{ route('site.cart.store', $product->id) }}" method="POST" class="mt-5 flex items-center gap-3">
        @csrf
        <input type="hidden" name="qty" value="1">
        <button type="submit" class="primary-button flex-1 justify-center">Thêm giỏ hàng</button>
        <a href="{{ route('site.product.detail', $product->slug) }}" class="secondary-button">Chi tiết</a>
    </form>
</article>
