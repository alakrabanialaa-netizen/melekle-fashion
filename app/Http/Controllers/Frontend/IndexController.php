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
        // 1. جلب كافة الأقسام الفعالة من قاعدة البيانات
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // 2. جلب آخر 3 منتجات لكل قسم بشكل نصي مباشر وصريح لتفادي أي عطل في ربط الموديلات
        foreach ($categories as $category) {
            $productsForCategory = Product::where('category', $category->category_name)
                                          ->where('status', 1)
                                          ->with('images')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            
            // نربط المنتجات المجلوبة بالقسم ديناميكياً ليقرأها ملف الـ Blade بسلام
            $category->setRelation('products', $productsForCategory);
        }
        
        return view('welcome', compact('categories')); 
    }

    public function CategoryPage($slug_or_id)
    {
        // البحث عن القسم: إما بالـ ID الرقمي أو بكلمة مقتطعة من السلوج لمنع انهيار الـ SQL
        if (is_numeric($slug_or_id)) {
            $category = Category::findOrFail($slug_or_id);
        } else {
            $category = Category::where('category_slug', 'like', '%' . $slug_or_id . '%')
                                ->orWhere('category_name', 'like', '%' . $slug_or_id . '%')
                                ->firstOrFail();
        }
        
        // جلب كافة منتجات القسم مع تقسيم الصفحات بدقة
        $products = Product::where('category', $category->category_name)
                           ->where('status', 1)
                           ->with('images')
                           ->latest()
                           ->paginate(12);

        return view('frontend.shop.category', compact('category', 'products'));
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
