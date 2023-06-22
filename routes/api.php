<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Category
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category/store', [CategoryController::class, 'store']);
Route::get('/category/detail/{category}', [CategoryController::class, 'detail']);
Route::put('/category/update/{category}', [CategoryController::class, 'update']);
Route::delete('/category/destroy/{category}', [CategoryController::class, 'destroy']);

// Product
Route::get('/product', [ProductController::class, 'index']);
Route::post('/product/store', [ProductController::class, 'store']);
Route::get('/product/detail/{product}', [ProductController::class, 'detail']);
Route::put('/product/update/{product}', [ProductController::class, 'update']);
Route::delete('/product/destroy/{product}', [ProductController::class, 'destroy']);

// CategoryProduct
Route::get('/category/product', [CategoryProductController::class, 'index']);
Route::post('/category/product/store', [CategoryProductController::class, 'store']);
Route::put('/category/product/update/{product}/{category}', [CategoryProductController::class, 'update']);
Route::delete('/category/product/destroy/{product}/{category}', [CategoryProductController::class, 'destroy']);


// Image
Route::get('/image', [ImageController::class, 'index']);
Route::post('/image/store', [ImageController::class, 'store']);
Route::get('/image/detail/{image}', [ImageController::class, 'detail']);
Route::post('/image/update/{image}', [ImageController::class, 'update']);
Route::delete('/image/destroy/{image}', [ImageController::class, 'destroy']);
