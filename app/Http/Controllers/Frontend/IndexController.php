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
        // 1. جلب كافة الأقسام مرتبة أبجدياً
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // 2. ربط صريح لكل قسم بمنتجاته بناءً على الاسم النصي المطابق في قاعدة البيانات
        foreach ($categories as $category) {
            $productsForCategory = Product::where('category', $category->category_name)
                                          ->where('status', 1)
                                          ->with('images')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            
            // ربط المنتجات بالقسم ليقرأها ملف الـ welcome.blade.php
            $category->setRelation('products', $productsForCategory);
        }
        
        return view('welcome', compact('categories')); 
    }

    // 🛍️ دالة تفاصيل المنتج (ضرورية جداً لأن الـ web.php يستدعيها)
    public function ProductDetails($id, $slug = null) 
    {
        $product = Product::findOrFail($id);
        
        // جلب منتجات ذات صلة من نفس القسم كإجراء جمالي للمتجر
        $relatedProducts = Product::where('category', $product->category)
                                  ->where('id', '!=', $id)
                                  ->where('status', 1)
                                  ->limit(4)
                                  ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }

    // 🏪 دالات إضافية احتياطية منعاً لأي تضارب في روابط المتجر المستدوعة
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
        $products = Product::where('name', 'like', '%'.$search.'%')->where('status', 1)->get();
        return view('welcome', compact('products'));
    }
}
