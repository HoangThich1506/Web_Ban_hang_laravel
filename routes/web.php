<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\AuthController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProfileController;
use App\Http\Controllers\frontend\ProductController as SanphamController;
use App\Http\Controllers\frontend\ContactController as LienheController;

use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\UserController;


// ================= FRONTEND =================
Route::get('/', [HomeController::class,'index'])->name('site.home');

Route::get('san-pham',[SanphamController::class,'index'])->name('site.products.index');
Route::get('san-pham/{slug}',[SanphamController::class,'detail'])->name('site.product.detail');

Route::get('dang-nhap', [AuthController::class, 'showLogin'])->name('site.login');
Route::post('dang-nhap', [AuthController::class, 'login'])->name('site.login.post');
Route::get('dang-ky', [AuthController::class, 'showRegister'])->name('site.register');
Route::post('dang-ky', [AuthController::class, 'register'])->name('site.register.post');
Route::post('dang-xuat', [AuthController::class, 'logout'])->name('site.logout');

Route::get('gio-hang', [CartController::class, 'index'])->name('site.cart.index');
Route::post('gio-hang/{id}', [CartController::class, 'store'])->name('site.cart.store');
Route::post('gio-hang/{id}/cap-nhat', [CartController::class, 'update'])->name('site.cart.update');
Route::delete('gio-hang/{id}', [CartController::class, 'destroy'])->name('site.cart.destroy');

Route::get('lien-he',[LienheController::class,'index'])->name('site.contact.index');
Route::post('lien-he',[LienheController::class,'store'])->name('site.contact.store');

Route::middleware('frontend.auth')->group(function () {
    Route::get('thanh-toan', [CheckoutController::class, 'index'])->name('site.checkout.index');
    Route::post('thanh-toan', [CheckoutController::class, 'store'])->name('site.checkout.store');
    Route::get('tai-khoan', [ProfileController::class, 'index'])->name('site.profile');
    Route::post('tai-khoan', [ProfileController::class, 'update'])->name('site.profile.update');
});


// ================= BACKEND =================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    // PRODUCTS
    Route::get('products/trash', [ProductController::class,'trash'])->name('products.trash');
    Route::post('products/{id}/restore', [ProductController::class,'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class,'forceDelete'])->name('products.forceDelete');
    Route::get('products/{id}/status', [ProductController::class,'status'])->name('products.status');
    Route::resource('products', ProductController::class)->except(['products.show']);

    // BANNERS
    Route::get('banners/trash', [BannerController::class,'trash'])->name('banners.trash');
    Route::post('banners/{id}/restore', [BannerController::class,'restore'])->name('banners.restore');
    Route::delete('banners/{id}/force-delete', [BannerController::class,'forceDelete'])->name('banners.forceDelete');
    Route::get('banners/{id}/status', [BannerController::class,'status'])->name('banners.status');
    Route::resource('banners', BannerController::class)->except(['show']);

    // BRANDS
    Route::get('brands/trash', [BrandController::class,'trash'])->name('brands.trash');
    Route::post('brands/{id}/restore', [BrandController::class,'restore'])->name('brands.restore');
    Route::delete('brands/{id}/force-delete', [BrandController::class,'forceDelete'])->name('brands.forceDelete');
    Route::get('brands/{id}/status', [BrandController::class,'status'])->name('brands.status');
    Route::resource('brands', BrandController::class)->except(['show']);

    // CATEGORIES
    Route::get('categories/trash', [CategoryController::class,'trash'])->name('categories.trash');
    Route::post('categories/{id}/restore', [CategoryController::class,'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class,'forceDelete'])->name('categories.forceDelete');
    Route::get('categories/{id}/status', [CategoryController::class,'status'])->name('categories.status');
    Route::resource('categories', CategoryController::class)->except(['show']);

    // CONTACTS
    Route::get('contacts/trash', [ContactController::class,'trash'])->name('contacts.trash');
    Route::post('contacts/{id}/restore', [ContactController::class,'restore'])->name('contacts.restore');
    Route::delete('contacts/{id}/force-delete', [ContactController::class,'forceDelete'])->name('contacts.forceDelete');
    Route::resource('contacts', ContactController::class)->except(['show']);

    // ORDERS
    Route::get('orders/trash', [OrderController::class,'trash'])->name('orders.trash');
    Route::post('orders/{id}/restore', [OrderController::class,'restore'])->name('orders.restore');
    Route::delete('orders/{id}/force-delete', [OrderController::class,'forceDelete'])->name('orders.forceDelete');
    Route::resource('orders', OrderController::class)->except(['show']);

    // POSTS
    Route::get('posts/trash', [PostController::class,'trash'])->name('posts.trash');
    Route::post('posts/{id}/restore', [PostController::class,'restore'])->name('posts.restore');
    Route::delete('posts/{id}/force-delete', [PostController::class,'forceDelete'])->name('posts.forceDelete');
    Route::get('posts/{id}/status', [PostController::class,'status'])->name('posts.status');
    Route::resource('posts', PostController::class)->except(['show']);

    // TOPICS
    Route::get('topics/trash', [TopicController::class,'trash'])->name('topics.trash');
    Route::post('topics/{id}/restore', [TopicController::class,'restore'])->name('topics.restore');
    Route::delete('topics/{id}/force-delete', [TopicController::class,'forceDelete'])->name('topics.forceDelete');
    Route::get('topics/{id}/status', [TopicController::class,'status'])->name('topics.status');
    Route::resource('topics', TopicController::class)->except(['show']);

    // MENUS
    Route::get('menus/trash', [MenuController::class,'trash'])->name('menus.trash');
    Route::post('menus/{id}/restore', [MenuController::class,'restore'])->name('menus.restore');
    Route::delete('menus/{id}/force-delete', [MenuController::class,'forceDelete'])->name('menus.forceDelete');
    Route::get('menus/{id}/status', [MenuController::class,'status'])->name('menus.status');
    Route::resource('menus', MenuController::class)->except(['show']);

    // USERS
    Route::get('users/trash', [UserController::class,'trash'])->name('users.trash');
    Route::post('users/{id}/restore', [UserController::class,'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class,'forceDelete'])->name('users.forceDelete');
    Route::get('users/{id}/status', [UserController::class,'status'])->name('users.status');
    Route::resource('users', UserController::class)->except(['show']);

});
