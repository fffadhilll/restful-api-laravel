<?php

use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;

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

Route::middleware('auth:sanctum')->group(function() {
    // ADMIN
    Route::put('/ubahStatus/{id}', [AdminController::class, 'ubahStatus'])->middleware('admin-auth');
    
    // USER
    // LOGIN
    Route::post('/logout', [UserController::class, 'logout']);
    
    // PRODUCT
    Route::get('/showProducts', [ProductController::class, 'showProducts']);
    Route::post('/addProduct', [ProductController::class, 'addProduct'])->middleware('admin-auth');
    Route::put('/updateProduct/{id}', [ProductController::class, 'updateProduct'])->middleware('admin-auth');
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->middleware('admin-auth');
    
    // CART
    Route::get('/showCarts', [CartController::class, 'showCarts']);
    Route::post('/addCart', [CartController::class, 'addCart']);
    Route::put('/updateCart/{id}', [CartController::class, 'updateCart']);
    Route::delete('/deleteCart/{id}', [CartController::class, 'deleteCart']);
    
    // ORDER
    Route::get('/showOrders', [OrderController::class, 'showOrders']);
    Route::post('/addOrder', [orderController::class, 'addOrder']);
    Route::get('/orderDetail/{id}', [UserController::class, 'orderDetail']);
});

Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);
