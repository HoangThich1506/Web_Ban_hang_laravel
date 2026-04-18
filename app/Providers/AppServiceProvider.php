<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $userId = session('frontend_auth');
            $currentUser = null;

            if ($userId) {
                $currentUser = User::where('status', 1)->find($userId);
            }

            $cart = session('cart', []);
            $cartCount = collect($cart)->sum('qty');

            $view->with('menus', Menu::where('status', 1)->orderBy('id')->get())
                ->with('currentUser', $currentUser)
                ->with('cartCount', $cartCount);
        });
    }
}
