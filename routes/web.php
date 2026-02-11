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
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
});
