<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * عرض صفحة قسم البنات مع تحميل مسبق للصور لتحسين الأداء.
     */
    public function girls()
    {
        // ✅ --- هذا هو الاستعلام الصحيح والمحسّن --- ✅
        $products = Product::with('images') // <-- جلب الصور مع المنتج في استعلام واحد
                          ->where('category', 'girls')
                          ->latest()
                          ->get();
        
        return view('categories.girls', compact('products'));
    }

    /**
     * عرض صفحة قسم الأولاد.
     */
    public function boys()
    {
        $products = Product::with('images')
                          ->where('category', 'boys')
                          ->latest()
                          ->get();
        
        return view('categories.boys', compact('products'));
    }

    /**
     * عرض صفحة قسم الرضع.
     */
    public function babies()
    {
        $products = Product::with('images')
                          ->where('category', 'babies')
                          ->latest()
                          ->get();
        
        return view('categories.babies', compact('products'));
    }

    /**
     * عرض صفحة قسم الأمهات.
     */
    public function mothers()
    {
        $products = Product::with('images')
                          ->where('category', 'mothers')
                          ->latest()
                          ->get();
        
        return view('categories.mothers', compact('products'));
    }
}
