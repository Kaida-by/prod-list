<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\TypeProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth
Route::group(['prefix' => '/auth'], static function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);

    //Product
    Route::get('products/get', [ProductController::class, 'index']);
    Route::post('product/create', [ProductController::class, 'create']);
    Route::patch('product/update/{product}', [ProductController::class, 'update']);
    Route::delete('product/delete/{product}', [ProductController::class, 'delete']);

    //ProductList
    Route::get('product-lists/get', [ProductListController::class, 'index']);
    Route::post('product-list/create', [ProductListController::class, 'create']);
    Route::patch('product-list/update/{productList}', [ProductListController::class, 'update']);
    Route::delete('product-list/delete/{productList}', [ProductListController::class, 'delete']);

    //TypeProduct
    Route::get('type-products/get', [TypeProductController::class, 'index']);
    Route::post('type-product/create', [TypeProductController::class, 'create']);
    Route::patch('type-product/update/{typeProduct}', [TypeProductController::class, 'update']);
    Route::delete('type-product/delete/{typeProduct}', [TypeProductController::class, 'delete']);

    //Comment
    Route::get('comments/get', [CommentController::class, 'index']);
    Route::post('comment/create', [CommentController::class, 'create']);
    Route::patch('comment/update/{typeProduct}', [CommentController::class, 'update']);
    Route::delete('comment/delete/{typeProduct}', [CommentController::class, 'delete']);
});
