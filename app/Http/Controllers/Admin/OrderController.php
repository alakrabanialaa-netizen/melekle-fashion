<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 📋 عرض جميع الطلبات
     */
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * 👁️ عرض تفاصيل طلب واحد
     */
    public function show(Order $order)
    {
        // إذا عندك عناصر طلب لاحقاً
        // $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * ✏️ صفحة تعديل الطلب (تغيير الحالة)
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * 🔄 تحديث الطلب
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $order->update($data);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'تم تحديث حالة الطلب');
    }

    /**
     * 🗑️ حذف الطلب
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'تم حذف الطلب');
    }
}
