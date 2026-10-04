<?php

use App\Http\Controllers\WholesaleAccessController;
use Illuminate\Support\Facades\Route;

Route::get('/wholesale/login', [WholesaleAccessController::class, 'loginForm'])->name('wholesale.login');
Route::post('/wholesale/login', [WholesaleAccessController::class, 'login'])->middleware('throttle:5,1')->name('wholesale.login.submit');
Route::post('/wholesale/logout', [WholesaleAccessController::class, 'logout'])->name('wholesale.logout');

Route::middleware('wholesale.access')->prefix('wholesale')->name('wholesale.')->group(function () {
    Route::get('/catalog', [WholesaleAccessController::class, 'catalog'])->name('catalog');
});

// استبدل middleware admin باسم حماية المدير الموجود فعلياً في مشروعك إن كان مختلفاً.
Route::middleware(['auth', 'admin'])->prefix('admin/wholesale')->name('admin.wholesale.')->group(function () {
    Route::get('/codes', [WholesaleAccessController::class, 'adminIndex'])->name('codes.index');
    Route::post('/codes', [WholesaleAccessController::class, 'adminStore'])->name('codes.store');
    Route::patch('/codes/{wholesaleAccessCode}/toggle', [WholesaleAccessController::class, 'adminToggle'])->name('codes.toggle');
});
