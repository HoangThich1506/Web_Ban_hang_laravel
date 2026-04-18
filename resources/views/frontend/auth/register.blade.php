@extends('layouts.app')

@section('title', 'Đăng ký | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="card-surface p-8">
                <p class="section-kicker">Tạo tài khoản</p>
                <h1 class="mt-4 text-4xl font-black text-white">Đăng ký để bắt đầu mua sắm</h1>
                <p class="mt-6 text-base leading-8 text-stone-300">
                    Điền thông tin cơ bản để tạo tài khoản khách hàng. Sau khi đăng ký thành công, hệ thống sẽ tự đăng nhập cho bạn.
                </p>
            </div>

            <form action="{{ route('site.register.post') }}" method="POST" class="card-surface p-8">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-input">
                        @error('username') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input">
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="form-input">
                        @error('address') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-input">
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-input">
                    </div>
                </div>

                <button type="submit" class="primary-button mt-6 w-full justify-center">Tạo tài khoản</button>
            </form>
        </div>
    </section>
@endsection
