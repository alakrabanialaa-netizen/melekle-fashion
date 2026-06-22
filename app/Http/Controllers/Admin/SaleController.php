<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string',
            'quantity'     => 'required|integer|min:1',
            'sale_price'   => 'required|numeric|min:0',
        ]);

        // تنظيف الكود من الفراغات
        $inputCode = trim($request->product_code);

        DB::beginTransaction();

        try {
            // البحث عن المنتج في جدول المنتجات
            $product = Product::where('product_code', $inputCode)
                              ->orWhere('product_code', 'LIKE', '%' . $inputCode . '%')
                              ->first();

            // إذا لم يتم العثور على المنتج
            if (!$product) {
                return back()->with('error', "خطأ: كود المنتج ({$inputCode}) غير موجود بالمستودع! تأكد من الكود المكتوب في الجدول بالأسفل.");
            }

            // التحقق من المخزون الحالي للمنتج
            if ((int)$product->stock < (int)$request->quantity) {
                return back()->with('error', "المخزون غير كافٍ! الكمية المتاحة حالياً للمنتج ({$product->name}) هي: {$product->stock}");
            }

            $quantity = (int)$request->quantity;
            $actualSalePrice = (float)$request->sale_price;
            $costPrice = (float)($product->cost_price ?? 0);

            // الحسبة المالية الدقيقة للحركة
            $totalPrice = $actualSalePrice * $quantity;
            $totalCost = $costPrice * $quantity;

            // ✅ تم إزالة 'updated_at' ليتوافق 100% مع أعمدة الجدول في Supabase منعاً للـ Crash
            DB::table('manual_sales')->insert([
                'product_code' => $product->product_code,
                'product_name' => $product->name ?? 'منتج غير محدد',
                'quantity'     => $quantity,
                'sale_price'   => $actualSalePrice,
                'total_price'  => $totalPrice,
                'total_cost'   => $totalCost,
                'created_at'   => now()
            ]);

          // ✅ تحويل المخزون النصي إلى رقم، طرح الكمية، ثم إعادة الحفظ بأمان متوافق مع Postgres
            $currentStock = (int)($product->stock ?? 0);
            $newStock = $currentStock - $quantity;
            
            $product->update([
                'stock' => (string)$newStock
            ]);

            DB::commit();

            return back()->with('success', 'تم تسجيل حركية البيع بنجاح، وخصم الكمية من المستودع وتحديث الدفتر المالي!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء المعالجة: ' . $e->getMessage());
        }
    }
}
