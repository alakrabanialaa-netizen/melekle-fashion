<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. دالة عرض صفحة السلة الكاملة (تم تعديل اسمها ليتوافق مع روت mycart)
    public function MyCart()
    {
        $cart = session()->get('cart', []);
return view('cart.index', compact('cart'));
        // ⚠️ تنبيه: تأكد أن ملف السلة الكاملة موجود داخل فولدر resources/views/frontend/cart.blade.php
    }

    // 2. دالة إضافة المنتج للسلة عبر Ajax (تم تحديثها لدعم المقاسات والرد الذكي بدون ريفريش)
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // جلب المقاس إذا أرسله الزبون، أو وضع مقاس افتراضي
        $size = $request->input('size', 'Free Size');

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "size" => $size,
                // جلب الصورة الأولى للمنتج بشكل صحيح
                "image" => $product->images->first() ? $product->images->first()->image : ''
            ];
        }

        session()->put('cart', $cart);

        // الرد بصيغة JSON لكي يفهمها كود الـ Ajax في الصفحة الرئيسية ولا ينقلك لصفحة خطأ
        return response()->json([
            'status' => 'success',
            'message' => 'تم إضافة المنتج للسلة بنجاح!',
            'cart' => $cart
        ]);
    }

    // 3. دالة حذف المنتج من السلة
    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'تم حذف المنتج من السلة!');
    }
}
