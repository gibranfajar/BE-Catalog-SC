<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::post('/articles/store', [ArticleController::class, 'store']);
Route::post('/articles/update/{id}', [ArticleController::class, 'update']);


Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::post('/categories/store', [CategoryController::class, 'store']);
Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy']);


Route::get('/colors', [ColorController::class, 'index'])->name('colors');
Route::post('/colors/store', [ColorController::class, 'store']);
Route::post('/colors/update/{id}', [ColorController::class, 'update']);
Route::get('/colors/delete/{id}', [ColorController::class, 'destroy']);


Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products-add', [ProductController::class, 'add'])->name('products.add');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/delete/{id}', [ProductController::class, 'destroy']);


Route::get('/sizes', [SizeController::class, 'index'])->name('sizes');
Route::post('/sizes/store', [SizeController::class, 'store']);
Route::post('/sizes/update/{id}', [SizeController::class, 'update']);

Route::get('/product-images', [ProductImageController::class, 'index'])->name('product-images');
Route::post('/product-images/store', [ProductImageController::class, 'store']);
Route::delete('/product-images/delete/{id}', [ProductImageController::class, 'destroy']);
