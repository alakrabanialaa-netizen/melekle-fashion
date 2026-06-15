<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function index()
    {
        // 1. جلب المصاريف ورأس المال
        $totalExpenses = Expense::sum('amount');
        $capital = DB::table('capital_transactions')->sum('amount');

        // 2. المبيعات اليدوية وتكلفتها (لحساب الأرباح بدقة)
        // سنفترض أننا نجمع المبيعات من جدول مبيعات يدوي مستقل أسميناه manual_sales
        $totalSales = DB::table('manual_sales')->sum('total_price');
        $costOfGoodsSold = DB::table('manual_sales')->sum('total_cost');

        // 3. الحسبة المالية: صافي الربح = إجمالي المبيعات - تكلفة البضاعة المباعة - المصاريف
        $netProfit = $totalSales - $costOfGoodsSold - $totalExpenses;

        // 4. جرد المستودع الحالي
        $totalStockPieces = Product::sum(DB::raw('CAST(stock AS INT)'));
        $inventoryCostValue = Product::sum(DB::raw('CAST(stock AS NUMERIC) * CAST(cost_price AS NUMERIC)'));
        $inventorySaleValue = Product::sum(DB::raw('CAST(stock AS NUMERIC) * CAST(price AS NUMERIC)'));

        // 5. جلب البيانات للجداول
        $products = Product::latest()->get(); // بضاعة المستودع
        $recentSales = DB::table('manual_sales')->latest()->take(10)->get(); // آخر المبيعات اليدوية
        $recentExpenses = Expense::latest()->take(5)->get();
        $capitalTransactions = DB::table('capital_transactions')->latest()->take(5)->get();

        return view('admin.accounting.index', compact(
            'totalSales', 'totalExpenses', 'netProfit', 'totalStockPieces', 
            'inventoryCostValue', 'inventorySaleValue', 'products', 
            'recentSales', 'recentExpenses', 'capitalTransactions', 'capital'
        ));
    }

    // 🔥 دالة البيع اليدوي والخصم من المستودع تلقائياً
    public function storeSale(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'sale_price' => 'required|numeric'
        ]);

        // البحث عن المنتج في المستودع بواسطة الكود
        $product = Product::where('product_code', $request->product_code)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'خطأ: كود المنتج غير موجود في المستودع!');
        }

        if ((int)$product->stock < (int)$request->quantity) {
            return redirect()->back()->with('error', 'خطأ: الكمية المطلوبة غير متوفرة في المستودع! المتاح حالياً: ' . $product->stock);
        }

        // حساب الإجماليات
        $totalPrice = $request->quantity * $request->sale_price;
        $totalCost = $request->quantity * (float)$product->cost_price;

        DB::beginTransaction();
        try {
            // 1. تسجيل عملية البيع اليدوي
            DB::table('manual_sales')->insert([
                'product_code' => $product->product_code,
                'product_name' => $product->product_name,
                'quantity' => $request->quantity,
                'sale_price' => $request->sale_price,
                'total_price' => $totalPrice,
                'total_cost' => $totalCost,
                'created_at' => now()
            ]);

            // 2. 🎯 خصم الكمية من المستودع تلقائياً
            $product->decrement('stock', $request->quantity);

            DB::commit();
            return redirect()->back()->with('success', 'تم تسجيل المبيعات وخصم القطع من المخزن بنجاح!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ أثناء المعالجة: ' . $e->getMessage());
        }
    }
}
