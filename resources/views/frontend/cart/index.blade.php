@extends('layouts.app')

@section('title', 'Giỏ hàng | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="section-heading">
            <div>
                <p class="section-kicker">Giỏ hàng</p>
                <h1 class="section-title">Kiểm tra lại sản phẩm trước khi thanh toán</h1>
            </div>
        </div>

        @if ($cart)
            <div class="mt-8 grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-5">
                    @foreach ($cart as $item)
                        <div class="card-surface p-5">
                            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center gap-4">
                                    @if ($item['image'])
                                        <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-24 w-24 rounded-3xl object-cover">
                                    @else
                                        <div class="grid h-24 w-24 place-items-center rounded-3xl bg-stone-900 text-xs text-stone-500">No image</div>
                                    @endif
                                    <div>
                                        <a href="{{ route('site.product.detail', $item['slug']) }}" class="text-xl font-bold text-white hover:text-amber-300">
                                            {{ $item['name'] }}
                                        </a>
                                        <p class="mt-2 text-sm text-stone-400">
                                            Đơn giá: {{ number_format($item['price'], 0, ',', '.') }} đ
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    <form action="{{ route('site.cart.update', $item['id']) }}" method="POST" class="flex items-center gap-3">
                                        @csrf
                                        <input type="number" name="qty" min="1" max="{{ max(1, $item['stock']) }}" value="{{ $item['qty'] }}" class="w-24 rounded-full border border-white/10 bg-stone-900 px-4 py-3 text-center text-white outline-none">
                                        <button type="submit" class="secondary-button">Cập nhật</button>
                                    </form>

                                    <form action="{{ route('site.cart.destroy', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-rose-400/30 px-4 py-3 text-sm font-semibold text-rose-200 transition hover:bg-rose-400/10">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card-surface h-fit p-8">
                    <p class="section-kicker">Tạm tính</p>
                    <div class="mt-5 flex items-center justify-between border-b border-white/10 pb-4">
                        <span class="text-stone-400">Tổng tiền</span>
                        <span class="text-3xl font-black text-amber-300">{{ number_format($subtotal, 0, ',', '.') }} đ</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-stone-400">
                        Bạn có thể cập nhật số lượng trước khi chuyển sang thanh toán.
                    </p>
                    <div class="mt-6 flex flex-col gap-3">
                        <a href="{{ route('site.checkout.index') }}" class="primary-button justify-center">Tiến hành thanh toán</a>
                        <a href="{{ route('site.products.index') }}" class="secondary-button justify-center">Mua thêm sản phẩm</a>
                    </div>
                </div>
            </div>
        @else
            <div class="card-surface mt-8 p-10 text-center">
                <p class="text-2xl font-bold text-white">Giỏ hàng đang trống</p>
                <p class="mt-3 text-stone-400">Hãy chọn vài sản phẩm trước khi đặt hàng.</p>
                <a href="{{ route('site.products.index') }}" class="primary-button mt-6 inline-flex">Đi mua sắm</a>
            </div>
        @endif
    </section>
@endsection
