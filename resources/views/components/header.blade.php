<header class="relative z-50 border-b border-white/10 bg-stone-950/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('site.home') }}" class="flex items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-300 text-lg font-black text-stone-950">MH</span>
            <div>
                <p class="text-lg font-semibold tracking-wide">Mr.Hoang Store</p>
                <p class="text-xs uppercase tracking-[0.3em] text-stone-400">Tech lifestyle</p>
            </div>
        </a>

        <x-mainmenu />

        <div class="flex items-center gap-3">
            <a href="{{ route('site.cart.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-stone-100 transition hover:border-amber-300 hover:text-amber-300">
                Giỏ hàng
                @if ($cartCount > 0)
                    <span class="ml-1 rounded-full bg-amber-300 px-2 py-0.5 text-xs font-bold text-stone-950">{{ $cartCount }}</span>
                @endif
            </a>

            @if ($currentUser)
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold">{{ $currentUser->name }}</p>
                    <p class="text-xs text-stone-400">{{ $currentUser->email }}</p>
                </div>
                <a href="{{ route('site.profile') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold transition hover:border-amber-300 hover:text-amber-300">
                    Tài khoản
                </a>
                <form action="{{ route('site.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-full bg-stone-100 px-4 py-2 text-sm font-semibold text-stone-950 transition hover:bg-amber-300">
                        Đăng xuất
                    </button>
                </form>
            @else
                <a href="{{ route('site.login') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold transition hover:border-amber-300 hover:text-amber-300">
                    Đăng nhập
                </a>
                <a href="{{ route('site.register') }}" class="hidden rounded-full bg-amber-300 px-4 py-2 text-sm font-semibold text-stone-950 transition hover:bg-amber-200 sm:inline-flex">
                    Đăng ký
                </a>
            @endif
        </div>
    </div>
</header>
