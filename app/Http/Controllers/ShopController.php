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

    // 3. صفحة منتج واحد (تم دمجها في دالة واحدة صحيحة)
    public function show($id) 
    {
        // جلب المنتج باستخدام الـ ID مع الصور، وإذا لم يوجد يعطي خطأ 404
        $product = Product::with('images')->findOrFail($id); 

        // جلب المنتجات المشابهة بنفس التصنيف
        $relatedProducts = Product::where('category', $product->category)
                                    ->where('id', '!=', $product->id)
                                    ->with('images')
                                    ->take(4)
                                    ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }
}
