<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        DB::transaction(function () {

            $cart = session('cart');

            if (!$cart || count($cart) === 0) {
                abort(400, 'السلة فارغة');
            }

            // 🧮 حساب المجموع
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // 🧾 إنشاء الطلب
            $order = Order::create([
                'user_id' => auth()->id(), // null لو ضيف
                'total'   => $total,
                'status'  => 'pending',
            ]);

            // 📦 عناصر الطلب + خصم المخزون
            foreach ($cart as $id => $item) {

                $product = Product::findOrFail($id);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id'=> $product->id,
                    'quantity'  => $item['quantity'],
                    'price'     => $item['price'],
                ]);

                // خصم المخزون
                $product->decrement('stock', $item['quantity']);
            }

            // 🔔 إرسال إشعار للأدمن
            $admins = User::where('is_admin', true)->get();

            foreach ($admins as $admin) {
                $admin->notify(new NewOrderNotification($order));
            }

            // 🧹 تفريغ السلة
            session()->forget('cart');
        });

        return redirect()
            ->route('home')
            ->with('success', 'تم إنشاء الطلب بنجاح ✅');
    }
}
