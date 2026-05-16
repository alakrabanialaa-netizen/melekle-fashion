<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\CashController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', [IndexController::class, 'Index'])->name('welcome');
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
}); 

require __DIR__.'/auth.php';

// مجموعة مسارات الآدمن المحمية
Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    
    // نقل مسارات إدارة المنتجات إلى داخل المجموعة لحمايتها والتعرف عليها فوراً
    Route::get('/admin/products', [IndexController::class, 'Index'])->name('products.index');
    Route::get('/admin/products/create', [IndexController::class, 'Index'])->name('products.create');
    Route::post('/admin/products/store', [IndexController::class, 'Index'])->name('products.store');
});

Route::middleware(['auth', 'role:vendor'])->group(function() {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
});

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
Route::get('/vendor/details/{id}', [IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all', [IndexController::class, 'VendorAll'])->name('vendor.all');
Route::get('/product/category/{id}/{slug}', [IndexController::class, 'CatWiseProduct']);
Route::get('/product/subcategory/{id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);

// مسارات أقسام المتجر
Route::get('/category/boys', [IndexController::class, 'CatWiseProduct'])->name('category.boys');
Route::get('/category/girls', [IndexController::class, 'CatWiseProduct'])->name('category.girls');
Route::get('/category/babies', [IndexController::class, 'CatWiseProduct'])->name('category.babies');
Route::get('/category/mothers', [IndexController::class, 'CatWiseProduct'])->name('category.mothers');

// مسارات الصفحات التعريفية وسياسات الموقع
Route::get('/contact', function() { return view('contact'); })->name('contact');
Route::get('/privacy-policy', function() { return view('privacy-policy'); })->name('privacy-policy');
Route::get('/refund-policy', function() { return view('refund-policy'); })->name('refund-policy');
Route::get('/about', [IndexController::class, 'Index'])->name('about');

Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishlist']);
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);

Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);
Route::get('/checkout', [CheckoutController::class, 'CheckoutCreate'])->name('checkout');
Route::get('/mycart', [CartController::class, 'MyCart'])->name('mycart');
Route::get('/get-cart-product', [CartController::class, 'GetCartProduct']);
Route::get('/cart-remove/{rowId}', [CartController::class, 'CartRemove']);
Route::get('/cart-increment/{rowId}', [CartController::class, 'CartIncrement']);
Route::get('/cart-decrement/{rowId}', [CartController::class, 'CartDecrement']);

Route::get('/blog', [IndexController::class, 'AllBlog'])->name('home.blog');
Route::get('/post/details/{id}/{slug}', [IndexController::class, 'BlogDetails']);
Route::get('/post/category/{id}/{slug}', [IndexController::class, 'BlogPostCategory']);
Route::post('/store/review', [ReviewController::class, 'StoreReview'])->name('store.review');
Route::post('/search', [IndexController::class, 'ProductSearch'])->name('product.search');
Route::post('/search-product', [IndexController::class, 'SearchProduct']);
Route::get('/shop', [IndexController::class, 'ShopPage'])->name('shop.page');
Route::post('/shop/filter', [IndexController::class, 'ShopFilter'])->name('shop.filter');

// تحويلات الروابط التلقائية الذكية لمنع الـ 404 بعد تسجيل الدخول
Route::redirect('/home', '/admin/dashboard');
Route::redirect('/admin', '/admin/dashboard');

// رابط تنظيف الكاش (بدون عمل migrate:fresh لكي لا يتم مسح الحساب الحين)
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return "✅ تم تنظيف كاش الـ Routes بنجاح! ارجع للوحة التحكم الآن.";
});

Route::get('/setup-project', function () {
    try {
        Artisan::call('optimize:clear');
        DB::statement("SET session_replication_role = 'replica';");
        Artisan::call('migrate:fresh', ['--force' => true]);
        DB::statement("SET session_replication_role = 'origin';");
        return "✅ مبروك يا بطل! تم مسح الجداول القديمة وإعادة بناء كل شيء بنجاح ونظافة لمتجر Melekler Fashion. ادخل للموقع الآن!";
    } catch (\Exception $e) {
        return "❌ حدث خطأ أثناء البناء: " . $e->getMessage();
    }
});
