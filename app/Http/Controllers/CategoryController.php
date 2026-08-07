<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * عرض صفحة قسم البنات
     */
public function girls()
{
    $products = Product::whereRaw("TRIM(LOWER(category)) = ?", ['girls'])->get();
    
    // إرجاع النتيجة كنص JSON مباشر على الشاشة لفحصها
    return response()->json([
        'count' => $products->count(),
        'data' => $products
    ]);
}

    /**
     * عرض صفحة قسم الأولاد
     */
    public function boys()
    {
        $products = Product::with('images')
            ->whereRaw("TRIM(LOWER(category)) = ?", ['boys'])
            ->latest()
            ->get();

        return view('categories.boys', compact('products'));
    }

    /**
     * عرض صفحة قسم الرضع
     */
    public function babies()
    {
        $products = Product::with('images')
            ->whereRaw("TRIM(LOWER(category)) = ?", ['babies'])
            ->latest()
            ->get();

        return view('categories.babies', compact('products'));
    }

    /**
     * عرض صفحة قسم الأمهات
     */
    public function mothers()
    {
        $products = Product::with('images')
            ->whereRaw("TRIM(LOWER(category)) = ?", ['mothers'])
            ->latest()
            ->get();

        return view('categories.mothers', compact('products'));
    }
}
