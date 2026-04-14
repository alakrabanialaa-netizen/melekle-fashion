<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Schema;

// 1. المسار الرئيسي مع إصلاح الجداول وتوجيه المسؤول تلقائياً
Route::get('/', function () {
    try {
        if (!Schema::hasTable('users')) {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'UsersTableSeeder', '--force' => true]);
        }
        
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect('/admin/dashboard');
        }

        $products = \App\Models\Product::all() ?? collect();
        return view('welcome', compact('products'));
    } catch (\Exception $e) {
        return view('welcome', ['products' => collect()]);
    }
})->name('welcome');

// 2. تعريف كافة مسارات الأقسام (لحل أخطاء Route not defined)
Route::get('/category/boys', function() { return view('categories.boys'); })->name('category.boys');
Route::get('/category/girls', function() { return view('categories.girls'); })->name('category.girls');
Route::get('/category/babies', function() { return view('categories.babies'); })->name('category.babies');
Route::get('/category/mothers', function() { return view('categories.mothers'); })->name('category.mothers');
Route::get('/category/accessories', function() { return view('categories.accessories'); })->name('category.accessories');
Route::get('/offers', function() { return view('offers'); })->name('offers');
Route::get('/search', function() { return view('search'); })->name('search');

// 3. توجيه تلقائي من /admin إلى لوحة التحكم
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
})->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. مسارات المسؤول (Admin Routes)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
