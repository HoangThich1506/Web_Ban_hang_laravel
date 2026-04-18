<!-- HERO -->
<section class="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10 items-center">

  <div>
    <h2 class="text-5xl font-bold mb-6 leading-tight 
           bg-gradient-to-r from-blue-600 to-purple-600 
           bg-clip-text text-transparent">
      Công nghệ mới <br>
      cho tương lai
    </h2>

    <p class="text-gray-600 mb-6">
      Khám phá những thiết bị công nghệ mới nhất với giá tốt nhất.
    </p>

    <button class="bg-blue-600 text-white px-6 py-3 rounded-xl 
               hover:bg-blue-700 hover:shadow-lg 
               transition duration-300">
      Mua ngay
    </button>
  </div>

  <div class="relative w-full h-[400px] overflow-hidden rounded-xl shadow-lg">

    <!-- Slides -->
    <div id="slider" class="flex transition-transform duration-700 h-full">

        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8"
             class="w-full h-full object-cover flex-shrink-0">

        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853"
             class="w-full h-full object-cover flex-shrink-0">

        <img src="https://images.unsplash.com/photo-1587202372775-e229f172b9d7"
             class="w-full h-full object-cover flex-shrink-0">

    </div>

    <!-- Nút trái -->
    <button onclick="prevSlide()" 
        class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 px-3 py-1 rounded">
        ❮
    </button>

    <!-- Nút phải -->
    <button onclick="nextSlide()" 
        class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 px-3 py-1 rounded">
        ❯
    </button>

</div>
</section>