<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Expense;
use App\Models\Product;
use Carbon\Carbon; // <-- ✅ تأكد من إضافة هذا السطر

class AdminDashboardController extends Controller
{
   public function index()
{
    // =====================================================
    // 1. حساب البطاقات الرئيسية (الكود من المرحلة الأولى)
    // =====================================================
    $totalSales = Order::where('status', 'completed')->sum('total_price');
    $ordersThisMonth = Order::whereYear('created_at', Carbon::now()->year)
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->count();
    $totalCustomers = User::count();

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
    $totalExpenses = Expense::sum('amount');
    $netProfit = $grossProfit - $totalExpenses;

    // =====================================================
    // 2. تجهيز بيانات الرسم البياني (لآخر 7 أيام)
    // =====================================================
    $salesChartData = [];
    $salesChartLabels = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        $salesChartLabels[] = $date->format('D'); // اسم اليوم (e.g., Sat)

        $dailySales = Order::where('status', 'completed')
                           ->whereDate('created_at', $date)
                           ->sum('total_price');
        
        $salesChartData[] = $dailySales;
    }

    // =====================================================
    // 3. جلب آخر النشاطات
    // =====================================================
    $recentOrders = Order::with('user')->latest()->take(3)->get();
    $recentUsers = User::latest()->take(2)->get();

    // دمج النشاطات وترتيبها حسب تاريخ الإنشاء
    $recentActivities = $recentOrders->concat($recentUsers)->sortByDesc('created_at');

    // =====================================================
    // 4. تمرير كل البيانات المجمعة إلى الواجهة
    // =====================================================

    
    return view('admin.dashboard', [
        // بيانات البطاقات
        'totalSales' => $totalSales,
        'ordersThisMonth' => $ordersThisMonth,
        'totalCustomers' => $totalCustomers,
        'netProfit' => $netProfit,

        // بيانات الرسم البياني
        'salesChartLabels' => $salesChartLabels,
        'salesChartData' => $salesChartData,

        // بيانات آخر النشاطات
        'recentActivities' => $recentActivities,

        
    ]);
}

}
