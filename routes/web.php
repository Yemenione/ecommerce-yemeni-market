<?php

use Illuminate\Support\Facades\Route;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Livewire\LandingPage;
use App\Livewire\ShopPage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;

Route::get('/', function () {
    return redirect(LaravelLocalization::getLocalizedURL(LaravelLocalization::getDefaultLocale(), '/'));
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', LandingPage::class)->name('home');
    Route::get('/shop', ShopPage::class)->name('shop');
    Route::get('/cart', CartPage::class)->name('cart');
    Route::get('/wishlist', \App\Livewire\WishlistPage::class)->name('wishlist');
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/success/{order}', \App\Livewire\SuccessPage::class)->name('success');
    Route::get('/track-order', \App\Livewire\OrderTrackingPage::class)->name('order.track');
    Route::get('/product/{slug}', \App\Livewire\ProductPage::class)->name('product.show');
    Route::get('/orders/{order}/invoice', [App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');

    // Auth Routes
    Route::middleware('auth')->group(function () {
        Route::get('/my-profile', \App\Livewire\ProfilePage::class)->name('profile');
        Route::get('/my-orders', \App\Livewire\MyOrdersPage::class)->name('my-orders');
    });

    Route::get('/login', \App\Livewire\Auth\LoginPage::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\RegisterPage::class)->name('register');
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');

    // Static Pages
    Route::view('/about', 'pages.about')->name('about');
    Route::get('/contact', \App\Livewire\ContactPage::class)->name('contact');
    Route::view('/terms', 'pages.terms')->name('terms');
    Route::view('/privacy', 'pages.privacy')->name('privacy');
    Route::view('/shipping', 'pages.shipping')->name('shipping');
});
