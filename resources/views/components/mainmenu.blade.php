@php
    $menuItems = collect($menus ?? [])->where('status', 1)->values();
    $rootMenus = $menuItems
        ->filter(fn ($menu) => (int) ($menu->parent_id ?? 0) === 0)
        ->values();
@endphp

<nav class="hidden items-center gap-6 text-sm font-medium text-stone-300 lg:flex">
    @foreach ($rootMenus as $menu)
        @php
            $children = $menuItems
                ->filter(fn ($child) => (int) ($child->parent_id ?? 0) === (int) $menu->id)
                ->values();
        @endphp

        @if ($children->isNotEmpty())
            <div class="group relative py-3">
                <a href="{{ url($menu->link) }}" class="nav-link inline-flex items-center gap-2">
                    {{ $menu->name }}
                    <span class="text-xs text-stone-500 transition group-hover:text-amber-300">+</span>
                </a>
                <div class="invisible absolute left-0 top-full z-50 min-w-56 pt-3 opacity-0 transition duration-200 group-hover:visible group-hover:opacity-100">
                    <div class="space-y-1 rounded-3xl border border-white/10 bg-stone-900/95 p-3 shadow-2xl shadow-black/30">
                        @foreach ($children as $child)
                            <a href="{{ url($child->link) }}" class="block rounded-2xl px-4 py-3 text-sm text-stone-300 transition hover:bg-white/5 hover:text-amber-300">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <a href="{{ url($menu->link) }}" class="nav-link">{{ $menu->name }}</a>
        @endif
    @endforeach
</nav>
