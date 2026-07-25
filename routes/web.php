<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('menu');
});

// ==================== CUSTOMER ROUTES ====================
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/cart', [MenuController::class, 'cart'])->name('cart');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [MenuController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [MenuController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place', [MenuController::class, 'placeOrder'])->name('checkout.place');
Route::get('/order-success', [MenuController::class, 'orderSuccess'])->name('order.success');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'categoryCreate'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'categoryEdit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'categoryUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'categoryDelete'])->name('categories.delete');

    // Items / Menu
    Route::get('/items', [AdminController::class, 'items'])->name('items');
    Route::get('/items/create', [AdminController::class, 'itemCreate'])->name('items.create');
    Route::post('/items', [AdminController::class, 'itemStore'])->name('items.store');
    Route::get('/items/{id}/edit', [AdminController::class, 'itemEdit'])->name('items.edit');
    Route::put('/items/{id}', [AdminController::class, 'itemUpdate'])->name('items.update');
    Route::delete('/items/{id}', [AdminController::class, 'itemDelete'])->name('items.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{id}/status', [AdminController::class, 'orderUpdateStatus'])->name('orders.update-status');
});
