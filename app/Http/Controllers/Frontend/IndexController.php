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
        // جلب آخر 8 منتجات من قاعدة البيانات لمتجر Melekler Fashion
        $products = Product::latest()->limit(8)->get();
        
        // جلب التصنيفات المرتبطة
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // إرسال المتغيرات إلى صفحة welcome الحالية
        return view('welcome', compact('products', 'categories')); 
    }

public function ProductDetails($id, $slug = null) 
    
        return view('frontend.product.product_details');
    }
}
