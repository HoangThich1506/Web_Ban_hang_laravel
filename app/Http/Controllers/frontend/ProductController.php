<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();

        $products = Product::with('category')
            ->where('status', 1)
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = trim((string) $request->input('keyword'));
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $category = trim((string) $request->input('category'));

                $query->whereHas('category', function ($categoryQuery) use ($category) {
                    $categoryQuery
                        ->where('slug', $category)
                        ->orWhere('id', $category);
                });
            })
            ->when($request->filled('price_min'), function ($query) use ($request) {
                $minPrice = (float) $request->input('price_min');
                $query->whereRaw('COALESCE(NULLIF(price_sale, 0), price_buy) >= ?', [$minPrice]);
            })
            ->when($request->filled('price_max'), function ($query) use ($request) {
                $maxPrice = (float) $request->input('price_max');
                $query->whereRaw('COALESCE(NULLIF(price_sale, 0), price_buy) <= ?', [$maxPrice]);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.products', compact('products', 'categories'));
    }

    public function detail(string $slug): View
    {
        $product = Product::where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::where('status', 1)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
}
