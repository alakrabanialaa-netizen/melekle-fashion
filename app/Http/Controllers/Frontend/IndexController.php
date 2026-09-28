<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class IndexController extends Controller
{
    /**
     * المنتجات التي تظهر في قسم الإطلالة المميزة.
     * إبقاء الاستعلام هنا أفضل من وضعه داخل ملف Blade.
     */
    private function getPremiumProducts()
    {
        return Product::with('images')
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();
    }

    public function Index()
    {
        // 1. جلب كافة الأقسام
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // 2. ربط صريح لكل قسم بـ 3 منتجات فقط تطابقه نصياً من قاعدة البيانات
        foreach ($categories as $category) {
            $productsForCategory = Product::where('category', $category->category_name)
                ->where('status', 1)
                ->with('images')
                ->latest()
                ->take(3)
                ->get();

            // ندمج المنتجات الثلاثة داخل كائن القسم نفسه باسم علاقة ديناميكية
            $category->setRelation('my_custom_products', $productsForCategory);
        }

        // 3. منتجات قسم الإطلالة المميزة
        $premiumProducts = $this->getPremiumProducts();

        // نرسل الأقسام والمنتجات إلى الصفحة الرئيسية
        return view('welcome', compact('categories', 'premiumProducts'));
    }

    public function ProductDetails($id, $slug = null)
    {
        $product = Product::findOrFail($id);

        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $id)
            ->where('status', 1)
            ->limit(4)
            ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }

    public function VendorDetails($id)
    {
        return redirect()->to('/');
    }

    public function VendorAll()
    {
        return redirect()->to('/');
    }

    public function ProductSearch(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->where('status', 1)
            ->get();

        // welcome يستعمل قسم Premium أيضاً عند الرجوع من البحث
        $premiumProducts = $this->getPremiumProducts();

        return view('welcome', compact('products', 'premiumProducts'));
    }
}
