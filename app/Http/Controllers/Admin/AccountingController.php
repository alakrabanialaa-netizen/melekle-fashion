<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AccountingController extends Controller
{
    public function index()
    {
        $totalExpenses = Expense::sum('amount');
        $capital = DB::table('capital_transactions')->sum('amount');

        $totalSales = DB::table('manual_sales')->sum('total_price');
        $costOfGoodsSold = DB::table('manual_sales')->sum('total_cost');

        $netProfit = $totalSales - $costOfGoodsSold - $totalExpenses;

        /*
         * المحاسبة تعتمد فقط على المنتجات التي تم تفعيل
         * خيار إدخالها إلى المستودع والمحاسبة.
         *
         * IS TRUE متوافقة مع PostgreSQL
         * ولا تتحول إلى مقارنة Boolean مع الرقم 1.
         */
        $warehouseQuery = Product::whereRaw('"track_inventory" IS TRUE');

        $totalStockPieces = (clone $warehouseQuery)
            ->sum(DB::raw('CAST(stock AS INTEGER)'));

        $inventoryCostValue = (clone $warehouseQuery)
            ->sum(DB::raw(
                'CAST(stock AS NUMERIC) * CAST(cost_price AS NUMERIC)'
            ));

        $inventorySaleValue = (clone $warehouseQuery)
            ->sum(DB::raw(
                'CAST(stock AS NUMERIC) * CAST(price AS NUMERIC)'
            ));

        $warehouseProducts = Product::whereRaw('"track_inventory" IS TRUE')
            ->latest()
            ->get();

        $manualSales = DB::table('manual_sales')
            ->latest()
            ->get();

        $expensesList = Expense::latest()->get();

        $capitalTransactions = DB::table('capital_transactions')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.accounting.index', compact(
            'totalSales',
            'totalExpenses',
            'netProfit',
            'totalStockPieces',
            'inventoryCostValue',
            'inventorySaleValue',
            'warehouseProducts',
            'manualSales',
            'expensesList',
            'capitalTransactions',
            'capital'
        ));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'product_code' => 'nullable|string',
            'color' => 'nullable|string',
            'stock' => 'nullable|numeric',
            'cost_price' => 'nullable|numeric',
            'price' => 'nullable|numeric',
        ]);

        $product = Product::whereRaw('"track_inventory" IS TRUE')
            ->findOrFail($id);

        $updateData = [];

        if ($request->has('product_code')) {
            $updateData['product_code'] = $request->product_code;
        }

        if ($request->has('color')) {
            $updateData['color'] = $request->color;
        }

        if ($request->has('stock')) {
            $updateData['stock'] = $request->stock;
        }

        if ($request->has('cost_price')) {
            $updateData['cost_price'] = $request->cost_price ?? 0;
        }

        if ($request->has('price')) {
            $updateData['price'] = $request->price ?? 0;

            if (Schema::hasColumn('products', 'selling_price')) {
                $updateData['selling_price'] = $request->price ?? 0;
            }
        }

        $product->update($updateData);

        return redirect()
            ->back()
            ->with(
                'success',
                'تم تحديث بيانات الصنف في المستودع وتعديل الأسعار والمخزون بنجاح.'
            );
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return redirect()
            ->back()
            ->with('success', 'تم تسجيل المصروف التشغيلي بنجاح.');
    }

    public function updateExpense(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        Expense::where('id', $id)->update([
            'description' => $request->description,
            'amount' => $request->amount,
        ]);

        return redirect()
            ->back()
            ->with('success', 'تم تعديل قيد المصروف بنجاح.');
    }

    public function destroyExpense($id)
    {
        Expense::where('id', $id)->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'تم حذف قيد المصروف وتحديث الحسبة المالية.'
            );
    }

    public function storeSale(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'sale_price' => 'required|numeric',
        ]);

        $product = Product::where('product_code', $request->product_code)
            ->whereRaw('"track_inventory" IS TRUE')
            ->first();

        if (!$product) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'كود المنتج غير موجود ضمن منتجات المستودع.'
                );
        }

        if ((int) $product->stock < (int) $request->quantity) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'الكمية المطلوبة غير متوفرة في المستودع. المتاح حاليًا: '
                    . $product->stock
                );
        }

        $totalPrice = $request->quantity * $request->sale_price;
        $totalCost = $request->quantity * (float) $product->cost_price;

        DB::beginTransaction();

        try {
            DB::table('manual_sales')->insert([
                'product_code' => $product->product_code,
                'product_name' => $product->name
                    ?? $product->product_name
                    ?? 'منتج غير محدد',
                'quantity' => $request->quantity,
                'sale_price' => $request->sale_price,
                'total_price' => $totalPrice,
                'total_cost' => $totalCost,
                'created_at' => now(),
            ]);

            $product->decrement('stock', $request->quantity);

            DB::commit();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'تم تسجيل البيع وخصم القطع من المستودع بنجاح.'
                );
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with(
                    'error',
                    'حدث خطأ أثناء المعالجة: ' . $e->getMessage()
                );
        }
    }
}
