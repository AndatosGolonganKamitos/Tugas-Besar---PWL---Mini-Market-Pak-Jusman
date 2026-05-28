<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// TODO Backend: Halaman welcome (landing page) — ganti dengan controller jika perlu
Route::get('/', function () {
    return view('welcome');
});

// TODO Backend: Ganti closure ini dengan DashboardController
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile — sudah pakai controller, aman
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', function () {
    return view('notifications');
});

      Route::get('/notifications/read/{id}', function ($id) {

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user) {

        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }
    }

    return redirect('/notifications');
});
    // ============================================================
    // MASTER DATA (Akses: Owner, Manajer, Supervisor)
    // TODO Backend: Buat CategoryController, ProductController, SupplierController
    // TODO Backend: Tambahkan route POST/PUT/DELETE di bawah masing-masing grup
    // TODO Backend: Buat model Category, Product, Supplier + migrasi
    // ============================================================
    Route::middleware('role:owner,manager,supervisor')->prefix('master')->name('master.')->group(function () {
        // Categories
            Route::get('/categories', [CategoryController::class, 'index'])
                ->name('categories.index');
            Route::get('/categories/create', fn () => view('master.categories.form'))
                ->name('categories.create');
            Route::post('/categories', [CategoryController::class, 'store'])
                ->name('categories.store');
            Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
                ->name('categories.edit');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])
                ->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
                ->name('categories.destroy');

        // Products
            Route::get('/products', [ProductController::class, 'index'])
                ->name('products.index');

            Route::get('/products/create', [ProductController::class, 'create'])
                ->name('products.create');

            Route::post('/products', [ProductController::class, 'store'])
                ->name('products.store');

            Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
                ->name('products.edit');

            Route::put('/products/{product}', [ProductController::class, 'update'])
                ->name('products.update');

            Route::delete('/products/{product}', [ProductController::class, 'destroy'])
                ->name('products.destroy');

       // Suppliers
            Route::get('/suppliers', [SupplierController::class, 'index'])
                ->name('suppliers.index');

            Route::get('/suppliers/create', fn () => view('master.suppliers.form'))
                ->name('suppliers.create');

            Route::post('/suppliers', [SupplierController::class, 'store'])
                ->name('suppliers.store');

            Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])
                ->name('suppliers.edit');

            Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])
                ->name('suppliers.update');

            Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
                ->name('suppliers.destroy');
    });

    // ============================================================
    // CABANG (Akses: Owner, Manajer)
    // Model Branch sudah ada + migrasi. TODO Backend: Buat BranchController
    // ============================================================
    Route::middleware('role:owner,manager')->prefix('branches')->name('branches.')->group(function () {
        Route::get('/', fn () => view('branches.index'))->name('index');
        Route::get('/create', fn () => view('branches.form'))->name('create');
        Route::get('/{branch}', fn () => view('branches.show'))->name('show');
        Route::get('/{branch}/edit', fn () => view('branches.form'))->name('edit');
        // TODO Backend: Route::post('/', [BranchController::class, 'store'])->name('store');
        // TODO Backend: Route::put('/{branch}', [BranchController::class, 'update'])->name('update');
        // TODO Backend: Route::delete('/{branch}', [BranchController::class, 'destroy'])->name('destroy');
    });

    // ============================================================
    // PENGGUNA (Akses: Owner only)
    // Model User sudah ada. TODO Backend: Buat UserController
    // ============================================================
    Route::middleware('role:owner')->prefix('users')->name('users.')->group(function () {
        Route::get('/', fn () => view('users.index'))->name('index');
        Route::get('/create', fn () => view('users.form'))->name('create');
        Route::get('/{user}/edit', fn () => view('users.form'))->name('edit');
        // TODO Backend: Route::post('/', [UserController::class, 'store'])->name('store');
        // TODO Backend: Route::put('/{user}', [UserController::class, 'update'])->name('update');
        // TODO Backend: Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // ============================================================
    // TRANSAKSI
    // POS (Akses: Owner, Manajer, Kasir)
    // Riwayat (Akses: Owner, Manajer, Supervisor)
    // TODO Backend: Buat TransactionController, model Transaction + migrasi
    // ============================================================
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::middleware('role:owner,manager,supervisor')->get('/', fn () => view('transactions.index'))->name('index');
        Route::middleware('role:owner,manager,cashier')->get('/pos', fn () => view('transactions.pos'))->name('pos');
        // TODO Backend: Route::post('/pos', [TransactionController::class, 'store'])->name('store');
    });

    // ============================================================
    // INVENTARIS (Akses: Owner, Manajer, Pegawai Gudang)
    // TODO Backend: Buat InventoryController, model Inventory/Stock + migrasi
    // ============================================================
    Route::middleware('role:owner,manager,warehouse')->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', fn () => view('inventory.index'))->name('index');
        Route::get('/stock-opname', fn () => view('inventory.stock-opname'))->name('stock-opname');
        // TODO Backend: Route::post('/stock-opname', [InventoryController::class, 'stockOpname'])->name('stock-opname.store');
    });

    // ============================================================
    // LAPORAN (Akses: Owner, Manajer, Supervisor)
    // TODO Backend: Buat ReportController
    // ============================================================
    Route::middleware('role:owner,manager,supervisor')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', fn () => view('reports.index'))->name('index');
        Route::get('/sales', fn () => view('reports.sales'))->name('sales');
        Route::get('/stock', fn () => view('reports.stock'))->name('stock');
    });

    // Buat notifikasi sederhana untuk testing
    Route::get('/notifications', function () {
    return view('notifications');
    })->middleware('auth');



});

require __DIR__.'/auth.php';
