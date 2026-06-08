<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class IndexController extends Controller
{
    public function Index()
    {
        // 1. جلب كافة الأقسام من قاعدة البيانات
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // 2. جلب المنتجات لكل قسم بشكل يدوي مباشر لضمان ظهورها في الرئيسية 100%
        foreach ($categories as $category) {
            $productsForCategory = Product::where('category', $category->category_name)
                                          ->where('status', 1)
                                          ->with('images')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            
            // نربط المنتجات بالقسم ديناميكياً ليراها ملف الـ welcome
            $category->setRelation('products', $productsForCategory);
        }
        
        // جلب المنتجات العامة كإجراء احتياطي لو احتجتها
        $products = Product::where('status', 1)->with('images')->latest()->get();

        return view('welcome', compact('categories', 'products')); 
    }

    public function CategoryPage($slug_or_id)
    {
        // البحث عن القسم لحل مشكلة السلوج أو الـ ID
        if (is_numeric($slug_or_id)) {
            $category = Category::find($slug_or_id);
        } else {
            $category = Category::where('category_slug', 'like', '%' . $slug_or_id . '%')
                                ->orWhere('category_name', 'like', '%' . $slug_or_id . '%')
                                ->first();
        }

        // إذا لم يجد القسم بأي طريقة، نأخذ أول قسم كاحتياط منعاً للانهيار
        if (!$category) {
            $category = Category::first();
        }
        
        // جلب منتجات هذا القسم
        $products = Product::where('category', $category->category_name)
                           ->where('status', 1)
                           ->with('images')
                           ->latest()
                           ->paginate(12);

        // 🛠️ جرب تغيير المسار هنا بناءً على المجلدات الموجودة عندك في resources/views
        // إذا كان ملف عرض القسم اسمه "boys.blade.php" أو ملف مشترك، تأكد من كتابة اسمه هنا:
        if (view()->exists('categories.category_page')) {
            return view('categories.category_page', compact('category', 'products'));
        } elseif (view()->exists('frontend.shop.category')) {
            return view('frontend.shop.category', compact('category', 'products'));
        } else {
            // كخيار بديل يمنع الـ 404 تماماً، سيعرض المنتجات باستخدام ملف welcome ولكن مصفاة
            return view('welcome', compact('category', 'products', 'categories'));
        }
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
}
