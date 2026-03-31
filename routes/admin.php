<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
Route::get('/admin/orders', [AdminOrderController::class,'index'])->name('admin.orders');
