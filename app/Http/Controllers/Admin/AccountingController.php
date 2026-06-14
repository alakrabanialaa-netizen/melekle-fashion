<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function index()
    {
        // 1. حسابات المبيعات والمصاريف الفعلية
        $totalSales = Order::where('status', 'completed')->sum('total_price');
        $totalExpenses = Expense::sum('amount');

        // 2. تكلفة البضاعة التي بيعت بالفعل (لحساب صافي الربح الحقيقي)
        $costOfGoodsSold = 0;
        $completedOrders = Order::with('items.product')->where('status', 'completed')->get();
        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    // تحويل السعر والتكلفة احتياطياً لـ PostgreSQL
                    $costOfGoodsSold += ($item->quantity * (float)$item->product->cost_price);
                }
            }
        }
        $actualGrossProfit = $totalSales - $costOfGoodsSold;
        $netProfit = $actualGrossProfit - $totalExpenses;

        // 3. 🔥 جرد وتحليل المخزون الحالي في المستودع بدقة متناهية 🔥
        $totalStockPieces = Product::sum(DB::raw('CAST(stock AS INT)'));
        
        // إجمالي قيمة المستودع بسعر التكلفة (كم كلفنا هذا المخزون)
        $inventoryCostValue = Product::sum(DB::raw('CAST(stock AS NUMERIC) * CAST(cost_price AS NUMERIC)'));
        
        // إجمالي قيمة المستودع عند البيع (كم سعره بالسوق حالياً)
        $inventorySaleValue = Product::sum(DB::raw('CAST(stock AS NUMERIC) * CAST(price AS NUMERIC)'));
        
        // الأرباح المخزنة (التي سنجنيها عند بيع المخزون بالكامل)
        $expectedInventoryProfit = $inventorySaleValue - $inventoryCostValue;

        // 4. رأس المال ديناميكياً من القيود
        $capital = DB::table('capital_transactions')->sum('amount');
        $lowStock = Product::where('stock', '<=', 5)->get();

        // 5. بيانات الرسم البياني للمبيعات
        $salesData = Order::select(
            DB::raw('SUM(total_price) as total'),
            DB::raw('EXTRACT(MONTH FROM created_at) as month')
        )
        ->whereYear('created_at', date('Y'))
        ->where('status', 'completed')
        ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->orderBy('month', 'asc')
        ->get();

        $chartLabels = [];
        $chartData = [];
        $months = ['كانون الثاني', 'شباط', 'آذار', 'نيسان', 'أيار', 'حزيران', 'تموز', 'آب', 'أيلول', 'تشرين الأول', 'تشرين الثاني', 'كانون الأول'];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $months[$i - 1];
            $monthData = $salesData->first(function($value) use ($i) {
                return (int)$value->month == $i;
            });
            $chartData[] = $monthData ? $monthData->total : 0;
        }

        // 6. آخر القيود والمصاريف لجداول الإدارة
        $recentExpenses = Expense::latest()->take(5)->get();
        $capitalTransactions = DB::table('capital_transactions')->latest()->take(5)->get();

        return view('admin.accounting.index', [
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'actualGrossProfit' => $actualGrossProfit,
            'net' => $netProfit,
            
            // متغيرات الجرد الجديدة
            'totalStockPieces' => $totalStockPieces,
            'inventoryCostValue' => $inventoryCostValue,
            'inventorySaleValue' => $inventorySaleValue,
            'expectedInventoryProfit' => $expectedInventoryProfit,
            
            'capital' => $capital,
            'lowStock' => $lowStock,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'recentExpenses' => $recentExpenses,
            'capitalTransactions' => $capitalTransactions
        ]);
    }

    public function storeCapital(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'transaction_date' => 'required|date',
        ]);

        DB::table('capital_transactions')->insert([
            'description' => $request->description,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/accounting')->with('success', 'تم تسجيل القيد المالي بنجاح');
    }

    public function destroyCapital($id)
    {
        DB::table('capital_transactions')->where('id', $id)->delete();
        return redirect('/admin/accounting')->with('success', 'تم حذف القيد بنجاح');
    }
}
