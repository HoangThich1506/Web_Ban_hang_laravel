<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return view('frontend.cart.index', [
            'cart' => $cart,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request, int $id): RedirectResponse
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $product = Product::where('status', 1)->findOrFail($id);
        $stock = max(0, (int) $product->qty);

        if ($stock < 1) {
            return back()->with('error', 'San pham hien da het hang.');
        }

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => (float) ($product->price_sale ?: $product->price_buy),
                'qty' => $qty,
                'stock' => $stock,
            ];
        }

        if ($cart[$id]['qty'] > $stock) {
            $cart[$id]['qty'] = $stock;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Da them san pham vao gio hang.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $cart = session('cart', []);

        if (! isset($cart[$id])) {
            return back()->with('error', 'San pham khong ton tai trong gio hang.');
        }

        $qty = max(1, (int) $request->input('qty', 1));
        $stock = max(1, (int) $cart[$id]['stock']);
        $cart[$id]['qty'] = min($qty, $stock);

        session(['cart' => $cart]);

        return back()->with('success', 'Da cap nhat gio hang.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$id]);

        session(['cart' => $cart]);

        return back()->with('success', 'Da xoa san pham khoi gio hang.');
    }
}
