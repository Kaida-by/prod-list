<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BasicProductsController;
use App\Http\Controllers\GeneralProductController;
use App\Http\Controllers\GeneralTypeProductController;
use App\Http\Controllers\GenerateProductListController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\TypeProductController;
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
Route::group(['prefix' => '/auth', 'middleware' => 'api'], static function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::group(['middleware' => 'jwt.auth'], static function () {
    //User
    Route::get('/me', [LoginController::class, 'me']);

    //Product
    Route::get('/products/get', [ProductController::class, 'index']);
    Route::get('/product/{id}', [ProductController::class, 'one']);
    Route::post('/product/create', [ProductController::class, 'create']);
    Route::patch('/product/update/{product}', [ProductController::class, 'update']);
    Route::delete('/product/delete/{product}', [ProductController::class, 'delete']);
        //GeneralProducts
        Route::get('/general-products/get/', [GeneralProductController::class, 'getAllProducts']);
        Route::get('/general-products-by-name/get/{name}', [GeneralProductController::class, 'getAllProductsByName']);
        Route::get('/general-product/{id}', [GeneralProductController::class, 'one']);
        Route::post('/general-product/create', [GeneralProductController::class, 'create']);
        Route::patch('/general-product/update/{generalProduct}', [GeneralProductController::class, 'update']);
        Route::delete('/general-product/delete/{generalProduct}', [GeneralProductController::class, 'delete']);

    //ProductList
    Route::get('/product-lists/get', [ProductListController::class, 'index']);
    Route::get('/product-list/{id}', [ProductListController::class, 'one']);
    Route::post('/product-list/create', [ProductListController::class, 'create']);
    Route::patch('/product-list/update/{productList}', [ProductListController::class, 'update']);
    Route::delete('/product-list/delete/{productList}', [ProductListController::class, 'delete']);
    Route::delete('/product-list/delete-type-product/{id}', [ProductListController::class, 'deleteTypeProductFromProductList']);
    Route::delete('/product-list/delete-product/{id}', [ProductListController::class, 'deleteProductFromProductList']);

    //TypeProduct
    Route::get('/type-products/get', [TypeProductController::class, 'index']);
    Route::get('/type-product/{id}', [TypeProductController::class, 'one']);
    Route::post('/type-product/create', [TypeProductController::class, 'create']);
    Route::patch('/type-product/update/{typeProduct}', [TypeProductController::class, 'update']);
    Route::delete('/type-product/delete/{typeProduct}', [TypeProductController::class, 'delete']);
        //GeneralTypeProducts
        Route::get('/general-type-products/get', [GeneralTypeProductController::class, 'getAllTypeProducts']);
        Route::get('/general-type-product/{id}', [GeneralTypeProductController::class, 'one']);
        Route::post('/general-type-product/create', [GeneralTypeProductController::class, 'create']);
        Route::patch('/general-type-product/update/{generalTypeProduct}', [GeneralTypeProductController::class, 'update']);
        Route::delete('/general-type-product/delete/{generalTypeProduct}', [GeneralTypeProductController::class, 'delete']);

    //GetSomeEntities
    Route::get('/type-counts/get', [HelpController::class, 'getTypeCounts']);
    Route::get('/basic-products/get', [HelpController::class, 'getBasicProducts']);
    Route::get('/basic-type-products/get', [HelpController::class, 'getBasicTypeProducts']);
    //Generate Product List
    Route::post('/product-list/generate', [GenerateProductListController::class, 'generate']);
});

