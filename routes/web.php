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


// ═══════════════════════════════════════════════════════════════════════
// LOGIN/LOGOUT (Uses Breeze view, custom controller logic)
// ═══════════════════════════════════════════════════════════════════════

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

    
// ─── PROFILE (Authenticated) ─────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── BREEZE AUTH ─────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── ADMIN DASHBOARD ─────────────────────────────────────────────

Route::prefix('admin')
    ->middleware(['auth', 'role:owner'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('tables', App\Http\Controllers\Admin\TableController::class);
        Route::resource('discounts', App\Http\Controllers\Admin\DiscountController::class);
        
        Route::get('bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::post('bookings/{booking}/confirm', [App\Http\Controllers\Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('bookings/{booking}/arrived', [App\Http\Controllers\Admin\BookingController::class, 'arrived'])->name('bookings.arrived');
        Route::post('bookings/{booking}/cancel', [App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
        
        Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customers.show');
        Route::get('customers/{customer}/edit', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customers.edit');
        Route::patch('customers/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customers.update');
        
        Route::get('logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
        Route::get('logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('logs.show');
    });


// SUPERVISOR DASHBOARD (Owner + Supervisor)

Route::prefix('supervisor')
    ->middleware(['auth', 'role:owner,supervisor'])
    ->name('supervisor.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Supervisor\DashboardController::class, 'index'])->name('index');
        
        Route::resource('inventory', App\Http\Controllers\Supervisor\InventoryController::class);
        Route::post('inventory/{inventoryItem}/adjust', [App\Http\Controllers\Supervisor\InventoryController::class, 'adjustStock'])->name('inventory.adjust');
        
        Route::resource('menu_categories', App\Http\Controllers\Supervisor\MenuCategoryController::class);
        Route::resource('menu_items', App\Http\Controllers\Supervisor\MenuItemController::class);
    });


// WAITER DASHBOARD (All Staff)

Route::prefix('waiter')
    ->middleware(['auth', 'role:owner,supervisor,waiter'])
    ->name('waiter.')
    ->group(function () {
        
        // Dashboard Home
        Route::get('/', [App\Http\Controllers\Waiter\DashboardController::class, 'index'])
            ->name('index');

        // Order Management
        Route::get('orders', [App\Http\Controllers\Waiter\OrderController::class, 'index'])
            ->name('orders.index');
        
        Route::get('orders/create', [App\Http\Controllers\Waiter\OrderController::class, 'create'])
            ->name('orders.create');
        
        Route::post('orders', [App\Http\Controllers\Waiter\OrderController::class, 'store'])
            ->name('orders.store');
        
        // Order Status Updates
        Route::post('orders/{order}/start', [App\Http\Controllers\Waiter\OrderController::class, 'start'])
            ->name('orders.start');
        
        Route::post('orders/{order}/complete', [App\Http\Controllers\Waiter\OrderController::class, 'complete'])
            ->name('orders.complete');
        
        Route::post('orders/{order}/cancel', [App\Http\Controllers\Waiter\OrderController::class, 'cancel'])
            ->name('orders.cancel');

        // Payment Processing
        Route::get('payments/create', [App\Http\Controllers\Waiter\PaymentController::class, 'create'])
            ->name('payments.create');
        
        Route::post('payments', [App\Http\Controllers\Waiter\PaymentController::class, 'store'])
            ->name('payments.store');
    });