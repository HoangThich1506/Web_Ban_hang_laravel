@extends('layouts.app')

@section('title', 'San pham | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="section-heading">
            <div>
                <p class="section-kicker">Danh muc mua sam</p>
                <h1 class="section-title">Toan bo san pham cong nghe</h1>
            </div>
            <a href="{{ route('site.cart.index') }}" class="secondary-button">Di toi gio hang</a>
        </div>

        <form action="{{ route('site.products.index') }}" method="GET" class="card-surface mt-8 p-6">
            <div class="grid gap-5 lg:grid-cols-[1.2fr_0.8fr_0.6fr_0.6fr_auto]">
                <div>
                    <label class="form-label">Tìm theo tên</label>
                    <input
                        type="text"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        class="form-input"
                        placeholder="Nhập tên sản phẩm..."
                    >
                </div>

                <div>
                    <label class="form-label">Danh mục</label>
                    <select name="category" class="form-input">
                        <option value="">ất cả danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug || request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Giá từ</label>
                    <input
                        type="number"
                        name="price_min"
                        value="{{ request('price_min') }}"
                        class="form-input"
                        placeholder="0"
                        min="0"
                    >
                </div>

                <div>
                    <label class="form-label">Đến giá</label>
                    <input
                        type="number"
                        name="price_max"
                        value="{{ request('price_max') }}"
                        class="form-input"
                        placeholder="50000000"
                        min="0"
                    >
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="primary-button">Lọc</button>
                    <a href="{{ route('site.products.index') }}" class="secondary-button">Xóa lọc</a>
                </div>
            </div>
        </form>

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @forelse ($products as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <div class="card-surface p-6 text-stone-400">
                    Chưa có dữ liệu sản phẩm.
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    </section>
@endsection
