<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product; // الاستيراد الصحيح لموديل المنتجات
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        // 1. التحقق من المدخلات القادمة من الـ Form
        $request->validate([
            'product_code' => 'required|string',
            'quantity'     => 'required|integer|min=1',
            'sale_price'   => 'required|numeric|min=0',
        ]);

        DB::beginTransaction();

        try {
            // 2. البحث عن المنتج عن طريق حقل product_code المطابق تماماً لما في الموديل
            $product = Product::where('product_code', $request->product_code)->first();

            // إذا لم يجد الكود
            if (!$product) {
                return back()->with('error', "خطأ: كود المنتج ({$request->product_code}) غير موجود بالمستودع!");
            }

            // 3. التحقق من توفر كمية كافية بالمخزون الحالي (حقل stock)
            if ($product->stock < $request->quantity) {
                return back()->with('error', "المخزون غير كافٍ! الكمية المتاحة حالياً للمنتج ({$product->name}) هي: {$product->stock}");
            }

            $quantity = (int)$request->quantity;
            $actualSalePrice = (float)$request->sale_price;
            $costPrice = (float)($product->cost_price ?? 0);

            // حساب الإجماليات للحركة الحالية
            $totalAmount = $actualSalePrice * $quantity;
            
            // الربح الفعلي = (سعر البيع اليدوي المحصل - سعر التكلفة الأساسي) * الكمية
            $totalProfit = ($actualSalePrice - $costPrice) * $quantity;

            // 4. إنشاء حركية البيع الأساسية في جدول المبيعات
            $sale = Sale::create([
                'total_amount' => $totalAmount,
                'total_profit' => $totalProfit,
            ]);

            // 5. تسجيل الصنف المبيوع في جدول التفاصيل (SaleItem)
            // ملاحظة: تأكد من أن جدول sale_items يحتوي على حقل product_id
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $product->id, 
                'quantity'   => $quantity,
                'price'      => $actualSalePrice,
                'profit'     => $totalProfit,
            ]);

            // 6. الخصم المباشر من مخزون المنتج (حقل stock)
            $product->decrement('stock', $quantity);

            DB::commit();

            return back()->with('success', 'تم تسجيل حركية البيع بنجاح، وخصم الكمية من المستودع!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }
}
