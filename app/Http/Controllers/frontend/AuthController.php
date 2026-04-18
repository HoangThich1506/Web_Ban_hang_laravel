<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])
            ->where('status', 1)
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()
                ->withInput($request->except('password'))
                ->with('error', 'Email hoac mat khau khong dung.');
        }

        session([
            'frontend_auth' => $user->id,
        ]);

        return redirect()
            ->route('site.home')
            ->with('success', 'Dang nhap thanh cong.');
    }

    public function showRegister(): View
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:user,username'],
            'email' => ['required', 'email', 'max:255', 'unique:user,email'],
            'phone' => ['required', 'string', 'max:255', 'unique:user,phone'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'] ?: Str::slug($data['name']).random_int(100, 999),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'password' => Hash::make($data['password']),
            'roles' => 'user',
            'status' => 1,
            'created_at' => now(),
            'created_by' => 1,
        ]);

        session([
            'frontend_auth' => $user->id,
        ]);

        return redirect()
            ->route('site.home')
            ->with('success', 'Tao tai khoan thanh cong.');
    }

    public function logout(): RedirectResponse
    {
        session()->forget('frontend_auth');

        return redirect()
            ->route('site.home')
            ->with('success', 'Ban da dang xuat.');
    }
}
