<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $sale = Sale::create([
                'total_amount' => 0,
                'total_profit' => 0,
            ]);

            $totalAmount = 0;
            $totalProfit = 0;

            foreach ($request->items as $item) {

                $variant = ProductVariant::findOrFail($item['variant_id']);

                $profit = ($variant->product->sale_price - $variant->product->cost_price)
                          * $item['quantity'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'price' => $variant->product->sale_price,
                    'profit' => $profit,
                ]);

                // خصم من المخزون
                $variant->decrement('quantity', $item['quantity']);

                $totalAmount += $variant->product->sale_price * $item['quantity'];
                $totalProfit += $profit;
            }

            $sale->update([
                'total_amount' => $totalAmount,
                'total_profit' => $totalProfit,
            ]);

            DB::commit();

            return back()->with('success', 'تم إنشاء الفاتورة بنجاح');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}