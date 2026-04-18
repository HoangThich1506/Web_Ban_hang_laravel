@extends('layouts.app')

@section('title', $product->name . ' | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="card-surface p-6">
                @if ($product->image)
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="h-[420px] w-full rounded-[2rem] object-cover">
                @else
                    <div class="grid h-[420px] place-items-center rounded-[2rem] bg-stone-900 text-stone-500">
                        Chưa có hình ảnh
                    </div>
                @endif
            </div>

            <div class="card-surface p-8">
                <p class="section-kicker">Chi tiết sản phẩm</p>
                <h1 class="mt-4 text-3xl font-black text-white sm:text-4xl">{{ $product->name }}</h1>

                <div class="mt-6 flex flex-wrap items-end gap-3">
                    <p class="text-3xl font-black text-amber-300">{{ number_format($product->price_sale ?: $product->price_buy, 0, ',', '.') }} đ</p>
                    @if ($product->price_sale)
                        <p class="text-lg text-stone-500 line-through">{{ number_format($product->price_buy, 0, ',', '.') }} đ</p>
                    @endif
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Tồn kho</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $product->qty }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Trạng thái</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $product->status == 1 ? 'Đang bán' : 'Tạm ẩn' }}</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Mã slug</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $product->slug }}</p>
                    </div>
                </div>

                <p class="mt-8 text-base leading-8 text-stone-300">
                    {{ $product->detail ?: $product->description ?: 'Sản phẩm chưa có mô tả chi tiết.' }}
                </p>

                <form action="{{ route('site.cart.store', $product->id) }}" method="POST" class="mt-8 flex flex-wrap items-center gap-4">
                    @csrf
                    <input type="number" name="qty" value="1" min="1" max="{{ max(1, $product->qty) }}" class="w-24 rounded-full border border-white/10 bg-stone-900 px-4 py-3 text-center text-white outline-none">
                    <button type="submit" class="primary-button">Thêm vào giỏ hàng</button>
                    <a href="{{ route('site.cart.index') }}" class="secondary-button">Xem giỏ hàng</a>
                </form>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-14">
                <div class="section-heading">
                    <div>
                        <p class="section-kicker">Gợi ý thêm</p>
                        <h2 class="section-title">Sản phẩm liên quan</h2>
                    </div>
                </div>
                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                        @include('components.product-card', ['product' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
