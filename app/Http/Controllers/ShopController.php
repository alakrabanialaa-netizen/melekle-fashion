<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 1. صفحة الصفحة الرئيسية (Welcome)
    public function welcome()
    {
        $products = Product::with('images')->latest()->take(8)->get();
        return view('welcome', compact('products'));
    }

    // 2. صفحة جميع المنتجات (Shop)
    public function index()
    {
        $products = Product::with('images')->latest()->get();
        return view('frontend.shop.index', compact('products'));
    }

    // ⭐ 3. الدالة الجديدة: عرض المنتجات حسب القسم المحدد بعد الإصلاح
// ⭐ 3. الدالة المحدثة: لتتوافق تماماً مع مجلد categories الظاهر في الصورة
public function category($category)
{
    // ربط روابط الـ URL بأسماء ملفات الـ Blade ومصفوفة البحث
    $categoryMap = [
        'boys'    => ['view' => 'categories.boys', 'keywords' => ['%ولد%', '%ولادي%', '%boy%', '%boys%']],
        'girls'   => ['view' => 'categories.girls', 'keywords' => ['%بنات%', '%بناتي%', '%girl%', '%girls%']],
        'babies'  => ['view' => 'categories.babies', 'keywords' => ['%رضع%', '%طفل%', '%أطفال%', '%اطفال%', '%baby%', '%babies%']],
        'mothers' => ['view' => 'categories.mothers', 'keywords' => ['%أمهات%', '%نساء%', '%نسائي%', '%mother%', '%women%']]
    ];

    // إذا كتب المستخدم قسماً غير موجود بالخريطة يعطيه 404
    if (!array_key_exists($category, $categoryMap)) {
        abort(404);
    }

    // جلب المنتجات التابعة للكلمات الدلالية الخاصة بالقسم المختار
    $products = Product::where(function($query) use ($categoryMap, $category) {
                            foreach($categoryMap[$category]['keywords'] as $keyword) {
                                $query->orWhere('category', 'like', $keyword);
                            }
                       })
                       ->where('status', 1)
                       ->with('images')
                       ->latest()
                       ->get();

    // جلب بيانات القسم الأساسية إذا كنت تحتاجها في الصفحات
    $categoryData = \App\Models\Category::where('category_slug', 'like', '%'.$category.'%')->first();

    // تحديد اسم ملف الـ View ديناميكياً بناءً على القسم (مثال: categories.boys)
    $targetView = $categoryMap[$category]['view'];

    return view($targetView, [
        'products' => $products,
        'category' => $categoryData
    ]);
}
    // 4. صفحة منتج واحد 
    public function show($id) 
    {
        $product = Product::with('images')->findOrFail($id); 

        $relatedProducts = Product::where('category', $product->category)
                                    ->where('id', '!=', $product->id)
                                    ->with('images')
                                    ->take(4)
                                    ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }
}
