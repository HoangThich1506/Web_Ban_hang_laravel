<footer class="border-t border-white/10 bg-stone-950/80">
    <div class="mx-auto grid max-w-7xl gap-6 px-4 py-10 sm:px-6 lg:grid-cols-3 lg:px-8">
        <div>
            <p class="text-lg font-semibold text-white">Mr.Hoang Store</p>
            <p class="mt-3 text-sm leading-7 text-stone-400">
                Cửa hàng công nghệ với giao diện hiện đại, mua sắm nhanh và luồng đặt hàng rõ ràng hơn.
            </p>
        </div>
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-stone-500">Điều hướng</p>
            <div class="mt-3 flex flex-wrap gap-3 text-sm text-stone-300">
                <a href="{{ route('site.home') }}" class="nav-link">Trang chủ</a>
                <a href="{{ route('site.products.index') }}" class="nav-link">Sản phẩm</a>
                <a href="{{ route('site.cart.index') }}" class="nav-link">Giỏ hàng</a>
                <a href="{{ route('site.contact.index') }}" class="nav-link">Liên hệ</a>
                @if ($currentUser)
                    <a href="{{ route('site.profile') }}" class="nav-link">Tài khoản</a>
                @endif
            </div>
        </div>
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-stone-500">Liên hệ</p>
            <div class="mt-3 space-y-2 text-sm text-stone-300">
                <p>TP. Hồ Chí Minh</p>
                <p>0123 456 789</p>
                <p>mrhoangstore@gmail.com</p>
            </div>
        </div>
    </div>
</footer>
