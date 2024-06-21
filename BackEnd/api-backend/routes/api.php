<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
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

Route::prefix('v1/')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('forgot', 'forgotPassword')->name('forgot_password');
        Route::get('reset', 'checkToken');
        Route::put('reset', 'resetPassword')->name('reset_password');
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories', 'getAll');
        Route::get('category/{id}', 'getNameCategory');
    });
    Route::controller(CommentController::class)->group(function () {
        Route::get('comments/{id}', 'getCommentByProduct');
        Route::post('addComment', 'addComment');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('products', 'getAll');
        Route::get('productSpecial', 'getProductSpecial');
        Route::get('getProductSell', 'getProductSell');
        Route::get('suggest', 'getProductSuggest');
        Route::get('products_category/{id}', 'getProductByCategoryId');
        Route::get('other', 'getProductOther');
        Route::get('detail/{id}', 'getProductById');
    });
});

Route::middleware('auth:sanctum')->prefix('v1/')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('users', 'getAll');
        Route::get('user/info', 'info');
        Route::get('users/{role}', 'getUserByRole');
        Route::put('updateInfo', 'updateInfoUser');
        Route::put('updatePassword', 'updatePassword');
        Route::put('updateRole/{id}', 'updateRole');
    });
    Route::controller(CartController::class)->group(function () {
        Route::get('cart', 'getCartByUserId');
        Route::delete('cart/delete/{id}', 'deleteProduct');
        Route::post('addToCart', 'addToCart');
    });
    Route::controller(CommentController::class)->group(function () {
        Route::post('addComment', 'addComment');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('orders', 'getAll');
        Route::get('orders/{status}', 'getOrderByStatus');
        Route::get('user/orders', 'getOrderByUser');
        Route::post('addOrder', 'createOrder');
        Route::put('updateStatus/{id}', 'update');
        Route::get('getOrder/{id}', 'getOrderById');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('productsList', 'getList');
        Route::post('createProduct', 'createProduct');
        Route::put('updateProduct/{id}', 'updateProduct');
        Route::delete('deleteProduct/{id}', 'deleteProduct');
    });
    Route::controller(FavoriteController::class)->group(function () {
        Route::get('favorite/getAll', 'getAll');
        Route::post('favorite/addFavorite', 'addFavorite');
        Route::delete('favorite/deleteFavorite/{id}', 'deleteFavorite');
    });
});
