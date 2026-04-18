<!-- CATEGORY -->
<section class="py-16 bg-[#0f172a] text-white">
    <h2 class="text-3xl font-bold text-center mb-10">Danh mục nổi bật</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">

        <!-- Điện thoại -->
    <a href="{{ route('site.products.index') }}?category=phone">
        <div class="relative h-32 rounded-xl overflow-hidden group">
            <img src="https://images.pexels.com/photos/30353222/pexels-photo-30353222.jpeg"
                class="absolute w-full h-full object-cover blur-sm group-hover:blur-none transition">

            <div class="absolute inset-0 bg-black/50"></div>

            <p class="relative z-10 flex items-center justify-center h-full font-semibold text-lg">
                Điện thoại
            </p>
        </div>
    </a>
        <!-- Laptop -->
    <a href="{{ route('site.products.index') }}?category=laptop">
        <div class="relative h-32 rounded-xl overflow-hidden group">
            <img src="https://images.pexels.com/photos/303383/pexels-photo-303383.jpeg"
                class="absolute w-full h-full object-cover blur-sm group-hover:blur-none transition">

            <div class="absolute inset-0 bg-black/50"></div>

            <p class="relative z-10 flex items-center justify-center h-full font-semibold text-lg">
                Laptop
            </p>
        </div>
    </a>
        <!-- Tai nghe -->
    <a href="{{ route('site.products.index') }}?category=accessory">
        <div class="relative h-32 rounded-xl overflow-hidden group">
            <img src="https://images.pexels.com/photos/8024034/pexels-photo-8024034.jpeg"
                class="absolute w-full h-full object-cover blur-sm group-hover:blur-none transition">

            <div class="absolute inset-0 bg-black/50"></div>

            <p class="relative z-10 flex items-center justify-center h-full font-semibold text-lg">
                Tai nghe
            </p>
        </div>
    </a>
        <!-- Smart Watch -->
        <a href="{{ route('site.products.index') }}?category=smartwatch">
        <div class="relative h-32 rounded-xl overflow-hidden group">
            <img src="https://images.pexels.com/photos/18259150/pexels-photo-18259150.jpeg"
                class="absolute w-full h-full object-cover blur-sm group-hover:blur-none transition">

            <div class="absolute inset-0 bg-black/50"></div>

            <p class="relative z-10 flex items-center justify-center h-full font-semibold text-lg">
                Smart Watch
            </p>
        </div>
        </a>
    </div>
</section>
