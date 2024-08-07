<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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
    return view('auth.login');
})->name('login');


Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('auth/redirect', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/call-back', [GoogleController::class, 'handleGoogleCallback']);
