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
    return view('welcome'); 
}
public function Index()
    {
        // جلب آخر 8 منتجات من قاعدة البيانات
        $products = Product::latest()->limit(8)->get();
        
        // جلب التصنيفات لعرضها في القائمة
        $categories = Category::orderBy('category_name', 'ASC')->get();

        // إرسال المتغيرات إلى الصفحة
        return view('welcome', compact('products', 'categories')); 
    }
