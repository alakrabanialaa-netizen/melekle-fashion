<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // دالة store تبقى كما هي، لكن سنغير مسار العودة
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create($validatedData);

        return redirect()->route('admin.accounting.index') // العودة لصفحة المحاسبة
                         ->with('success', 'تم تسجيل المصروف بنجاح.');
    }

    // ✅ --- الدوال الجديدة --- ✅

    /**
     * عرض نموذج تعديل مصروف.
     */
    public function edit(Expense $expense)
    {
        // سنعرض النموذج في صفحة منفصلة
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * تحديث المصروف في قاعدة البيانات.
     */
    public function update(Request $request, Expense $expense)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $expense->update($validatedData);

        return redirect()->route('admin.accounting.index') // العودة لصفحة المحاسبة
                         ->with('success', 'تم تعديل المصروف بنجاح.');
    }

    /**
     * حذف المصروف من قاعدة البيانات.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.accounting.index') // العودة لصفحة المحاسبة
                         ->with('success', 'تم حذف المصروف بنجاح.');
    }
}
