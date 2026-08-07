<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * عرض صفحة قسم البنات مع مرونة في فحص اسم القسم وحالة الأحرف
     */
    public function girls()
    {
        $products = Product::with('images')
            ->where(function($query) {
                $query->whereIn('category', ['girls', 'girl', 'Girls', 'Girl'])
                      ->orWhereRaw('LOWER(category) = ?', ['girls']);
            })
            ->latest()
            ->get();

        return view('categories.girls', compact('products'));
    }

    /**
     * عرض صفحة قسم الأولاد
     */
    public function boys()
    {
        $products = Product::with('images')
            ->where(function($query) {
                $query->whereIn('category', ['boys', 'boy', 'Boys', 'Boy'])
                      ->orWhereRaw('LOWER(category) = ?', ['boys']);
            })
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
            ->where(function($query) {
                $query->whereIn('category', ['babies', 'baby', 'Babies', 'Baby'])
                      ->orWhereRaw('LOWER(category) = ?', ['babies']);
            })
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
            ->where(function($query) {
                $query->whereIn('category', ['mothers', 'mother', 'Mothers', 'Mother'])
                      ->orWhereRaw('LOWER(category) = ?', ['mothers']);
            })
            ->latest()
            ->get();

        return view('categories.mothers', compact('products'));
    }
}
