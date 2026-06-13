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

    // ⭐ 3. الدالة الجديدة: عرض المنتجات حسب القسم المحدد
    public function category($category)
    {
        // التحقق من أن القسم الممرر مدعوم في موقعك
        $validCategories = ['girls', 'boys', 'babies', 'mothers'];
        
        if (!in_array($category, $validCategories)) {
            abort(404); // إذا كتب المستخدم قسماً غير موجود بالرابط يعطيه 404
        }

        // جلب المنتجات التابعة للقسم المختار فقط مع صورها
        $products = Product::where('category', $category)
                           ->with('images')
                           ->latest()
                           ->get();

        // سنرسل أيضاً اسم القسم لعرضه كعنوان في الصفحة (مثلاً: قسم البنات)
        $categoryTitles = [
            'girls'   => 'ملابس البنات',
            'boys'    => 'ملابس الأولاد',
            'babies'  => 'المواليد والرضع',
            'mothers' => 'قسم الأمهات'
        ];
        $pageTitle = $categoryTitles[$category];

        return view('frontend.shop.index', compact('products', 'pageTitle'));
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
