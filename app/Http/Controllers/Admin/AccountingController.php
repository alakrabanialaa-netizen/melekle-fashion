<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    /**
     * عرض لوحة المعلومات المحاسبية مع كل البيانات المحسوبة.
     */
    public function index()
    {
        // =====================================================
        // 1. حساب الأرقام الأساسية (المبيعات، المصاريف، الأرباح)
        // =====================================================

        $totalSales = Order::where('status', 'completed')->sum('total_price');
        $totalExpenses = Expense::sum('amount');

        $costOfGoodsSold = 0;
        $completedOrders = Order::with('items.product')->where('status', 'completed')->get();

        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $costOfGoodsSold += ($item->qty * $item->product->cost_price);
                }
            }
        }

        $grossProfit = $totalSales - $costOfGoodsSold;
        $netProfit = $grossProfit - $totalExpenses;

        $inventoryValue = Product::all()->sum(function ($product) {
            return $product->stock * $product->cost_price;
        });

        $lowStock = Product::where('stock', '<=', 5)->get();

        // =====================================================
        // 2. تجهيز بيانات الرسم البياني للمبيعات الشهرية
        // =====================================================

        $salesData = Order::select(
            DB::raw('SUM(total_price) as total'),
            DB::raw('MONTH(created_at) as month')
        )
        ->whereYear('created_at', date('Y'))
        ->where('status', 'completed')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        $chartLabels = [];
        $chartData = [];
        $months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $months[$i - 1];
            $monthData = $salesData->firstWhere('month', $i);
            $chartData[] = $monthData ? $monthData->total : 0;
        }

        // =====================================================
        // 3. جلب آخر المصاريف لعرضها في الجدول
        // =====================================================

        // ✅ --- هذا هو السطر الجديد، في مكانه الصحيح داخل الدالة --- ✅
        $recentExpenses = Expense::latest()->take(10)->get();


        // =====================================================
        // 4. تمرير كل البيانات المجمعة إلى الواجهة (View)
        // =====================================================

        return view('admin.accounting.index', [
            // الأرقام الأساسية
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'totalProfit' => $grossProfit,
            'net' => $netProfit,
            'inventoryValue' => $inventoryValue,
            'lowStock' => $lowStock,

            // بيانات الرسم البياني
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,

            // ✅ --- المتغير الجديد الذي يتم تمريره --- ✅
            'recentExpenses' => $recentExpenses,
        ]);
    }
}
