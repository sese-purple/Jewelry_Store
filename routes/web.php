<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome')->name('welcome');


Route::get('/home_page', [MainController::class, 'homepage'])->middleware('auth')->name('homepage');


Route::get('/product_for', [ProductController::class, 'product_form'])->middleware('auth')->name('product_form');
Route::post('/inka', [ProductController::class, 'store_product'])->middleware('auth')->name('reister');
Route::get('/all_products', [ProductController::class, 'all_products'])->name('all_products');
Route::get('/products/category/{category_id}', [ProductController::class, 'products_by_category'])->name('products_by_category');
Route::get('/delete_product/{product_id}', [ProductController::class, 'delete_product'])->middleware('auth')->name('delete_product');
Route::get('/edit_product/{id}', [ProductController::class, 'edit_product'])->middleware('auth')->name('edit_product');
Route::post('/update_product/{id}', [ProductController::class, 'update_product'])->middleware('auth')->name('update_product');
Route::post('/sell_product/{id}', [ProductController::class, 'sell_product'])->middleware('auth')->name('sell_product');
Route::post('/purchase_product/{id}', [ProductController::class, 'purchase_product'])->middleware('auth')->name('purchase_product');

Route::get('/registration_form', [UserController::class, 'registration_form'])->name('registration_form');
Route::post('/store_user', [UserController::class, 'store_user'])->name('store_user');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login_user', [UserController::class, 'login_user'])->name('login_user');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

// Wishlist Routes
Route::prefix('wishlist')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/add/{product}', [\App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/remove/{product}', [\App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/clear', [\App\Http\Controllers\WishlistController::class, 'clear'])->name('wishlist.clear');
});

// Cart Routes
Route::prefix('cart')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/count', [\App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
});

// Order Routes
Route::prefix('orders')->group(function () {
    Route::get('/', [\App\Http\Controllers\OrderController::class, 'index'])->middleware('auth')->name('orders.index');
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->middleware('auth')->name('orders.checkout');
    Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->middleware('auth')->name('orders.store');
    Route::get('/success/{order}', [\App\Http\Controllers\OrderController::class, 'success'])->middleware('auth')->name('orders.success');
    Route::get('/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->middleware('auth')->name('orders.show');
});
