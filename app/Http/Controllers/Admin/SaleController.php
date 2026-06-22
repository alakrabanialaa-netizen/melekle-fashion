<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string',
            'quantity'     => 'required|integer|min=1',
            'sale_price'   => 'required|numeric|min=0',
        ]);

        // تنظيف الكود المدخل من أي فراغات زائدة قد تأتي من النسخ واللصق
        $inputCode = trim($request->product_code);

        DB::beginTransaction();

        try {
            // البحث المرن: نجرب المطابقة التامة أو باستخدام LIKE لضمان تلافي مشاكل الفراغات المخفية
            // والبحث في الحقلين المحتملين (product_code أو code)
            $product = Product::where('product_code', $inputCode)
                              ->orWhere('code', $inputCode)
                              ->orWhere('product_code', 'LIKE', '%' . $inputCode . '%')
                              ->first();

            if (!$product) {
                return back()->with('error', "خطأ: كود المنتج ({$inputCode}) غير موجود بالمستودع! تأكد من الكود المكتوب في الجدول بالأسفل.");
            }

            if ($product->stock < $request->quantity) {
                return back()->with('error', "المخزون غير كافٍ! الكمية المتاحة حالياً للمنتج ({$product->name}) هي: {$product->stock}");
            }

            $quantity = (int)$request->quantity;
            $actualSalePrice = (float)$request->sale_price;
            $costPrice = (float)($product->cost_price ?? 0);

            $totalAmount = $actualSalePrice * $quantity;
            $totalProfit = ($actualSalePrice - $costPrice) * $quantity;

            $sale = Sale::create([
                'total_amount' => $totalAmount,
                'total_profit' => $totalProfit,
            ]);

            // هنا نقوم بالتحقق برمجياً من اسم الحقل في جدول الـ items لتفادي الـ Crash
            // إذا كان الجدول عندك يستخدم product_variant_id بدلاً من product_id سنمرر له الـ ID المتوفر
            $itemData = [
                'sale_id'  => $sale->id,
                'quantity' => $quantity,
                'price'    => $actualSalePrice,
                'profit'   => $totalProfit,
            ];

            // فحص ذكي للحقول لضمان عدم حدوث خطأ Column not found
            if (\Schema::hasColumn('sale_items', 'product_id')) {
                $itemData['product_id'] = $product->id;
            } elseif (\Schema::hasColumn('sale_items', 'product_variant_id')) {
                $itemData['product_variant_id'] = $product->id;
            }

            SaleItem::create($itemData);

            // الخصم من حقل المخزون المعتمد
            $product->decrement('stock', $quantity);

            DB::commit();

            return back()->with('success', 'تم تسجيل حركية البيع بنجاح، وتحديث جرد المستودع!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء المعالجة: ' . $e->getMessage());
        }
    }
}
