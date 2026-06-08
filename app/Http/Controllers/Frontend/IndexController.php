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
    // جلب الأقسام المرتبة، وداخل كل قسم نطلب من قاعدة البيانات جلب 3 منتجات فقط مع صورها
    $categories = Category::orderBy('category_name', 'ASC')->with(['products' => function($query) {
        $query->where('status', 1)->with('images')->latest()->take(3);
    }])->get();

    // نرسل الأقسام بمنتجاتها المحملة مسبقاً إلى صفحة welcome
    return view('welcome', compact('categories')); 
}
    public function CategoryPage($id)
{
    // جلب بيانات القسم المحدد
    $category = Category::findOrFail($id);
    
    // جلب كافة المنتجات التي تنتمي لهذا القسم حصراً مع ترقيم الصفحات (مثلاً 12 منتج في الصفحة)
    $products = Product::where('category', $category->category_name)
                       ->where('status', 1)
                       ->with('images')
                       ->latest()
                       ->paginate(12);

    return view('frontend.shop.category', compact('category', 'products'));
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
