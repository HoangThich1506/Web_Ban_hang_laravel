@extends('layouts.app')

@section('title', 'Thanh toán | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="section-heading">
            <div>
                <p class="section-kicker">Thanh toán</p>
                <h1 class="section-title">Hoàn tất thông tin đơn hàng</h1>
            </div>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <form action="{{ route('site.checkout.store') }}" method="POST" class="card-surface p-8">
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-input">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-input">
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Địa chỉ nhận hàng</label>
                        <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}" class="form-input">
                        @error('address') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="note" rows="5" class="form-input">{{ old('note') }}</textarea>
                        @error('note') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="primary-button mt-6">Xác nhận đặt hàng</button>
            </form>

            <div class="card-surface p-8">
                <p class="section-kicker">Tóm tắt đơn hàng</p>
                <div class="mt-6 space-y-4">
                    @foreach ($cart as $item)
                        <div class="flex items-center justify-between gap-3 border-b border-white/10 pb-4">
                            <div>
                                <p class="font-semibold text-white">{{ $item['name'] }}</p>
                                <p class="text-sm text-stone-400">Số lượng: {{ $item['qty'] }}</p>
                            </div>
                            <p class="font-semibold text-amber-300">
                                {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }} đ
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-stone-400">Tổng thanh toán</span>
                    <span class="text-3xl font-black text-amber-300">{{ number_format($subtotal, 0, ',', '.') }} đ</span>
                </div>
            </div>
        </div>
    </section>
@endsection
