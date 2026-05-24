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
    // 1. جلب تفاصيل المنتج الأساسي باستخدام الـ id
    $product = Product::findOrFail($id);
    
    // 2. جلب منتجات ذات صلة (تم تعديل حقل البحث من category_id إلى category ليطابق الـ Supabase عندك)
    $relatedProducts = Product::where('category', $product->category) // تعديل هنا وعلاوة على السطر التالي
                              ->where('id', '!=', $id)
                              ->where('status', 1)
                              ->limit(4)
                              ->get();

    // 3. تمرير المنتج والمنتجات ذات الصلة لصفحة التفاصيل بسلام
// التعديل الصحيح ليطابق مجلدات مشروعك الحالية
return view('frontend.shop.show', compact('product', 'relatedProducts'));}
}
