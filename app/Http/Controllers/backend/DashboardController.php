<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Topic;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard', [
            'products' => Product::count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'contacts' => Contact::count(),
            'posts' => Post::count(),
            'banners' => Banner::count(),
            'menuCount' => Menu::count(),
            'topics' => Topic::count(),
        ]);
    }
}
