<div class="relative h-32 rounded-xl overflow-hidden group">
    <img src="{{ $img }}"
        class="absolute w-full h-full object-cover blur-sm group-hover:blur-none transition">

    <div class="absolute inset-0 bg-black/50"></div>

    <p class="relative z-10 flex items-center justify-center h-full font-semibold text-lg">
        {{ $title }}
    </p>
</div>