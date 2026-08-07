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
    // 1. فحص هل سيرفر Render متصل بقاعدة البيانات الصحيحة أم لا
    try {
        \DB::connection()->getPdo();
        $dbName = \DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
    }

    // 2. جلب كافة المنتجات الموجودة في جدول products بدون أي فلترة
    $allProducts = Product::all();

    // 3. طباعة التقرير كاملاً على الشاشة للتأكد
    return response()->json([
        'status' => 'connected',
        'database_name' => $dbName,
        'total_products_count' => $allProducts->count(),
        'products_data' => $allProducts
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
