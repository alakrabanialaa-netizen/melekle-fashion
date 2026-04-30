<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AccountingController;
use Illuminate\Database\Schema\Blueprint;

// 1. المسار الرئيسي: الإصلاح التلقائي الشامل وعرض الصفحة الرئيسية
Route::get('/', function () {
    try {
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'slug')) $table->string('slug')->unique()->nullable();
                if (!Schema::hasColumn('products', 'category')) $table->string('category')->nullable();
                if (!Schema::hasColumn('products', 'name')) $table->string('name')->nullable();
                if (!Schema::hasColumn('products', 'price')) $table->decimal('price', 10, 2)->default(0);
                if (!Schema::hasColumn('products', 'stock')) $table->integer('stock')->default(0);
                if (!Schema::hasColumn('products', 'description')) $table->text('description')->nullable();
                if (!Schema::hasColumn('products', 'video')) $table->string('video')->nullable();
            });
        }

        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->timestamps();
            });
        }

        $products = Schema::hasTable('products') ? \App\Models\Product::with('images')->get() : collect();
        return view('welcome', compact('products'));

    } catch (\Exception $e) {
        return "جاري تهيئة النظام، يرجى التحديث. الخطأ: " . $e->getMessage();
    }
})->name('welcome');

// --- إضافه مسار عرض المنتج لحل مشكلة Route [product.show] ---
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->firstOrFail();
    return "صفحة المنتج: " . $product->name; 
    // ملاحظة: يفضل إنشاء ملف show.blade.php لاحقاً وعرض البيانات فيه
})->name('product.show');


// 2. مسارات الأقسام والصفحات العامة
Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
    Route::get('/mothers', function() { return "قسم الأمهات"; })->name('mothers');
    Route::get('/accessories', function() { return "قسم الإكسسوارات"; })->name('accessories');
});

// باقي المسارات (offers, contact, admin, إلخ...) بنفس الترتيب السابق
// ...
