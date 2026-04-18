@extends('layouts.app')

@section('title', 'Liên hệ | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="card-surface p-8">
                <p class="section-kicker">Liên hệ</p>
                <h1 class="mt-4 text-4xl font-black text-white">Kết nối với cửa hàng</h1>
                <p class="mt-6 text-base leading-8 text-stone-300">
                    Nếu bạn cần tư vấn sản phẩm, hỏi về đơn hàng hoặc muốn góp ý cho website, hãy để lại thông tin ở form bên cạnh.
                </p>

                <div class="mt-8 space-y-5 text-sm text-stone-300">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Địa chỉ</p>
                        <p class="mt-1">TP. Hồ Chí Minh</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Điện thoại</p>
                        <p class="mt-1">0123 456 789</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Email</p>
                        <p class="mt-1">mrhoangstore@gmail.com</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('site.contact.store') }}" method="POST" class="card-surface p-8">
                @csrf
                <h2 class="text-2xl font-bold text-white">Gửi liên hệ</h2>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="name" value="{{ old('name', $currentUser->name ?? '') }}" class="form-input">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', $currentUser->phone ?? '') }}" class="form-input">
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $currentUser->email ?? '') }}" class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-input">
                        @error('title') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Nội dung</label>
                        <textarea name="content" rows="6" class="form-input">{{ old('content') }}</textarea>
                        @error('content') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="primary-button mt-6">Gửi liên hệ</button>
            </form>
        </div>
    </section>
@endsection
