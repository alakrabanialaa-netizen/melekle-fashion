@extends('admin.layouts.app')

@section('page-title', 'النظام المحاسبي المتكامل والمستودعات')

@section('content')
<div class="container mx-auto p-6 space-y-8 bg-gray-50 min-h-screen" dir="rtl">
    
    {{-- الهيدر الرئيسي --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 border-gray-200">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">الدفتر المالي المطور وجرد المستودع</h1>
            <p class="text-sm text-gray-500 mt-1">Melekler Fashion - إدارة المخزون والمبيعات الحركية</p>
        </div>
    </div>

    {{-- تنبيهات النظام --}}
    @if (session('success'))
        <div class="bg-emerald-50 border-r-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-xs font-bold">✨ {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-rose-50 border-r-4 border-rose-500 text-rose-800 p-4 rounded-xl shadow-xs font-bold">⚠️ {{ session('error') }}</div>
    @endif

    {{-- ================= 💰 قسم 1: المؤشرات المادية الدقيقة ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-xs font-bold text-gray-400 block uppercase">إجمالي المبيعات</span>
            <p class="text-3xl font-black text-emerald-600 mt-2 font-mono">{{ number_format($totalSales ?? 0, 2) }} ₺</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-xs font-bold text-gray-400 block uppercase">إجمالي المصاريف التشغيلية</span>
            <p class="text-3xl font-black text-rose-600 mt-2 font-mono">{{ number_format($totalExpenses ?? 0, 2) }} ₺</p>
        </div>
        
        <div class="{{ ($netProfit ?? 0) >= 0 ? 'bg-indigo-50 border-indigo-200' : 'bg-red-50 border-red-200' }} p-6 rounded-2xl border shadow-xs">
            <span class="text-xs font-bold {{ ($netProfit ?? 0) >= 0 ? 'text-indigo-700' : 'text-red-700' }} block uppercase">صافي المربح / الخسارة</span>
            <p class="text-3xl font-black {{ ($netProfit ?? 0) >= 0 ? 'text-indigo-700' : 'text-red-700' }} mt-2 font-mono">
                {{ ($netProfit ?? 0) >= 0 ? '+' : '' }}{{ number_format($netProfit ?? 0, 2) }} ₺
            </p>
            <span class="text-[10px] text-gray-400 block mt-1">(المبيعات - تكلفة البضاعة المباعة - المصاريف)</span>
        </div>
        
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-xs font-bold text-gray-400 block uppercase">قيمة بضاعة المستودع الحالية</span>
            <p class="text-2xl font-black text-amber-600 mt-2 font-mono">{{ number_format($inventoryCostValue ?? 0, 2) }} ₺</p>
            <span class="text-[10px] text-gray-400 block mt-1">(رأس المال الفعلي المخزن بالتكلفة)</span>
        </div>
    </div>

    {{-- ================= 🛍️ قسم 2: وحدة المبيعات اليدوية الفورية (POS) ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">📦 وحدة تسجيل مبيعات يدوية (تخصم فوراً من المستودع)</h2>
        <form action="{{ url('/admin/accounting/sale') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-xl">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">كود المنتج (Barcode/Code)</label>
                <input type="text" name="product_code" placeholder="مثال: PROD-102" class="w-full rounded-lg border-gray-300 text-sm shadow-xs focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">الكمية المباعة</label>
                <input type="number" name="quantity" min="1" placeholder="1" class="w-full rounded-lg border-gray-300 text-sm shadow-xs focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1">سعر البيع الفعلي للقطعة (₺)</label>
                <input type="number" step="0.01" name="sale_price" placeholder="0.00" class="w-full rounded-lg border-gray-300 text-sm shadow-xs focus:ring-indigo-500" required>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold rounded-lg text-sm py-2.5 hover:bg-indigo-700 transition-all shadow-md">🚀 إتمام البيع والخصم</button>
            </div>
        </form>
    </div>

    {{-- ================= 📝 قسم 3: وحدة التعديل والتحديث السريع للمنتجات ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-2">⚙️ التعديل والتحديث السريع لبيانات المستودع</h2>
        <p class="text-xs text-gray-400 mb-4">يمكنك تعديل الأسعار، الأكواد، والمخزون مباشرة من الجدول والضغط على حفظ</p>
        
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-4">كود المنتج</th>
                        <th class="py-3 px-4">اسم المنتج</th>
                        <th class="py-3 px-4 text-center">اللون</th>
                        <th class="py-3 px-4 text-center">العدد المتاح</th>
                        <th class="py-3 px-4 text-center">سعر الشراء (التكلفة)</th>
                        <th class="py-3 px-4 text-center">سعر البيع المعروض</th>
                        <th class="py-3 px-4 text-center">إجمالي التكلفة</th>
                        <th class="py-3 px-4 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs">
                    @forelse($products as $product)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <form action="{{ route('admin.accounting.product.update', $product->id) }}" method="POST">
                            @csrf
                            <td class="py-2 px-2">
                                <input type="text" name="product_code" value="{{ $product->product_code }}" class="w-28 p-1 text-xs border rounded font-mono text-indigo-600 font-bold bg-white focus:ring-1 focus:ring-indigo-500">
                            </td>
                            <td class="py-2 px-2 font-medium text-gray-800 max-w-xs truncate">{{ $product->product_name }}</td>
                            <td class="py-2 px-2 text-center">
                                <input type="text" name="color" value="{{ $product->color ?? 'افتراضي' }}" class="w-20 p-1 text-xs border rounded text-center bg-white">
                            </td>
                            <td class="py-2 px-2 text-center">
                                <input type="number" name="stock" value="{{ $product->stock }}" class="w-16 p-1 text-xs border rounded text-center font-bold bg-white">
                            </td>
                            <td class="py-2 px-2 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <input type="number" step="0.01" name="cost_price" value="{{ $product->cost_price }}" class="w-20 p-1 text-xs border rounded text-center font-mono text-amber-700 font-bold bg-white">
                                    <span>₺</span>
                                </div>
                            </td>
                            <td class="py-2 px-2 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-20 p-1 text-xs border rounded text-center font-mono text-emerald-600 font-bold bg-white">
                                    <span>₺</span>
                                </div>
                            </td>
                            <td class="py-2 px-4 text-center font-mono text-gray-900 font-black bg-gray-50/50">
                                {{ number_format($product->stock * $product->cost_price, 2) }} ₺
                            </td>
                            <td class="py-2 px-2 text-center">
                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1 rounded text-[11px] font-bold shadow-xs transition-all">💾 حفظ</button>
                            </td>
                        </form>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-8 text-gray-400">المستودع فارغ تماماً.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- ================= 🏢 قسم 4: جدول جرد المستودع التفصيلي المظهر النهائي ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-4 gap-2">
            <div>
                <h2 class="text-xl font-bold text-gray-800">تفاصيل وجرد بضاعة المستودع الحالية (للقراءة والجرد)</h2>
                <p class="text-xs text-gray-400">قائمة تفصيلية مخصصة لمراجعة حالة وتصنيفات المخزون الحالية</p>
            </div>
            <span class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg font-bold">إجمالي قطع المستودع: {{ number_format($totalStockPieces ?? 0) }} قطعة</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">كود المنتج</th>
                        <th class="py-3 px-6">اسم المنتج</th>
                        <th class="py-3 px-6 text-center">اللون</th>
                        <th class="py-3 px-6 text-center">العمر / المقاس</th>
                        <th class="py-3 px-6 text-center">العدد المتاح</th>
                        <th class="py-3 px-6 text-center">سعر الشراء (التكلفة)</th>
                        <th class="py-3 px-6 text-center">سعر البيع المعروض</th>
                        <th class="py-3 px-6 text-center">إجمالي قيمة التكلفة</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs">
                    @forelse($products as $product)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-6 font-bold text-indigo-600 font-mono">{{ $product->product_code ?? 'N/A' }}</td>
                        <td class="py-3 px-6 font-medium text-gray-800">{{ $product->product_name }}</td>
                        <td class="py-3 px-6 text-center">{{ $product->color ?? 'افتراضي' }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[11px] font-bold">
                                {{ $product->product_category == 'mothers' ? 'حريمي' : 'أطفال' }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center font-bold font-mono">
                            <span class="{{ $product->stock <= 5 ? 'text-rose-600 bg-rose-50 px-2 py-1 rounded' : 'text-gray-700' }}">
                                {{ $product->stock }} قطعة
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center font-mono text-amber-700 font-bold">{{ number_format($product->cost_price, 2) }} ₺</td>
                        <td class="py-3 px-6 text-center font-mono text-emerald-600 font-bold">{{ number_format($product->price, 2) }} ₺</td>
                        <td class="py-3 px-6 text-center font-mono text-gray-900 font-black bg-gray-50/50">
                            {{ number_format($product->stock * $product->cost_price, 2) }} ₺
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-8 text-gray-400">المستودع فارغ تماماً، قم بإضافة منتجات أولاً.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= 🧾 قسم 5: المصاريف التشغيلية وحركات رأس المال جنباً إلى جنب ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- كرت إدارة المصاريف التشغيلية المنظم --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 border-b pb-3 mb-4">🧾 تسجيل وإدارة المصاريف التشغيلية</h3>
            
            {{-- فورم الإدراج الجديد --}}
            <form action="{{ url('/admin/expenses') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-gray-50 p-3 rounded-xl mb-4">
                @csrf
                <input type="hidden" name="expense_date" value="{{ date('Y-m-d') }}">
                <input type="text" name="description" placeholder="البيان (شحن، إيجار...)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <input type="number" name="amount" step="0.01" placeholder="المبلغ (₺)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <button type="submit" class="bg-rose-600 text-white font-bold rounded-lg text-xs py-2 hover:bg-rose-700 transition-all">إدراج مصروف</button>
            </form>

            {{-- جدول عرض القيود التابع للمصاريف --}}
            <div class="overflow-y-auto max-h-64">
                <table class="w-full text-right text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b">
                            <th class="pb-2">البيان</th>
                            <th class="pb-2">المبلغ</th>
                            <th class="pb-2 text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentExpenses as $exp)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 font-medium text-gray-700">{{ $exp->description }}</td>
                            <td class="py-2 font-bold text-rose-600 font-mono">{{ number_format($exp->amount, 2) }} ₺</td>
                            <td class="py-2 text-center">
                                {{-- نموذج الحذف الفوري للمصروف --}}
                                <form action="{{ route('admin.accounting.expense.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا القيد؟')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold transition-colors">✕ حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- كرت حركات رأس المال والتمويل --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 border-b pb-3 mb-4">🪙 قيود التمويل ورأس المال الفعلي</h3>
            
            <form action="{{ url('/admin/accounting/capital') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-gray-50 p-3 rounded-xl mb-4">
                @csrf
                <input type="hidden" name="transaction_date" value="{{ date('Y-m-d') }}">
                <input type="text" name="description" placeholder="البيان (رأس مال أول السلسلة)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <input type="number" name="amount" step="0.01" placeholder="المبلغ (+ أو -)" class="rounded-lg border-gray-300 text-xs shadow-xs focus:ring-indigo-500" required>
                <button type="submit" class="bg-slate-800 text-white font-bold rounded-lg text-xs py-2 hover:bg-slate-900 transition-all">إدراج قيد</button>
            </form>
            
            <div class="overflow-y-auto max-h-64">
                <table class="w-full text-right text-xs">
                    <thead>
                        <tr class="text-gray-400 border-b">
                            <th class="pb-2">البيان</th>
                            <th class="pb-2">المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($capitalTransactions as $cap)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2.5 font-medium text-gray-700">{{ $cap->description }}</td>
                            <td class="py-2.5 font-bold text-emerald-600 font-mono">{{ number_format($cap->amount, 2) }} ₺</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
