<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ChefController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('menu');
});

// ==================== AUTH ROUTES ====================
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== CUSTOMER ROUTES ====================
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/cart', [MenuController::class, 'cart'])->name('cart');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [MenuController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [MenuController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place', [MenuController::class, 'placeOrder'])->name('checkout.place');
Route::get('/order-success', [MenuController::class, 'orderSuccess'])->name('order.success');

// ==================== ADMIN ROUTES (with auth middleware) ====================
Route::middleware('auth')->group(function () {

    // ==================== ADMIN (hanya admin role) ====================
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

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roles');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'delete'])->name('roles.delete');

        
        // Employees
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');
    });

    // ==================== CASHIER ROUTES ====================
    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/orders', [CashierController::class, 'orders'])->name('orders');
        Route::put('/orders/{id}/confirm', [CashierController::class, 'confirmPayment'])->name('orders.confirm');
    });

    // ==================== CHEF ROUTES ====================
    Route::prefix('chef')->name('chef.')->group(function () {
        Route::get('/orders', [ChefController::class, 'orders'])->name('orders');
        Route::put('/orders/{id}/cook', [ChefController::class, 'markAsCooked'])->name('orders.cook');
    });
});
