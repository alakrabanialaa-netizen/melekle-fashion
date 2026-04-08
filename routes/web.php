<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes - Melekler Fashion Project
|--------------------------------------------------------------------------
*/

// --- الصفحة الرئيسية ---
Route::get('/', function () {
    $products = Product::latest()->take(8)->get();
    return view('welcome', compact('products'));
})->name('welcome');

// --- واجهة المتجر (Frontend) ---
Route::get('/shop', [ShopController::class, 'index'])->name('products.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('product.show');
Route::get('/product/{id}', [ShopController::class, 'show'])->name('products.show');

Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/privacy-policy', function () { return view('privacy-policy'); })->name('privacy.policy');
Route::get('/refund-policy', function () { return view('refund-policy'); })->name('refund.policy');

// --- السلة ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// --- الأقسام (Categories) ---
Route::prefix('categories')->group(function () {
    Route::get('/babies', function () {
        $products = Product::where('category', 'babies')->latest()->get();
        return view('categories.babies', compact('products'));
    })->name('category.babies');

    Route::get('/girls', function () {
        $products = Product::where('category', 'girls')->latest()->get();
        return view('categories.girls', compact('products'));
    })->name('category.girls');

    Route::get('/boys', function () {
        $products = Product::where('category', 'boys')->latest()->get();
        return view('categories.boys', compact('products'));
    })->name('category.boys');

    Route::get('/mothers', function () {
        $products = Product::where('category', 'mothers')->latest()->get();
        return view('categories.mothers', compact('products'));
    })->name('category.mothers');
});

// --- السلة والدفع والملف الشخصي (تتطلب تسجيل دخول) ---
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- لوحة التحكم (Admin Panel) ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // إدارة المنتجات
    Route::resource('products', AdminProductController::class)->names('admin.products');

    // إدارة الطلبيات
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

    // إدارة المستخدمين والعملاء
    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('clients', ClientController::class)->names('admin.clients');

    // المحاسبة والمصاريف
    Route::get('/accounting', [AccountingController::class, 'index'])->name('admin.accounting.index');
    Route::resource('expenses', ExpenseController::class)->names('admin.expenses');

    // تغيير اللغة
    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['ar', 'en', 'tr'])) {
            session()->put('locale', $locale);
        }
Route::get('/check-admin', function () {
    $user = User::first(); // سيجلب أول مستخدم (الأدمن)
    if ($user) {
        $user->password = Hash::make('12345678'); // سيغير كلمة المرور لـ 12345678
        $user->save();
        return 'إيميل الأدمن هو: ' . $user->email . ' | تم تغيير كلمة المرور لـ 12345678';
    }
    return 'لا يوجد مستخدمين في قاعدة البيانات حالياً!';
});
        });
require __DIR__.'/auth.php';
