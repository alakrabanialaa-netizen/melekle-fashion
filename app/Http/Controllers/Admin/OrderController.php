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
        // تم تركها كما هي لأنها سليمة وتجلب علاقة المستخدم
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
        // 💡 تعديل 1: قمنا بتفعيل عمل الـ Load لعلاقة الـ items والـ product 
        // لأننا أنشأنا جدول order_items في سوبابيز والمدير سيحتاج حتماً لرؤية المنتجات داخل الفاتورة!
        $order->load('items.product', 'user');

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
        // 💡 تعديل 2 (أمان): حدد حالات الطلب المتوقعة في الـ Validation لتفادي إدخال حالات عشوائية بالـ Database
        $data = $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        $order->update($data);

        // 💡 تعديل 3: التحويل الآمن عبر الـ URL لتجنب أي مشاكل في تسمية الـ Routes المكسورة في السيرفر المرفوع
        return redirect('/admin/orders')
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * 🗑️ حذف الطلب
     */
    public function destroy(Order $order)
    {
        $order->delete();

        // 💡 تعديل 4: تحويل آمن مباشر
        return redirect('/admin/orders')
            ->with('success', 'تم حذف الطلب بنجاح');
    }
}
