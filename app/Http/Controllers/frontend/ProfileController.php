<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = User::where('status', 1)->find(session('frontend_auth'));

        if (! $user) {
            session()->forget('frontend_auth');

            return redirect()
                ->route('site.login')
                ->with('error', 'Phien dang nhap da het han. Vui long dang nhap lai.');
        }

        $orders = Order::with('orderdetails.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('frontend.profile.index', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = User::where('status', 1)->findOrFail(session('frontend_auth'));

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('user', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('user', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:255', Rule::unique('user', 'phone')->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $payload = [
            'name' => $data['name'],
            'username' => $data['username'] ?: $user->username,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'updated_at' => now(),
            'updated_by' => $user->id,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        return redirect()
            ->route('site.profile')
            ->with('success', 'Cap nhat tai khoan thanh cong.');
    }
}
