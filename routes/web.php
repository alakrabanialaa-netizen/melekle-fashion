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
use App\Http\Controllers\AdminController; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== 1. الصفحة الرئيسية والـ Guest ====================
Route::get('/', [IndexController::class, 'Index'])->name('welcome');

// ==================== 2. مسارات المستخدم العادي (User Dashboard) ====================
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
}); 

require __DIR__.'/auth.php';

// ==================== 3. مجموعة مسارات الآدمن المحمية والشاملة للمشروع ====================
Route::middleware(['auth', 'role:admin'])->group(function() {
    
    // لوحة التحكم والملف الشخصي للآدمن
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    
    // 🛍️ قسم المنتجات (products)
    Route::get('/admin/products', [IndexController::class, 'Index'])->name('admin.products.index');
    Route::get('/admin/products/create', [IndexController::class, 'Index'])->name('admin.products.create');
    Route::post('/admin/products/store', [IndexController::class, 'Index'])->name('admin.products.store');
    Route::get('/admin/products-fix', [IndexController::class, 'Index'])->name('products.index'); 
    Route::get('/admin/products/create-fix', [IndexController::class, 'Index'])->name('products.create');
    Route::post('/admin/products/store-fix', [IndexController::class, 'Index'])->name('products.store');

    // 📦 قسم الطلبات (orders)
    Route::get('/admin/orders', [OrderController::class, 'AdminPlacedOrder'])->name('admin.orders.index');
    Route::get('/admin/orders/pending', [OrderController::class, 'AdminPendingOrder'])->name('admin.orders.pending');
    Route::get('/admin/orders/delivered', [OrderController::class, 'AdminDeliveredOrder'])->name('admin.orders.delivered');
    Route::get('/admin/orders/show/{id}', [OrderController::class, 'AdminOrderDetails'])->name('admin.orders.show');

    // 👥 قسم العملاء (clients)
    Route::get('/admin/clients', [UserController::class, 'UserDashboard'])->name('admin.clients.index');
    Route::get('/admin/clients/create', [UserController::class, 'UserDashboard'])->name('admin.clients.create');
    Route::get('/admin/clients-fix', [UserController::class, 'UserDashboard'])->name('clients.index'); 

    // 👨‍💻 قسم المستخدمين والآدمنية (users)
    Route::get('/admin/users', [ActiveUserController::class, 'AllUser'])->name('admin.users.index');
    Route::get('/admin/users/fix', [ActiveUserController::class, 'AllUser'])->name('users.index'); 

    // 📊 قسم المحاسبة (accounting)
    Route::get('/admin/accounting', [ReportController::class, 'AllReport'])->name('admin.accounting.index');
    Route::get('/admin/accounting/fix', [ReportController::class, 'AllReport'])->name('accounting.index'); 

    // 💰 قسم المصاريف (expenses)
    Route::get('/admin/expenses', [ReportController::class, 'AllReport'])->name('admin.expenses.index');
    Route::get('/admin/expenses/fix', [ReportController::class, 'AllReport'])->name('expenses.index'); 

    // ⚙️ إعدادات النظام الإضافية
    Route::get('/admin/settings/site', [SiteSettingController::class, 'SiteSetting'])->name('admin.settings.index');
    Route::get('/admin/reports/all', [ReportController::class, 'AllReport'])->name('admin.reports.index');
    Route::get('/admin/reviews/all', [ReviewController::class, 'AllReview'])->name('admin.reviews.index');
    Route::get('/admin/return/requests', [ReturnController::class, 'ReturnRequest'])->name('admin.return.index');
}); 

// ==================== 4. مجموعة مسارات الـ Vendor ====================
Route::middleware(['auth', 'role:vendor'])->group(function() {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
});

// ==================== 5. مسارات تسجيل الدخول العامة والتسجيل للـ Vendor ====================
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

// ==================== 6. تفاصيل المنتجات والتنقل والأقسام ====================
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
Route::get('/vendor/details/{id}', [IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all', [IndexController::class, 'VendorAll'])->name('vendor.all');
Route::get('/product/category/{id}/{slug}', [IndexController::class, 'CatWiseProduct']);
Route::get('/product/subcategory/{id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);

// مسارات أقسام المتجر (الأولاد، البنات، المواليد، الأمهات)
Route::get('/category/boys', [IndexController::class, 'CatWiseProduct'])->name('category.boys');
Route::get('/category/girls', [IndexController::class, 'CatWiseProduct'])->name('category.girls');
Route::get('/category/babies', [IndexController::class, 'CatWiseProduct'])->name('category.babies');
Route::get('/category/mothers', [IndexController::class, 'CatWiseProduct'])->name('category.mothers');

// صفحات التعريف وسياسات الموقع
Route::get('/contact', function() { return view('contact'); })->name('contact');
Route::get('/privacy-policy', function() { return view('privacy-policy'); })->name('privacy-policy');
Route::get('/refund-policy', function() { return view('refund-policy'); })->name('refund-policy');
Route::get('/about', [IndexController::class, 'Index'])->name('about');

// ==================== 7. أجاكس السلة، المقارنة، وقائمة الأمنيات ====================
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishlist']);
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);

// الكوبونات، عربة التسوق والـ Checkout
Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);
Route::get('/checkout', [CheckoutController::class, 'CheckoutCreate'])->name('checkout');
Route::get('/mycart', [CartController::class, 'MyCart'])->name('mycart');
Route::get('/get-cart-product', [CartController::class, 'GetCartProduct']);
Route::get('/cart-remove/{rowId}', [CartController::class, 'CartRemove']);
Route::get('/cart-increment/{rowId}', [CartController::class, 'CartIncrement']);
Route::get('/cart-decrement/{rowId}', [CartController::class, 'CartDecrement']);

// ==================== 8. المدونة، المراجعات، البحث والفلترة ====================
Route::get('/blog', [IndexController::class, 'AllBlog'])->name('home.blog');
Route::get('/post/details/{id}/{slug}', [IndexController::class, 'BlogDetails']);
Route::get('/post/category/{id}/{slug}', [IndexController::class, 'BlogPostCategory']);
Route::post('/store/review', [ReviewController::class, 'StoreReview'])->name('store.review');
Route::post('/search', [IndexController::class, 'ProductSearch'])->name('product.search');
Route::post('/search-product', [IndexController::class, 'SearchProduct']);
Route::get('/shop', [IndexController::class, 'ShopPage'])->name('shop.page');
Route::post('/shop/filter', [IndexController::class, 'ShopFilter'])->name('shop.filter');

// ==================== 9. تحويلات تلقائية ذكية لمنع الـ 404 ====================
Route::redirect('/home', '/admin/dashboard');
Route::redirect('/admin', '/admin/dashboard');

// ==================== 10. الرابط السحري المطور (تنظيف الكاش وزرع الآدمن) ====================
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    
    // 1. مسح أي مستخدم قديم بنفس الإيميل لمنع التضارب
    \Illuminate\Support\Facades\DB::table('users')->where('email', 'admin@gmail.com')->delete();
    
    // 2. إنشاء حساب الآدمن بكافة الحقول المدعومة (role و is_admin)
    \Illuminate\Support\Facades\DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'), 
        'role' => 'admin',       
        'is_admin' => 1,         
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return "✅ تم تنظيف الكاش بنجاح وزرع حساب الآدمن الخارق الشامل لكافة الصلاحيات! توجه مجدداً للوحة التحكم وسجل دخولك بريد: admin@gmail.com وباسورد: password";
});
