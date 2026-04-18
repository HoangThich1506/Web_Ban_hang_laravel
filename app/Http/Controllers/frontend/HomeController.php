<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::where('status', 1)->latest()->take(8)->get();
        $banners = Banner::where('status', 1)->latest()->take(3)->get();

        return view('frontend.home', compact('banners', 'products'));
    }
}
