<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', function () {
    if (Auth::check()) {
        return redirect('/');
    }
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('auth/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/call-back', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/account/profile', [UserAccountController::class, 'profile'])->name('account.profile');
    Route::get('/account/orders', [UserAccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/wishlist', [UserAccountController::class, 'wishlist'])->name('account.wishlist');
});
