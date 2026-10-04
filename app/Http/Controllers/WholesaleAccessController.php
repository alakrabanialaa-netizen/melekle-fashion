<?php

namespace App\Http\Controllers;

use App\Models\WholesaleAccessCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WholesaleAccessController extends Controller
{
    public function loginForm()
    {
        return view('wholesale.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:100']]);
        $access = WholesaleAccessCode::where('is_active', true)->get()->first(fn (WholesaleAccessCode $item) => $item->matches(trim($data['code'])));

        if (!$access) {
            return back()->withInput()->withErrors(['code' => 'الكود غير صحيح أو منتهي الصلاحية.']);
        }

        $access->forceFill(['last_used_at' => now()])->save();
        $request->session()->regenerate();
        $request->session()->put([
            'wholesale_access_code_id' => $access->id,
            'wholesale_customer_name' => $access->customer_name,
        ]);

        return redirect()->intended(route('wholesale.catalog'));
    }

    public function catalog()
    {
        $products = Product::query()->where('is_wholesale', true)->latest()->paginate(24);
        return view('wholesale.catalog', compact('products'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['wholesale_access_code_id', 'wholesale_customer_name']);
        $request->session()->regenerateToken();
        return redirect()->route('wholesale.login')->with('status', 'تم تسجيل الخروج بأمان.');
    }

    public function adminIndex()
    {
        return view('admin.wholesale.index', ['codes' => WholesaleAccessCode::latest()->paginate(20)]);
    }

    public function adminStore(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'code' => ['required', 'string', 'min:6', 'max:100'],
            'expires_at' => ['nullable', 'date'],
        ]);

        WholesaleAccessCode::create([
            'customer_name' => $data['customer_name'],
            'code_hash' => Hash::make(trim($data['code'])),
            'code_hint' => substr(trim($data['code']), 0, 3) . '•••',
            'expires_at' => $data['expires_at'] ?? null,
            'is_active' => true,
        ]);

        return back()->with('status', 'تم إنشاء كود التاجر. احتفظ بالكود وأرسله للزبون بشكل آمن.');
    }

    public function adminToggle(WholesaleAccessCode $wholesaleAccessCode)
    {
        $wholesaleAccessCode->update(['is_active' => !$wholesaleAccessCode->is_active]);
        return back()->with('status', 'تم تحديث حالة الكود.');
    }
}
