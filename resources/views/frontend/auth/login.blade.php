@extends('layouts.app')

@section('title', 'Đăng nhập | Mr.Hoang Store')

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-2">
            <div class="card-surface p-8">
                <p class="section-kicker">Tài khoản</p>
                <h1 class="mt-4 text-4xl font-black text-white">Đăng nhập để mua hàng nhanh hơn</h1>
                <p class="mt-6 text-base leading-8 text-stone-300">
                    Sau khi đăng nhập, bạn có thể lưu thông tin cá nhân, vào trang thanh toán nhanh hơn và theo dõi luồng mua sắm mạch lạc hơn.
                </p>
            </div>

            <form action="{{ route('site.login.post') }}" method="POST" class="card-surface p-8">
                @csrf
                <h2 class="text-2xl font-bold text-white">Đăng nhập</h2>

                <div class="mt-6 space-y-5">
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-input">
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="primary-button mt-6 w-full justify-center">Đăng nhập</button>
                <p class="mt-5 text-sm text-stone-400">
                    Chưa có tài khoản?
                    <a href="{{ route('site.register') }}" class="font-semibold text-amber-300 hover:text-amber-200">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </section>
@endsection
