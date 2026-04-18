<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if ($cart === []) {
            return redirect()
                ->route('site.cart.index')
                ->with('error', 'Gio hang cua ban dang trong.');
        }

        $user = User::find(session('frontend_auth'));
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return view('frontend.checkout.index', [
            'cart' => $cart,
            'user' => $user,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if ($cart === []) {
            return redirect()
                ->route('site.cart.index')
                ->with('error', 'Gio hang cua ban dang trong.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($cart, $data): void {
            $order = Order::create([
                'user_id' => session('frontend_auth'),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
                'created_at' => now(),
                'status' => 1,
            ]);

            foreach ($cart as $item) {
                $product = Product::lockForUpdate()->find($item['id']);

                if (! $product) {
                    continue;
                }

                $availableQty = max(0, (int) $product->qty);

                if ($availableQty < 1) {
                    continue;
                }

                $qty = min($item['qty'], $availableQty);
                $price = (float) ($product->price_sale ?: $product->price_buy);

                Orderdetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                    'amount' => $qty * $price,
                ]);

                $product->qty = max(0, (int) $product->qty - $qty);
                $product->save();
            }
        });

        session()->forget('cart');

        return redirect()
            ->route('site.home')
            ->with('success', 'Dat hang thanh cong. Chung toi se lien he voi ban som.');
    }
}
