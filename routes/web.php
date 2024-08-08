<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
