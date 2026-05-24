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
        // جلب آخر 8 منتجات من قاعدة البيانات لمتجر Melekler Fashion
        $products = Product::where('status', 1)->latest()->limit(8)->get();
        
        // جلب التصنيفات المرتبطة
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // إرسال المتغيرات إلى صفحة welcome الحالية
        return view('welcome', compact('products', 'categories')); 
    }

    public function ProductDetails($id, $slug = null) 
    {
        // 1. جلب تفاصيل المنتج الأساسي باستخدام الـ id مع الصور الخاصة به
        $product = Product::findOrFail($id);
        
        // 2. جلب منتجات ذات صلة من نفس القسم (ما عدا المنتج الحالي) لعرضها في الأسفل
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $id)
                                  ->where('status', 1)
                                  ->limit(4)
                                  ->get();

        // 3. تمرير المنتج والمنتجات ذات الصلة لصفحة التفاصيل بسلام
        return view('frontend.product.product_details', compact('product', 'relatedProducts'));
    }
}
