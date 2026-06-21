@extends('admin.layouts.app')

@section('page-title', 'الدفتر المالي وجرد المستودع - Melekler')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="p-6 bg-slate-50 min-h-screen font-sans" dir="rtl">

    {{-- 🌟 قسم عرض رسائل النجاح، الأخطاء، والـ Validation 🌟 --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-bold text-sm text-right flex items-center gap-2 shadow-sm border border-emerald-200">
            <i class="fas fa-check-circle text-emerald-600 text-base"></i> 
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-100 text-rose-800 rounded-xl font-bold text-sm text-right flex items-center gap-2 shadow-sm border border-rose-200">
            <i class="fas fa-exclamation-circle text-rose-600 text-base"></i> 
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-amber-100 text-amber-800 rounded-xl font-bold text-sm text-right shadow-sm border border-amber-200">
            <div class="flex items-center gap-2 mb-2 text-amber-900 font-black">
                <i class="fas fa-exclamation-triangle"></i>
                <span>يرجى مراجعة الأخطاء التالية:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pr-2 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- 🌟 نهاية قسم الرسائل الإشعارية 🌟 --}}

    {{-- 1. الهيدر العلوي --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-slate-800 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-600"></i>
                <span>المنظومة المالية الموحدة وجرد المستودع</span>
            </h1>
            <p class="text-slate-400 text-sm font-medium mt-1">تتبع حركة التدفقات النقدية، المبيعات الفورية، وتقييم جرد المخزون الحي لـ Melekler Fashion</p>
        </div>

        <a href="{{ url('/') }}" target="_blank"
           class="flex items-center gap-2 bg-slate-900 text-white px-5 py-3 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-sm">
            <i class="fas fa-globe"></i>
            <span>عرض المتجر الرئيسي</span>
        </a>
    </div>

    {{-- 2. كروت المؤشرات المالية الحية --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- إجمالي المبيعات --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">إجمالي المبيعات اليدوية</p>
                <p class="text-2xl font-black text-slate-800">
                    {{ number_format($manualSales->sum('total_price') ?? 0, 2) }} <span class="text-xs text-slate-400">₺</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fas fa-cash-register"></i>
            </div>
        </div>

        {{-- المصاريف التشغيلية --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">المصاريف التشغيلية</p>
                <p class="text-2xl font-black text-rose-600">
                    {{ number_format($totalExpenses ?? 0, 2) }} <span class="text-xs text-rose-400">₺</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>

        {{-- صافي الأرباح --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">صافي الربح الفعلي</p>
                @php 
                    $netProfit = ($manualSales->sum('total_price') ?? 0) - ($manualSales->sum('total_cost') ?? 0) - ($totalExpenses ?? 0);
                @endphp
                <p class="text-2xl font-black {{ $netProfit >= 0 ? 'text-teal-600' : 'text-rose-600' }}">
                    {{ number_format($netProfit, 2) }} <span class="text-xs">₺</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl {{ $netProfit >= 0 ? 'bg-teal-50 text-teal-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center text-xl">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>

        {{-- تقييم بضاعة المستودع --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">قيمة المخزون (بالتكلفة)</p>
                <p class="text-2xl font-black text-blue-600">
                    {{ number_format($warehouseProducts->sum(function($prod) { return (int)$prod->stock * (float)$prod->cost_price; }) ?? 0, 2) }} <span class="text-xs text-blue-400">₺</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-warehouse"></i>
            </div>
        </div>

    </div>

    {{-- 3. وحدة تسجيل المبيعات السريعة والخصم من المستودع --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mb-8">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
            <h3 class="text-lg font-bold text-slate-800">وحدة البيع المباشر والخصم الفوري للمخزون</h3>
        </div>
        
        <form action="{{ route('admin.sales.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2">كود منتج المستودع (Barcode / Code)</label>
                <input type="text" name="product_code" required placeholder="مثال: MK-57685" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2">الكمية المباعة</label>
                <input type="number" name="quantity" value="1" min="1" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-indigo-500 transition-all text-center">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2">سعر البيع الفعلي المحصل (₺)</label>
                <input type="number" step="0.01" name="sale_price" required placeholder="0.00" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-indigo-500 transition-all">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                <i class="fas fa-check-circle"></i> إتمام حركة البيع والخصم
            </button>
        </form>
    </div>

    {{-- 4. لوحة الإدارة السريعة لتحديث بيانات المستودع --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-6 bg-slate-800 rounded-full"></div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">التعديل الحركي السريع لبيانات بضاعة المستودع</h3>
                    <p class="text-slate-400 text-xs font-medium">يمكن تحديث الأكواد، المخزون، والأسعار وحفظها لكل سطر منفصلاً تلقائياً</p>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold border-b border-slate-100">
                        <th class="p-4">كود الصنف</th>
                        <th class="p-4">اسم المنتج الرسمي</th>
                        <th class="p-4">اللون</th>
                        <th class="p-4 text-center">المخزون الحالي</th>
                        <th class="p-4">سعر التكلفة (الشراء)</th>
                        <th class="p-4">سعر البيع المعروض</th>
                        <th class="p-4">إجمالي رأس المال فيه</th>
                        <th class="p-4 text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($warehouseProducts ?? [] as $product)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- نموذج مخفي مستقل تماماً خارج خلايا الجدول لضمان توافقية التحديث --}}
                            <form id="form-update-{{ $product->id }}" action="{{ route('admin.warehouse.update', $product->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('PUT')
                            </form>

                            <td class="p-4">
                                <input type="text" name="product_code" form="form-update-{{ $product->id }}" value="{{ $product->product_code }}" class="bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg w-32 text-xs font-bold px-2 py-1 focus:outline-none">
                            </td>
                            <td class="p-4 text-slate-500 font-normal">
                                {{ $product->product_name ?? $product->name ?? 'صنف غير مسمى' }}
                            </td>
                            <td class="p-4">
                                <input type="text" name="color" form="form-update-{{ $product->id }}" value="{{ $product->color ?? 'افتراضي' }}" class="bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg w-20 text-xs font-bold px-2 py-1 focus:outline-none">
                            </td>
                            <td class="p-4 text-center">
                                <input type="number" name="stock" form="form-update-{{ $product->id }}" value="{{ $product->stock }}" class="bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg w-16 text-center text-xs font-black text-slate-800">
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-1">
                                    <input type="number" step="0.01" name="cost_price" form="form-update-{{ $product->id }}" value="{{ $product->cost_price ?? 0 }}" class="bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg w-20 text-xs font-bold text-amber-600 px-2 py-1">
                                    <span class="text-xs text-slate-400">₺</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-1">
                                    <input type="number" step="0.01" name="price" form="form-update-{{ $product->id }}" value="{{ $product->price ?? 0 }}" class="bg-slate-50 border border-slate-200 focus:border-indigo-500 rounded-lg w-20 text-xs font-bold text-emerald-600 px-2 py-1">
                                    <span class="text-xs text-slate-400">₺</span>
                                </div>
                            </td>
                            <td class="p-4 text-slate-900 font-black">
                                {{ number_format((int)$product->stock * (float)($product->cost_price ?? 0), 2) }} ₺
                            </td>
                            <td class="p-4 text-center">
                                <button type="submit" form="form-update-{{ $product->id }}" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition-colors text-xs flex items-center gap-1 mx-auto font-bold shadow-sm">
                                    <i class="fas fa-sync-alt"></i> تحديث
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-medium">لا توجد منتجات مسجلة بالمستودع حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 5. قسم إدارة وتسجيل المصاريف التشغيلية --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- كرت الإضافة --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm lg:col-span-1 h-fit">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-plus-circle text-rose-500"></i>
                <h3 class="text-md font-bold text-slate-800">تسجيل قيد مصروفات تشغيلية</h3>
            </div>
            
            <form action="{{ route('admin.expenses.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">بيان المصروف (شحن، إيجار، إعلانات...)</label>
                    <input type="text" name="description" required placeholder="مثال: تكلفة شحن البضاعة" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">المبلغ المخصوع (₺)</label>
                    <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-indigo-500 transition-all">
                </div>
                <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-2.5 rounded-xl text-sm shadow-sm transition-all">
                    إدراج وقيد المصروف فوراً
                </button>
            </form>
        </div>

        {{-- جدول استعراض القيود السابقة للمصاريف --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-receipt text-slate-700"></i>
                <h3 class="text-md font-bold text-slate-800">سجل القيود المالية والمصاريف الأخيرة</h3>
            </div>
            
            <div class="overflow-y-auto max-h-[250px] border border-slate-50 rounded-xl">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-xs font-bold border-b border-slate-100">
                            <th class="p-3">بيان الحركة</th>
                            <th class="p-3">المبلغ المقتطع</th>
                            <th class="p-3">التاريخ والوقت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs font-bold text-slate-700">
                        @isset($expensesList)
                            @forelse($expensesList as $exp)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="p-3 text-slate-800 font-bold">{{ $exp->description }}</td>
                                    <td class="p-3 text-rose-500 font-extrabold">{{ number_format($exp->amount, 2) }} ₺</td>
                                    <td class="p-3 text-slate-400 font-medium">{{ $exp->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-slate-400">لم يتم تسجيل أي مصاريف تشغيلية بعد.</td>
                                </tr>
                            @endforelse
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection
