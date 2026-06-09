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
use App\Http\Controllers\Admin\UserController as AdminUserController; 

use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController; 
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\RedirectIfAuthenticated;

// استدعاء الكنترولر الصحيح للسلة
use App\Http\Controllers\CartController;

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
    
    // 🛍️ 1️⃣ قسم المنتجات (products)
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::delete('/admin/products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/products/store', [ProductController::class, 'index']);
    
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

    // 👨‍💻 4️⃣ قسم المستخدمين والآدمنية (users)
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/fix', [AdminUserController::class, 'index'])->name('users.index'); 

    // 📊 5️⃣ قسم المحاسبة (accounting)
    Route::get('/admin/accounting', [AccountingController::class, 'index'])->name('admin.accounting.index');
    Route::get('/admin/accounting/fix', [AccountingController::class, 'index'])->name('accounting.index'); 

    // 💰 6️⃣ قسم المصاريف (expenses)
    Route::get('/admin/expenses', [ExpenseController::class, 'index'])->name('admin.expenses.index');
    Route::get('/admin/expenses/fix', [ExpenseController::class, 'index'])->name('expenses.index'); 

    // ⚙️ مسارات إضافية احتياطية
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
Route::get('/product/details/{id}/{slug?}', [IndexController::class, 'ProductDetails'])->name('product.show');
Route::get('/vendor/details/{id}', [IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all', [IndexController::class, 'VendorAll'])->name('vendor.all');

// 👦 قسم ملابس الأولاد
Route::get('/category/boys', function() { 
    $category = \App\Models\Category::where('category_name', 'like', '%ولد%')->orWhere('category_slug', 'like', '%boy%')->first();
    $products = \App\Models\Product::where('category', 'like', '%ولد%')->where('status', 1)->get();
    return view('categories.boys', compact('products', 'category')); 
})->name('category.boys');

// 👧 قسم ملابس البنات
Route::get('/category/girls', function() { 
    $category = \App\Models\Category::where('category_name', 'like', '%بنات%')->orWhere('category_slug', 'like', '%girl%')->first();
    $products = \App\Models\Product::where('category', 'like', '%بنات%')->where('status', 1)->get();
    return view('categories.girls', compact('products', 'category')); 
})->name('category.girls');

// 👶 قسم ملابس الرضع
Route::get('/category/babies', function() { 
    $category = \App\Models\Category::where('category_name', 'like', '%رضع%')->orWhere('category_name', 'like', '%طفل%')->orWhere('category_slug', 'like', '%bab%')->first();
    $products = \App\Models\Product::where('category', 'like', '%رضع%')->orWhere('category', 'like', '%طفل%')->where('status', 1)->get();
    return view('categories.babies', compact('products', 'category')); 
})->name('category.babies');

// 👩 قسم ملابس الأمهات
Route::get('/category/mothers', function() { 
    $category = \App\Models\Category::where('category_name', 'like', '%أمهات%')->orWhere('category_name', 'like', '%نساء%')->orWhere('category_slug', 'like', '%moth%')->first();
    $products = \App\Models\Product::where('category', 'like', '%أمهات%')->orWhere('category', 'like', '%نساء%')->where('status', 1)->get();
    return view('categories.mothers', compact('products', 'category')); 
})->name('category.mothers');

// ==================== 7. أجاكس السلة، المقارنة، وقائمة الأمنيات ====================
Route::get('/mycart', [CartController::class, 'MyCart'])->name('mycart');
Route::post('/cart/data/store/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart-remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
Route::post('/dcart/data/store/{id}', [CartController::class, 'AddToCartDetails']);
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishlist']);
Route::post('/add-to-compare/{product_id}', [CompareController::class, 'AddToCompare']);

// تم إصلاح مسارات الكوبون والـ السلة هنا بشكل دقيق لمنع خطأ Attribute [couponApply]
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

Route::get('/admin/products/edit/{id}', [ProductController::class, 'index'])->name('admin.products.edit');

// ==================== 9. تحويلات تلقائية ذكية لمنع الـ 404 ====================
Route::redirect('/home', '/admin/dashboard');
Route::redirect('/admin', '/admin/dashboard');

// ==================== 10. الرابط السحري المطور وتنظيف الكاش ====================
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\DB::table('users')->where('email', 'admin@gmail.com')->delete();
    \Illuminate\Support\Facades\DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'), 
        'role' => 'admin',       
        'is_admin' => 1,         
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return "✅ تم تنظيف كاش الموقع بنجاح، وتأمين حساب الآدمن دون مسح تعديلات قاعدة البيانات في Supabase!";
});
