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
public function category($category)
{
    // ربط روابط الـ URL بالكلمات الدلالية المخزنة في قاعدة البيانات
    $categoryMap = [
        'boys'    => ['%ولد%', '%ولادي%', '%boy%', '%boys%'],
        'girls'   => ['%بنات%', '%بناتي%', '%girl%', '%girls%'],
        'babies'  => ['%رضع%', '%طفل%', '%أطفال%', '%اطفال%', '%baby%', '%babies%'],
        'mothers' => ['%أمهات%', '%نساء%', '%نسائي%', '%mother%', '%women%', '%women%']
    ];

    // إذا كتب المستخدم قسماً غير موجود بالخريطة يعطيه 404
    if (!array_key_exists($category, $categoryMap)) {
        abort(404);
    }

    // جلب المنتجات التابعة للكلمات الدلالية الخاصة بالقسم المختار
    $products = Product::where(function($query) use ($categoryMap, $category) {
                            foreach($categoryMap[$category] as $keyword) {
                                $query->orWhere('category', 'like', $keyword);
                            }
                       })
                       ->where('status', 1) // تأكد إن المنتجات نشطة
                       ->with('images')
                       ->latest()
                       ->get();

    // عناوين الصفحات
    $categoryTitles = [
        'boys'    => 'ملابس الأولاد',
        'girls'   => 'ملابس البنات',
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
