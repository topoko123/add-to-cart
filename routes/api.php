<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User API
|--------------------------------------------------------------------------
*/
Route::get('/read/all/user', [UserController::class, 'get_all_user']);
Route::post('/create/user', [UserController::class, 'create_user']);
/*
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Product API
|--------------------------------------------------------------------------
*/

Route::get('/product/read-product', [ProductController::class, 'get_all_product']);

Route::post('/product/add', [ProductController::class, 'addProduct']);

Route::delete('/product/del/{product_id}', [ProductController::class, 'removeProduct']);

/*
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Cart API
|--------------------------------------------------------------------------
*/
Route::get('/read/product/cart/{user_id}', [CartController::class, 'read_product_all_in_cart']);
Route::post('/add/product/cart/{product_id}', [CartController::class, 'add_product_to_cart']);
Route::delete('/cart/del/{product_id}', [CartController::class, 'remove_product_in_cart']);
/*
|--------------------------------------------------------------------------
*/