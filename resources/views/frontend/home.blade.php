@extends('layouts.app')

@section('title', 'Trang chu | Mr.Hoang Store')

@section('content')
    <section class="hero-section">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8 lg:py-24">
            <div>
                <h1 class="mt-6 max-w-3xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                    Website bán hàng công nghệ với giao diện hiện đại
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-8 text-stone-300 sm:text-lg">
                    mua sắm nhanh và luồng đặt hàng rõ ràng hơn.
                    Người dùng có thể tìm kiếm sản phẩm, xem chi tiết, thêm vào giỏ hàng và thanh toán một cách dễ dàng và an toàn.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('site.products.index') }}" class="primary-button">Khám phá sản phẩm</a>
                    <a href="{{ route('site.cart.index') }}" class="secondary-button">Xem giỏ hàng</a>
                </div>
            </div>

            <div class="feature-panel">
                <p class="text-sm uppercase tracking-[0.3em] text-amber-300">Diem nhan moi</p>
                <div class="mt-6 space-y-4">
                    <div class="feature-item">
                        <p class="font-semibold text-white">Sản phẩm</p>
                        <p class="text-sm text-stone-400">Chính hãng, chất lượng cao</p>
                    </div>
                    <div class="feature-item">
                        <p class="font-semibold text-white">Giá cả</p>
                        <p class="text-sm text-stone-400">Giá cả cạnh tranh, phù hợp với túi tiền của người tiêu dùng.</p>
                    </div>
                    <div class="feature-item">
                        <p class="font-semibold text-white">Giao hàng</p>
                        <p class="text-sm text-stone-400">Giao hàng nhanh chóng, đảm bảo thời gian giao hàng.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($banners->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/70 shadow-2xl shadow-black/20" data-banner-slider>
                <div class="flex transition-transform duration-700 ease-out" data-banner-track>
                    @foreach ($banners as $banner)
                        <article class="relative min-w-full">
                            <div class="absolute inset-0">
                                @if ($banner->image)
                                    <img
                                        src="{{ asset('images/banners/' . $banner->image) }}"
                                        alt="{{ $banner->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="h-full w-full bg-gradient-to-br from-amber-300 via-orange-300 to-rose-300"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-r from-stone-950/85 via-stone-950/50 to-stone-950/10"></div>
                            </div>

                            <div class="relative z-10 flex min-h-[360px] items-end p-8 sm:p-10 lg:min-h-[420px] lg:p-14">
                                <div class="max-w-2xl">
                                    <p class="badge-chip">Tin tức nổi bật</p>
                                    <h2 class="mt-5 text-3xl font-black text-white sm:text-4xl lg:text-5xl">
                                        {{ $banner->name }}
                                    </h2>
                                    <p class="mt-4 max-w-xl text-sm leading-7 text-stone-200 sm:text-base">
                                        {{ $banner->description ?: 'Noi dung quang ba noi bat danh cho nguoi dung dang mua sam tai cua hang.' }}
                                    </p>
                                    @if ($banner->link)
                                        <a href="{{ url($banner->link) }}" class="primary-button mt-6">
                                            Xem thêm
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($banners->count() > 1)
                    <button type="button" class="absolute left-4 top-1/2 z-20 -translate-y-1/2 rounded-full border border-white/15 bg-stone-950/70 px-4 py-3 text-sm font-bold text-white transition hover:border-amber-300 hover:text-amber-300" data-banner-prev>
                        Truoc
                    </button>
                    <button type="button" class="absolute right-4 top-1/2 z-20 -translate-y-1/2 rounded-full border border-white/15 bg-stone-950/70 px-4 py-3 text-sm font-bold text-white transition hover:border-amber-300 hover:text-amber-300" data-banner-next>
                        Sau
                    </button>

                    <div class="absolute bottom-5 left-1/2 z-20 flex -translate-x-1/2 gap-2" data-banner-dots>
                        @foreach ($banners as $banner)
                            <button type="button" class="h-2.5 w-8 rounded-full bg-white/30 transition" data-banner-dot aria-label="Chuyen banner {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        @if ($banners->count() > 1)
            <script>
                (() => {
                    const slider = document.querySelector('[data-banner-slider]');
                    if (!slider) return;

                    const track = slider.querySelector('[data-banner-track]');
                    const slides = Array.from(track.children);
                    const prevButton = slider.querySelector('[data-banner-prev]');
                    const nextButton = slider.querySelector('[data-banner-next]');
                    const dots = Array.from(slider.querySelectorAll('[data-banner-dot]'));

                    if (slides.length <= 1) return;

                    let currentIndex = 0;
                    let autoPlay = null;

                    const render = () => {
                        track.style.transform = `translateX(-${currentIndex * 100}%)`;
                        dots.forEach((dot, index) => {
                            dot.classList.toggle('bg-amber-300', index === currentIndex);
                            dot.classList.toggle('bg-white/30', index !== currentIndex);
                        });
                    };

                    const goTo = (index) => {
                        currentIndex = (index + slides.length) % slides.length;
                        render();
                    };

                    const startAutoPlay = () => {
                        clearInterval(autoPlay);
                        autoPlay = setInterval(() => {
                            goTo(currentIndex + 1);
                        }, 4500);
                    };

                    prevButton?.addEventListener('click', () => {
                        goTo(currentIndex - 1);
                        startAutoPlay();
                    });

                    nextButton?.addEventListener('click', () => {
                        goTo(currentIndex + 1);
                        startAutoPlay();
                    });

                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', () => {
                            goTo(index);
                            startAutoPlay();
                        });
                    });

                    slider.addEventListener('mouseenter', () => clearInterval(autoPlay));
                    slider.addEventListener('mouseleave', startAutoPlay);

                    render();
                    startAutoPlay();
                })();
            </script>
        @endif
    @endif

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="section-heading">
            <div>
                <p class="section-kicker">Sản phẩm nổi bật</p>
                <h2 class="section-title">Những món đang được quan tâm nhiều nhất</h2>
            </div>
            <a href="{{ route('site.products.index') }}" class="secondary-button">Xem tất cả</a>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @forelse ($products as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <p class="text-stone-400">Chưa có sản phẩm để hiển thị.</p>
            @endforelse
        </div>
    </section>
@endsection
