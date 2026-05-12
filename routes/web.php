<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master Data: owner, manager, supervisor
    Route::middleware('role:owner,manager,supervisor')->prefix('master')->name('master.')->group(function () {
        Route::get('/categories', fn () => view('master.categories.index'))->name('categories.index');
        Route::get('/categories/create', fn () => view('master.categories.form'))->name('categories.create');
        Route::get('/categories/{category}/edit', fn () => view('master.categories.form'))->name('categories.edit');

        Route::get('/products', fn () => view('master.products.index'))->name('products.index');
        Route::get('/products/create', fn () => view('master.products.form'))->name('products.create');
        Route::get('/products/{product}/edit', fn () => view('master.products.form'))->name('products.edit');

        Route::get('/suppliers', fn () => view('master.suppliers.index'))->name('suppliers.index');
        Route::get('/suppliers/create', fn () => view('master.suppliers.form'))->name('suppliers.create');
        Route::get('/suppliers/{supplier}/edit', fn () => view('master.suppliers.form'))->name('suppliers.edit');
    });

    // Branches: owner, manager
    Route::middleware('role:owner,manager')->prefix('branches')->name('branches.')->group(function () {
        Route::get('/', fn () => view('branches.index'))->name('index');
        Route::get('/create', fn () => view('branches.form'))->name('create');
        Route::get('/{branch}', fn () => view('branches.show'))->name('show');
        Route::get('/{branch}/edit', fn () => view('branches.form'))->name('edit');
    });

    // Users: owner only
    Route::middleware('role:owner')->prefix('users')->name('users.')->group(function () {
        Route::get('/', fn () => view('users.index'))->name('index');
        Route::get('/create', fn () => view('users.form'))->name('create');
        Route::get('/{user}/edit', fn () => view('users.form'))->name('edit');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        // Transaction history: owner, manager, supervisor
        Route::middleware('role:owner,manager,supervisor')->get('/', fn () => view('transactions.index'))->name('index');
        // POS: owner, manager, cashier
        Route::middleware('role:owner,manager,cashier')->get('/pos', fn () => view('transactions.pos'))->name('pos');
    });

    // Inventory: owner, manager, warehouse
    Route::middleware('role:owner,manager,warehouse')->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', fn () => view('inventory.index'))->name('index');
        Route::get('/stock-opname', fn () => view('inventory.stock-opname'))->name('stock-opname');
    });

    // Reports: owner, manager, supervisor
    Route::middleware('role:owner,manager,supervisor')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', fn () => view('reports.index'))->name('index');
        Route::get('/sales', fn () => view('reports.sales'))->name('sales');
        Route::get('/stock', fn () => view('reports.stock'))->name('stock');
    });
});

require __DIR__.'/auth.php';
