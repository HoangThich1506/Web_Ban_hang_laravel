@extends('layouts.app')

@section('title', 'Tai khoan cua toi | Mr.Hoang Store')

@php
    $statusLabels = [
        1 => 'Da duyet',
        0 => 'Cho xu ly',
        2 => 'Moi tao',
    ];
@endphp

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="section-heading">
            <div>
                <p class="section-kicker">Tài khoản    </p>
                <h1 class="section-title">Trang cá nhân người dùng</h1>
            </div>
            <p class="max-w-2xl text-sm leading-7 text-stone-400">
                Quản lý thông tin liên hệ, địa chỉ và xem nhanh các đơn hàng đã tạo trên hệ thống.
            </p>
        </div>

        <div class="mt-8 grid gap-8 xl:grid-cols-[0.95fr_1.05fr]">
            <div class="space-y-8">
                <div class="card-surface p-8">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="grid h-20 w-20 place-items-center rounded-3xl bg-amber-300 text-2xl font-black text-stone-950">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm uppercase tracking-[0.3em] text-stone-500">Khach hang</p>
                                <h2 class="mt-2 text-2xl font-black text-white">{{ $user->name }}</h2>
                                <p class="mt-1 text-sm text-stone-400">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 px-5 py-4 text-sm text-stone-300">
                            <p>Thanh vien tu</p>
                            <p class="mt-1 text-lg font-bold text-white">{{ optional($user->created_at)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-stone-400">So dien thoai</p>
                            <p class="mt-2 font-semibold text-white">{{ $user->phone ?: 'Chua cap nhat' }}</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-stone-400">Ten dang nhap</p>
                            <p class="mt-2 font-semibold text-white">{{ $user->username ?: 'Chua cap nhat' }}</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 sm:col-span-2">
                            <p class="text-sm text-stone-400">Dia chi</p>
                            <p class="mt-2 font-semibold text-white">{{ $user->address ?: 'Chua cap nhat dia chi giao hang.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-surface p-8">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="section-kicker">Thống kê</p>
                            <h2 class="mt-3 text-2xl font-bold text-white">Tổng quan đơn hàng</h2>
                        </div>
                        <div class="rounded-3xl bg-amber-300 px-4 py-3 text-right text-stone-950">
                            <p class="text-xs font-bold uppercase tracking-[0.25em]">Tổng đơn</p>
                            <p class="mt-1 text-2xl font-black">{{ $orders->count() }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-stone-400">Đã duyệt</p>
                            <p class="mt-2 text-3xl font-black text-white">{{ $orders->where('status', 1)->count() }}</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-stone-400">Chờ xử lý</p>
                            <p class="mt-2 text-3xl font-black text-white">{{ $orders->where('status', '!=', 1)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <form action="{{ route('site.profile.update') }}" method="POST" class="card-surface p-8">
                    @csrf
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="section-kicker">Cập nhật</p>
                            <h2 class="mt-3 text-2xl font-bold text-white">Thông tin tài khoản</h2>
                        </div>
                        <p class="text-sm text-stone-400">Để trống mật khẩu nếu không muốn đổi.</p>
                    </div>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="form-label">Họ Tên</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input">
                            @error('name') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-input">
                            @error('username') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input">
                            @error('email') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input">
                            @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-input">
                            @error('address') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-input">
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="password_confirmation" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="primary-button mt-6">Lưu thay đổi</button>
                </form>

                <div class="card-surface p-8">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="section-kicker">Lịch sử mua hàng</p>
                            <h2 class="mt-3 text-2xl font-bold text-white">Đơn hàng của bạn</h2>
                        </div>
                        <p class="text-sm text-stone-400">{{ $orders->count() }} đơn</p>
                    </div>

                    @if ($orders->isEmpty())
                        <div class="mt-6 rounded-3xl border border-dashed border-white/15 bg-white/5 px-6 py-10 text-center text-stone-400">
                            bạn chưa có đơn hàng nào. Hãy mua sắm để lịch sử giao dịch xuất hiện tại đây.
                        </div>
                    @else
                        <div class="mt-6 space-y-4">
                            @foreach ($orders as $order)
                                @php
                                    $itemCount = $order->orderdetails->sum('qty');
                                    $orderTotal = $order->orderdetails->sum('amount');
                                @endphp
                                <article class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.25em] text-stone-500">Đơn #{{ $order->id }}</p>
                                            <h3 class="mt-2 text-lg font-bold text-white">{{ $statusLabels[$order->status] ?? 'Đang xử lý' }}</h3>
                                            <p class="mt-2 text-sm text-stone-400">
                                                Tạo ngày {{ optional($order->created_at)->format('d/m/Y H:i') }} • {{ $itemCount }} sản phẩm
                                            </p>
                                        </div>
                                        <div class="text-left sm:text-right">
                                            <p class="text-sm text-stone-400">Tổng thanh toán</p>
                                            <p class="mt-1 text-2xl font-black text-amber-300">{{ number_format($orderTotal, 0, ',', '.') }} d</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 space-y-3 border-t border-white/10 pt-4">
                                        @foreach ($order->orderdetails as $detail)
                                            <div class="flex items-center justify-between gap-4 text-sm">
                                                <div>
                                                    <p class="font-semibold text-white">{{ $detail->product->name ?? 'Sản phẩm không còn tồn tại' }}</p>
                                                    <p class="text-stone-400">Số lượng: {{ $detail->qty }}</p>
                                                </div>
                                                <p class="font-semibold text-stone-200">{{ number_format($detail->amount, 0, ',', '.') }} d</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
