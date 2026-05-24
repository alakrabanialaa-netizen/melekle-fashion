<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. دالة عرض صفحة السلة الكاملة
    public function MyCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // 2. دالة إضافة المنتج للسلة (تم تعديل الرد ليدعم الـ Form العادي والـ Ajax معاً)
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
                "image" => $product->images && $product->images->first() ? $product->images->first()->image : ''
            ];
        }

        session()->put('cart', $cart);

        // 🔥 هنا التعديل السحري:
        // إذا كان الطلب Ajax يرسل JSON، وإذا كان طلباً عادياً يعود للخلف فوراً لمنع الشاشة البيضاء
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم إضافة المنتج للسلة بنجاح!',
                'cart' => $cart
            ]);
        }

        // للطلبات العادية: يرجع العميل لنفس الصفحة مع إشعار نجاح
        return redirect()->back()->with('success', 'تم إضافة المنتج للسلة بنجاح!');
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
