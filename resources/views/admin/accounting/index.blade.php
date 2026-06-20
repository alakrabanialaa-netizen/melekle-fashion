@extends('admin.layouts.app')

@section('page-title', 'الدفتر المالي وجرد المستودع - Melekler')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="p-6 bg-[#fffaf0] min-h-screen" dir="rtl">

    {{-- الهيدر العلوي --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-800 flex items-center gap-2">
                <span class="text-pink-500">📦</span> الدفتر المالي المطور وجرد المستودع
            </h1>
            <p class="text-gray-400 text-xs font-bold mt-1">إدارة المخزون والمبيعات اليدوية والحسابات المالية فورياً</p>
        </div>

        <a href="{{ url('/') }}" target="_blank"
           class="group flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white px-5 py-3 rounded-2xl font-bold text-sm hover:from-pink-600 hover:to-rose-600 transition-all shadow-md">
            <i class="fas fa-globe"></i>
            <span>عرض المتجر الرئيسي</span>
        </a>
    </div>

    {{-- كروت الإحصائيات المالية للمستودع --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- إجمالي المبيعات اليدوية --}}
        <div class="bg-white p-6 rounded-[24px] border border-pink-100/40 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold mb-1">إجمالي المبيعات</h3>
                    <p class="text-3xl font-black text-gray-800">
                        {{ number_format($manualSales->sum('total_price') ?? 0, 2) }} <span class="text-sm font-bold text-gray-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center text-lg">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        {{-- إجمالي المصاريف التشغيلية --}}
        <div class="bg-white p-6 rounded-[24px] border border-pink-100/40 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold mb-1">المصاريف التشغيلية</h3>
                    <p class="text-3xl font-black text-rose-500">
                        {{ number_format($totalExpenses ?? 0, 2) }} <span class="text-sm font-bold text-rose-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>

        {{-- صافي الربح / الخسارة --}}
        <div class="bg-white p-6 rounded-[24px] border border-pink-100/40 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold mb-1">صافي الربح / الخسارة</h3>
                    @php 
                        $netProfit = ($manualSales->sum('total_price') ?? 0) - ($manualSales->sum('total_cost') ?? 0) - ($totalExpenses ?? 0);
                    @endphp
                    <p class="text-3xl font-black {{ $netProfit >= 0 ? 'text-teal-500' : 'text-red-500' }}">
                        {{ number_format($netProfit, 2) }} <span class="text-sm font-bold">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-500 flex items-center justify-center text-lg">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        {{-- قيمة بضاعة المستودع الحالية بناءً على التكلفة --}}
        <div class="bg-white p-6 rounded-[24px] border border-pink-100/40 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold mb-1">قيمة بضاعة المستودع</h3>
                    <p class="text-3xl font-black text-amber-500">
                        {{ number_format($warehouseProducts->sum(function($prod) { return $prod->quantity * $prod->purchase_price; }) ?? 0, 2) }} <span class="text-sm font-bold text-amber-400">₺</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- وحدة تسجيل المبيعات اليدوية الفورية --}}
    <div class="bg-white p-6 rounded-[28px] border border-pink-50/60 shadow-sm mb-8">
        <h3 class="text-lg font-black text-gray-800 mb-4 flex items-center gap-2">
            <span class="text-pink-500">📦</span> وحدة تسجيل مبيعات يدوية (تخصم فوراً من المستودع)
        </h3>
        <form action="{{ route('admin.sales.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">كود المنتج (Barcode/Code)</label>
                <input type="text" name="product_code" required placeholder="مثال: MK-57685" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-pink-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">الكمية المباعة</label>
                <input type="number" name="quantity" value="1" min="1" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-pink-400">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">سعر البيع الفعلي للقطعة (₺)</label>
                <input type="number" step="0.01" name="sale_price" required placeholder="0.00" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-pink-400">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold py-2.5 rounded-xl text-sm shadow-md hover:from-pink-600 hover:to-rose-600 transition-all">
                🚀 إتمام البيع والخصم
            </button>
        </form>
    </div>

    {{-- جدول التعديل السريع لبيانات المستودع الحالي --}}
    <div class="bg-white rounded-[28px] border border-pink-50/60 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-black text-gray-800 mb-1">📋 التعديل والتحديث السريع بيانات المستودع</h3>
        <p class="text-gray-400 text-xs font-bold mb-4">يمكنك تعديل الأسعار، الأكواد، والمخزون مباشرة من الجدول والضغط على حفظ</p>
        
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-bold border-b border-gray-100">
                        <th class="p-3">كود المنتج</th>
                        <th class="p-3">اسم المنتج</th>
                        <th class="p-3">اللون</th>
                        <th class="p-3">العدد المتاح</th>
                        <th class="p-3">سعر الشراء (التكلفة)</th>
                        <th class="p-3">سعر البيع المعروض</th>
                        <th class="p-3">إجمالي التكلفة</th>
                        <th class="p-3 text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                    @forelse($warehouseProducts ?? [] as $product)
                        <form action="{{ route('admin.warehouse.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <tr class="hover:bg-pink-50/10 transition-colors">
                                <td class="p-3">
                                    <input type="text" name="product_code" value="{{ $product->product_code }}" class="bg-transparent border-b border-transparent hover:border-gray-300 focus:border-pink-500 w-28 text-sm font-bold px-1 py-0.5">
                                </td>
                                <td class="p-3 text-gray-400 font-normal">{{ $product->name ?? 'افتراضي' }}</td>
                                <td class="p-3"><span class="bg-gray-100 px-2 py-1 rounded-lg text-xs">{{ $product->color ?? 'افتراضي' }}</span></td>
                                <td class="p-3">
                                    <input type="number" name="quantity" value="{{ $product->quantity }}" class="bg-transparent border-b border-transparent hover:border-gray-300 focus:border-pink-500 w-16 text-center text-sm font-bold">
                                </td>
                                <td class="p-3">
                                    <input type="number" step="0.01" name="purchase_price" value="{{ $product->purchase_price }}" class="bg-transparent border-b border-transparent hover:border-gray-300 focus:border-pink-500 w-20 text-sm font-bold text-amber-600"> ₺
                                </td>
                                <td class="p-3">
                                    <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}" class="bg-transparent border-b border-transparent hover:border-gray-300 focus:border-pink-500 w-20 text-sm font-bold text-green-600"> ₺
                                </td>
                                <td class="p-3 text-gray-800 font-black">
                                    {{ number_format($product->quantity * $product->purchase_price, 2) }} ₺
                                </td>
                                <td class="p-3 text-center">
                                    <button type="submit" class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl hover:bg-emerald-100 transition-colors text-xs flex items-center gap-1 mx-auto">
                                        <i class="fas fa-save"></i> حفظ
                                    </button>
                                </td>
                            </tr>
                        </form>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-400">لا توجد منتجات في المستودع حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- تفاصيل وجرد بضاعة المستودع الحالية (للقراءة والجرد الفعلي) --}}
    <div class="bg-white rounded-[28px] border border-pink-50/60 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-black text-gray-800 mb-1">📊 تفاصيل وجرد بضاعة المستودع الحالية (للقراءة والجرد)</h3>
        <p class="text-gray-400 text-xs font-bold mb-4">قائمة تفصيلية مخصصة لمراجعة حالة وتصنيفات المخزون الحالية</p>
        
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-bold border-b border-gray-100">
                        <th class="p-3">كود المنتج</th>
                        <th class="p-3">اسم المنتج</th>
                        <th class="p-3">اللون</th>
                        <th class="p-3">العمر / المقاس</th>
                        <th class="p-3">العدد المتاح</th>
                        <th class="p-3">سعر الشراء (التكلفة)</th>
                        <th class="p-3">سعر البيع المعروض</th>
                        <th class="p-3">إجمالي قيمة التكلفة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm font-bold text-gray-700">
                    @foreach($warehouseProducts ?? [] as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-3 text-pink-600">{{ $product->product_code }}</td>
                            <td class="p-3 text-gray-500 font-normal">{{ $product->name ?? 'افتراضي' }}</td>
                            <td class="p-3">{{ $product->color ?? 'افتراضي' }}</td>
                            <td class="p-3"><span class="bg-pink-50 text-pink-600 px-2 py-0.5 rounded-md text-xs">{{ $product->size ?? 'أطفال' }}</span></td>
                            <td class="p-3">
                                <span class="{{ $product->quantity <= 2 ? 'text-rose-500 bg-rose-50' : 'text-gray-700 bg-gray-50' }} px-2 py-1 rounded-lg">
                                    {{ $product->quantity }} قطعة
                                </span>
                            </td>
                            <td class="p-3 text-amber-600">{{ number_format($product->purchase_price, 2) }} ₺</td>
                            <td class="p-3 text-green-600">{{ number_format($product->sale_price, 2) }} ₺</td>
                            <td class="p-3 text-gray-900 font-black">{{ number_format($product->quantity * $product->purchase_price, 2) }} ₺</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- قسم تسجيل وإدارة المصاريف التشغيلية --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[28px] border border-pink-50/60 shadow-sm lg:col-span-1">
            <h3 class="text-md font-black text-gray-800 mb-4"><i class="fas fa-plus text-pink-500 ml-1"></i> تسجيل مصروف تشغيلي جديد</h3>
            <form action="{{ route('admin.expenses.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">البيان (شحن، إيجار...)</label>
                    <input type="text" name="description" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">المبلغ (₺)</label>
                    <input type="number" step="0.01" name="amount" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-pink-400">
                </div>
                <button type="submit" class="w-full bg-rose-500 text-white font-bold py-2 rounded-xl text-sm hover:bg-rose-600 transition-all">
                    إدراج مصروف
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-[28px] border border-pink-50/60 shadow-sm lg:col-span-2">
            <h3 class="text-md font-black text-gray-800 mb-4"><i class="fas fa-list text-pink-500 ml-1"></i> قيود التمويل ورأس المال الفعلي</h3>
            <div class="overflow-y-auto max-h-[220px] text-xs">
                {{-- جدول بسيط لاستعراض المصاريف المضافة حركياً --}}
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-100 pb-2">
                            <th class="pb-2">البيان</th>
                            <th class="pb-2">المبلغ</th>
                            <th class="pb-2">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @isset($expensesList)
                            @foreach($expensesList as $exp)
                                <tr>
                                    <td class="py-2 font-bold">{{ $exp->description }}</td>
                                    <td class="py-2 text-rose-500 font-bold">{{ number_format($exp->amount, 2) }} ₺</td>
                                    <td class="py-2 text-gray-400">{{ $exp->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </tr>
    </div>

</div>

@endsection
