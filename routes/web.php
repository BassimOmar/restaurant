<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── WEBSITE (Public) ────────────────────────────────────────────
Route::get('/', [App\Http\Controllers\Website\PageController::class, 'home'])->name('website.home');
Route::get('/menu', [App\Http\Controllers\Website\PageController::class, 'menu'])->name('website.menu');
Route::get('/private-dining', [App\Http\Controllers\Website\PageController::class, 'privateDining'])->name('website.private_dining');
Route::get('/about', [App\Http\Controllers\Website\PageController::class, 'about'])->name('website.about');

// Booking (public)
Route::get('/booking', [App\Http\Controllers\Website\BookingController::class, 'index'])->name('website.booking');
Route::post('/booking', [App\Http\Controllers\Website\BookingController::class, 'store'])->name('website.booking.store');

// ─── PROFILE (Authenticated) ─────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── BREEZE AUTH ─────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── ADMIN DASHBOARD ─────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:owner'])->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');

    // Users
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

    // Tables
    Route::resource('tables', App\Http\Controllers\Admin\TableController::class);

    // Discounts
    Route::resource('discounts', App\Http\Controllers\Admin\DiscountController::class);

    // Bookings
    Route::get('bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status/{status}', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');

    // CRM - Customers
    Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
    Route::get('customers/{customer}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customers.edit');
    Route::patch('customers/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customers.update');

    // Activity Logs
    Route::get('logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('logs.show');
});

// ─── SUPERVISOR DASHBOARD ───────────────────────────────────────
Route::prefix('supervisor')->middleware(['auth', 'role:owner,supervisor'])->name('supervisor.')->group(function () {
    Route::get('/', [App\Http\Controllers\Supervisor\DashboardController::class, 'index'])->name('index');

    // Inventory
    Route::resource('inventory', App\Http\Controllers\Supervisor\InventoryController::class);
    Route::post('inventory/{inventoryItem}/adjust', [App\Http\Controllers\Supervisor\InventoryController::class, 'adjustStock'])->name('inventory.adjust');

    // Menu Categories
    Route::resource('menu-categories', App\Http\Controllers\Supervisor\MenuCategoryController::class);

    // Menu Items
    Route::resource('menu-items', App\Http\Controllers\Supervisor\MenuItemController::class);
});

// ─── WAITER DASHBOARD ────────────────────────────────────────────
Route::prefix('waiter')->middleware(['auth', 'role:owner,supervisor,waiter'])->name('waiter.')->group(function () {
    Route::get('/', [App\Http\Controllers\Waiter\DashboardController::class, 'index'])->name('index');

    // Orders
    Route::get('orders', [App\Http\Controllers\Waiter\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [App\Http\Controllers\Waiter\OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [App\Http\Controllers\Waiter\OrderController::class, 'store'])->name('orders.store');
    Route::patch('orders/{order}/status', [App\Http\Controllers\Waiter\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('order-items/{orderItem}/status', [App\Http\Controllers\Waiter\OrderController::class, 'updateItemStatus'])->name('orders.item.status');

    // Payments
    Route::get('payments/{order}', [App\Http\Controllers\Waiter\PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments/{order}', [App\Http\Controllers\Waiter\PaymentController::class, 'store'])->name('payments.store');
});