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
        // 1. حساب إجمالي المبيعات والمصاريف
        $totalSales = Order::where('status', 'completed')->sum('total_price');
        $totalExpenses = Expense::sum('amount');

        // 2. حساب تكلفة البضاعة المباعة وصافي الأرباح
        $costOfGoodsSold = 0;
        $completedOrders = Order::with('items.product')->where('status', 'completed')->get();

        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $costOfGoodsSold += ($item->quantity * $item->product->cost_price);
                }
            }
        }

        $grossProfit = $totalSales - $costOfGoodsSold;
        $netProfit = $grossProfit - $totalExpenses;

        // 3. قيمة المخزون الحالية الدقيقة (الكمية الحالية في السعر)
        $inventoryValue = Product::sum(DB::raw('stock * cost_price'));

        // 4. حساب رأس المال ديناميكياً من جدول حركات رأس المال
        $capital = DB::table('capital_transactions')->sum('amount');

        $lowStock = Product::where('stock', '<=', 5)->get();

        // 5. جلب بيانات الرسم البياني (متوافق مع PostgreSQL)
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
        $months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $months[$i - 1];
            $monthData = $salesData->first(function($value) use ($i) {
                return (int)$value->month == $i;
            });
            $chartData[] = $monthData ? $monthData->total : 0;
        }

        // 6. جلب القيود والمصاريف الحديثة
        $recentExpenses = Expense::latest()->take(5)->get();
        $capitalTransactions = DB::table('capital_transactions')->latest()->take(5)->get();

        return view('admin.accounting.index', [
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'totalProfit' => $grossProfit,
            'net' => $netProfit,
            'inventoryValue' => $inventoryValue,
            'capital' => $capital,
            'lowStock' => $lowStock,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'recentExpenses' => $recentExpenses,
            'capitalTransactions' => $capitalTransactions
        ]);
    }

    // دالة إضافة قيد رأس مال جديد
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

        return redirect('/admin/accounting')->with('success', 'تم تسجيل قيد رأس المال بنجاح');
    }

    // دالة حذف قيد رأس المال
    public function destroyCapital($id)
    {
        DB::table('capital_transactions')->where('id', $id)->delete();
        return redirect('/admin/accounting')->with('success', 'تم حذف القيد بنجاح');
    }
}
