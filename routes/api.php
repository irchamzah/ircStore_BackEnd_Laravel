<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/products/showfeaturedProducts', [ProductController::class, 'showfeaturedProducts']);
Route::get('/products/showAllProducts', [ProductController::class, 'showAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'detailProduct']);
Route::get('/products/{id}/loadMoreReviews', [ProductController::class, 'loadMoreReviews']);

Route::get('/categories/showAllCategories', [CategoryController::class, 'showAllCategories']);
