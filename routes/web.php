<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\ReviewController;

// استدعاء ملفات الإدارة من مجلد Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SaleController;

use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\RedirectIfAuthenticated;

// استدعاء الكنترولرات الخاصة بالسلة والأقسام
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoryController; // ✅ تم إضافة استدعاء CategoryController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== 1. الصفحة الرئيسية والـ Guest والروابط العامة ====================
Route::get('/', [IndexController::class, 'Index'])->name('welcome');

// روابط الصفحات الثابتة لمنع الـ RouteNotFoundException
Route::get('/contact', function() { return view('contact'); })->name('contact');
Route::get('/privacy-policy', function() { return view('privacy-policy'); })->name('privacy-policy');
Route::get('/refund-policy', function() { return view('refund-policy'); })->name('refund-policy');
Route::get('/about', [IndexController::class, 'Index'])->name('about');

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
    
    // 🛍️ 1️⃣ قسم المنتجات الأساسي (products)
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    
    Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/update/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    
    Route::get('/admin/products-fix', [ProductController::class, 'index'])->name('products.index'); 
    Route::get('/admin/products/create-fix', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products/store-fix', [ProductController::class, 'store'])->name('products.store');

    // 📦 2️⃣ قسم الطلبات (orders)
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/pending', [OrderController::class, 'index'])->name('admin.orders.pending');
    Route::get('/admin/orders/delivered', [OrderController::class, 'index'])->name('admin.orders.delivered');
    Route::get('/admin/orders/show/{id}', [OrderController::class, 'show'])->name('admin.orders.show');

    // 👥 3️⃣ قسم العملاء (clients)
    Route::get('/admin/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::get('/admin/clients/create', [ClientController::class, 'create'])->name('admin.clients.create');
    Route::get('/admin/clients-fix', [ClientController::class, 'index'])->name('clients.index'); 

    // 👥 4️⃣ قسم المستخدمين والآدمنية (تم توجيهه للمستودع في مجلد users)
    Route::get('/admin/users', [ProductController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/fix', [ProductController::class, 'index'])->name('users.index'); 

    // 📊 5️⃣ قسم المحاسبة والمستودع المطور الحركي (accounting)
    Route::get('/admin/accounting', [AccountingController::class, 'index'])->name('admin.accounting.index');
    Route::get('/admin/accounting/fix', [AccountingController::class, 'index'])->name('accounting.index'); 

    Route::match(['POST', 'PUT'], '/admin/warehouse/update/{id}', [AccountingController::class, 'updateProduct'])->name('admin.warehouse.update');
    Route::post('/admin/accounting/product/update/{id}', [AccountingController::class, 'updateProduct'])->name('admin.accounting.product.update');

    Route::post('/admin/sales/store', [SaleController::class, 'store'])->name('admin.sales.store');

    Route::post('/admin/expenses/store', [AccountingController::class, 'storeExpense'])->name('admin.expenses.store');
    Route::post('/admin/accounting/expense/update/{id}', [AccountingController::class, 'updateExpense'])->name('admin.accounting.expense.update');
    Route::delete('/admin/accounting/expense/delete/{id}', [AccountingController::class, 'destroyExpense'])->name('admin.accounting.expense.destroy');

    Route::post('/admin/accounting/capital', [AccountingController::class, 'storeCapital']);
    Route::delete('/admin/accounting/capital/{id}', [AccountingController::class, 'destroyCapital']);

    // 💰 6️⃣ قسم المصاريف القديم الاحتياطي (expenses)
    Route::get('/admin/expenses', [ExpenseController::class, 'index'])->name('admin.expenses.index');
    Route::post('/admin/expenses', [ExpenseController::class, 'store'])->name('admin.expenses.store_old');
    Route::delete('/admin/expenses/{id}', [ExpenseController::class, 'destroy'])->name('admin.expenses.destroy_old');

    // مسارات إضافية احتياطية للموقع
    Route::get('/admin/settings/site', [AdminDashboardController::class, 'index'])->name('admin.settings.index');
    Route::get('/admin/reports/all', [AdminDashboardController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reviews/all', [AdminDashboardController::class, 'index'])->name('admin.reviews.index');
    Route::get('/admin/return/requests', [AdminDashboardController::class, 'index'])->name('admin.return.index');
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

// ==================== 6. تفاصيل المنتجات والتنقل والأقسام الديناميكية الذكية ====================

// روت العروض والأقسام الثابتة لتفادي الـ 404
Route::get('/category/offers', [ProductController::class, 'getOffers'])->name('category.offers');

// ✅ تم تعديل هذه الروابط لترتبط بالـ CategoryController مباشرة
Route::get('/category/boys', [CategoryController::class, 'boys'])->name('category.boys');
Route::get('/category/girls', [CategoryController::class, 'girls'])->name('category.girls');
Route::get('/category/babies', [CategoryController::class, 'babies'])->name('category.babies');
Route::get('/category/mothers', [CategoryController::class, 'mothers'])->name('category.mothers');

// الروت الديناميكي أسفل المسارات الثابتة
Route::get('/category/{category}', [ShopController::class, 'category'])->name('category.show');

Route::get('/product/details/{id}/{slug?}', [IndexController::class, 'ProductDetails'])->name('product.show');
Route::get('/product/info/{id}/{slug?}', [IndexController::class, 'ProductDetails'])->name('frontend.products.show');
Route::get('/vendor/details/{id}', [IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all', [IndexController::class, 'VendorAll'])->name('vendor.all');

// ==================== 7. أجاكس السلة، المقارنة، وقائمة الأمنيات ====================
Route::get('/mycart', [CartController::class, 'MyCart'])->name('mycart');
Route::post('/admin/products/{id}/update-stock', [App\Http\Controllers\Admin\ProductController::class, 'updateStock']);
Route::post('/cart/data/store/{id}', [CartController::class, 'add'])->name('cart.add');
Route::any('/cart-add/{id}', [CartController::class, 'add']);
Route::get('/cart-remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishlist']);
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);

Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);

Route::get('/checkout', [CheckoutController::class, 'CheckoutCreate'])->name('checkout');
Route::get('/get-cart-product', [CartController::class, 'GetCartProduct']);
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

// ==================== 10. الرابط السحري المطور وتنظيف الكاش ====================
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return "✅ تم تنظيف كاش الموقع بنجاح، وتثبيت كافة الروابط والمسارات الجديدة محاسبياً!";
});
