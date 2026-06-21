<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product; // استدعاء موديل المنتج إذا كان الكود فيه
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        // 1. الفحص والتحقق من المدخلات القادمة من الـ Form
        $request->validate([
            'product_code' => 'required|string',
            'quantity'     => 'required|integer|min=1',
            'sale_price'   => 'required|numeric|min=0',
        ]);

        DB::beginTransaction();

        try {
            // 2. البحث عن المنتج في قاعدة البيانات عن طريق الكود
            // نفحص أولاً إن كان الكود مسجلاً في جدول المنتجات الأساسي
            $product = Product::where('product_code', $request->product_code)
                              ->orWhere('code', $request->product_code)
                              ->first();

            if (!$product) {
                return back()->with('error', 'خطأ: كود المنتج المدخل غير موجود بالمستودع أو لم يتم حفظه بعد!');
            }

            // 3. التحقق من توفر كمية كافية بالمخزون
            if ($product->stock < $request->quantity) {
                return back()->with('error', "المخزون غير كافٍ! الكمية المتاحة حالياً هي: {$product->stock}");
            }

            // 4. حساب القيم المالية بناءً على السعر المحصل الفعلي الذي أدخلته
            $quantity = (int)$request->quantity;
            $actualSalePrice = (float)$request->sale_price;
            $costPrice = (float)($product->cost_price ?? 0);

            $totalAmount = $actualSalePrice * $quantity;
            
            // الربح الفعلي = (سعر البيع المحصل يدوياً - سعر التكلفة الأصلي) * الكمية
            $totalProfit = ($actualSalePrice - $costPrice) * $quantity;

            // 5. إنشاء حركية البيع الأساسية
            $sale = Sale::create([
                'total_amount' => $totalAmount,
                'total_profit' => $totalProfit,
            ]);

            // 6. تسجيل الصنف المبيوع في جدول التفاصيل (SaleItem)
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $product->id, // إذا كان جدول الـ items يربط مباشرة بالمنتج
                'quantity'   => $quantity,
                'price'      => $actualSalePrice,
                'profit'     => $totalProfit,
            ]);

            // 7. الخصم الفوري والمباشر من مخزون المنتج الأساسي
            $product->decrement('stock', $quantity);

            DB::commit();

            return back()->with('success', 'تم تسجيل حركية البيع الفوري، وخصم الكمية من المستودع بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }
}
