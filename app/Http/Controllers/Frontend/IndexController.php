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
        // جلب كافة الأقسام
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // ربط صريح ومباشر لكل قسم بآخر 3 منتجات تطابق اسمه النصي في قاعدة البيانات
        foreach ($categories as $category) {
            $productsForCategory = Product::where('category', $category->category_name)
                                          ->where('status', 1)
                                          ->with('images')
                                          ->latest()
                                          ->take(3)
                                          ->get();
            
            $category->setRelation('products', $productsForCategory);
        }
        
        return view('welcome', compact('categories')); 
    }

    public function ProductDetails($id, $slug = null) 
    {
        $product = Product::findOrFail($id);
        
        $relatedProducts = Product::where('category', $product->category)
                                  ->where('id', '!=', $id)
                                  ->where('status', 1)
                                  ->limit(4)
                                  ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }
}
