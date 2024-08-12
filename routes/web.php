<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/product/{id}/reviews', [ProductController::class, 'reviews'])->name('product.reviews');
Route::get('/products/{id}/reviews', [ProductController::class, 'loadMoreReviews']);


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

    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order/generateSnapToken', [OrderController::class, 'generateSnapToken'])->name('order.generateSnapToken');
    Route::post('/order/delete', [OrderController::class, 'delete'])->name('order.delete');
    // Route::post('/order/continuePayment', [OrderController::class, 'continuePayment'])->name('order.continuePayment');
    Route::post('/order/pay', [OrderController::class, 'pay'])->name('order.pay');
    Route::post('/order/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::post('/order/syncStatus', [OrderController::class, 'syncStatus'])->name('order.syncStatus');
    Route::post('/order/updateStatus', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    // Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::get('/order/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
    Route::post('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');

    Route::get('/order/finish', [OrderController::class, 'finish'])->name('order.finish');
    Route::get('/order/unfinish', [OrderController::class, 'unfinish'])->name('order.unfinish');
    Route::get('/order/error', [OrderController::class, 'error'])->name('order.error');

    Route::get('/account/profile', [UserAccountController::class, 'profile'])->name('account.profile');
    Route::get('/account/edit', [UserAccountController::class, 'edit'])->name('account.profile.edit');
    Route::put('/account/update', [UserAccountController::class, 'update'])->name('account.profile.update');
    Route::get('/account/orders', [UserAccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/wishlist', [UserAccountController::class, 'wishlist'])->name('account.wishlist');

    Route::post('addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::get('addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');

    Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
});

Route::prefix('admin')->name('admin.')->middleware('auth', 'admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class);

    Route::resource('categories', AdminCategoryController::class);

    Route::resource('orders', AdminOrderController::class);

    Route::get('users/export', [AdminUserController::class, 'export'])->name('users.export');
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});
