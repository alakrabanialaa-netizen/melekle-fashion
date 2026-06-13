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

    // 2. دالة إضافة المنتج للسلة (تم إصلاح أسماء الحقول لتتوافق مع قاعدة البيانات والـ View)
    public function add(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $cart = session()->get('cart', []);

        // جلب المقاس إذا أرسله الزبون، أو وضع مقاس افتراضي
        $size = $request->input('size', 'Free Size');

        // جلب اسم الصورة الأولى بشكل صحيح وآمن لمنع الـ Errors
        $imagePath = null;
        if ($product->images && $product->images->first()) {
            // تحقق إذا كان الحقل في جدول الصور اسمه image_name أو image
            $imagePath = $product->images->first()->image_name ?? $product->images->first()->image;
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // ⭐ تم تعديل الأسطر بالأسفل لتجلب البيانات الحقيقية من الموديل (product_name & selling_price)
            $cart[$id] = [
                "name" => $product->product_name ?? $product->name,
                "quantity" => 1,
                "price" => $product->selling_price ?? $product->price,
                "size" => $size,
                "image" => $imagePath
            ];
        }

        session()->put('cart', $cart);

        // إذا كان الطلب Ajax يرسل JSON لتحديث النافذة المنبثقة فوراً
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم إضافة المنتج للسلة بنجاح!',
                'cart' => $cart,
                'cart_count' => count($cart)
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
