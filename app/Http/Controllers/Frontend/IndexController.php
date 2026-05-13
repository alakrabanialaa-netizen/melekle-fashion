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

    public function ProductDetails($id, $slug)
    {
        return view('frontend.product.product_details');
    }
}
