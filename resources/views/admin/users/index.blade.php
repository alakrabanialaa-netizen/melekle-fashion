@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-lg">

    {{-- الرأس وعنوان الصفحة --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-warehouse text-pink-500"></i> إدارة مخزون المستودع وجرد البضاعة
            </h1>
            <p class="text-xs text-gray-400 mt-1">تابع وتتبع كميات بضاعة Melekler Fashion وتحديثها بشكل فوري.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-pink-500 text-white px-5 py-2.5 rounded-xl hover:bg-pink-600 font-bold transition flex items-center gap-2 shadow-sm">
            <i class="fas fa-plus text-xs"></i> إضافة منتج جديد
        </a>
    </div>

    {{-- 🔎 شريط البحث الذكي والفلترة --}}
    <div class="bg-gray-50 p-4 rounded-xl mb-6 grid grid-cols-1 md:grid-cols-3 gap-4 items-center border border-gray-100">
        <div class="relative">
            <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="warehouse-search" placeholder="ابحث باسم المنتج أو الكود (SKU)..." 
                   class="w-full pr-10 pl-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500 transition">
        </div>
        
        <div>
            <select id="stock-filter" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500 transition font-bold text-gray-600">
                <option value="all">عرض كل البضاعة</option>
                <option value="available">المنتجات المتوفرة فقط</option>
                <option value="low">المنتجات التي أوشكت على النفاذ (≤ 5)</option>
                <option value="out">المنتجات المنتهية (0)</option>
            </select>
        </div>

        <div class="text-left text-xs font-bold text-gray-400">
            إجمالي المواد الفريدة: <span class="text-gray-700 text-sm" id="items-count">{{ $products->count() }}</span>
        </div>
    </div>

    {{-- رسائل النظام التقليدية --}}
    @if (session('success'))
        <div class="bg-green-50 border-r-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 text-right font-bold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- 📊 جدول جرد المستودع المطور --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
        <table class="w-full text-right border-collapse bg-white" id="warehouse-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-gray-600 font-bold text-sm">
                    <th class="p-4">الصورة</th>
                    <th class="p-4">اسم المنتج</th>
                    <th class="p-4">كود المنتج (SKU)</th>
                    <th class="p-4 text-center">اللون</th>
                    <th class="p-4 text-center">المقاس</th>
                    <th class="p-4 text-center w-40">الكمية بالمستودع</th>
                    <th class="p-4 text-center">حالة المخزون</th>
                    <th class="p-4 text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-gray-700 text-sm">
                @forelse($products as $product)
                    <tr class="product-row hover:bg-gray-50/70 transition" 
                        data-name="{{ strtolower($product->name) }}" 
                        data-code="{{ strtolower($product->code ?? $product->sku ?? '') }}"
                        data-status="@if($product->quantity == 0) out @elseif($product->quantity <= 5) low @else available @endif">
                        
                        {{-- صورة المنتج --}}
                        <td class="p-4">
                            @php
                                $imageUrl = 'https://via.placeholder.com/150';
                                if ($product->image) {
                                    $imageUrl = (str_starts_with($product->image, 'http')) ? $product->image : asset('storage/' . $product->image);
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg shadow-sm">
                        </td>
                        
                        {{-- اسم المنتج --}}
                        <td class="p-4 font-bold text-gray-900 product-name-cell">{{ $product->name }}</td>
                        
                        {{-- كود المنتج --}}
                        <td class="p-4 font-mono text-gray-500 product-code-cell">{{ $product->code ?? $product->sku ?? 'N/A' }}</td>
                        
                        {{-- اللون --}}
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-bold">
                                {{ $product->color ?? 'غير محدد' }}
                            </span>
                        </td>
                        
                        {{-- المقاس --}}
                        <td class="p-4 text-center font-bold text-gray-600">
                            {{ $product->size ?? 'Global' }}
                        </td>
                        
                        {{-- ⚡ أزرار التحديث السريع عبر الأجاكس (+ / -) --}}
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2 border border-gray-200 rounded-xl p-1 bg-gray-50 max-w-[130px] mx-auto shadow-inner">
                                <button type="button" class="update-stock-btn w-7 h-7 flex items-center justify-center bg-white rounded-lg border text-gray-600 hover:bg-red-50 hover:text-red-500 transition font-bold" 
                                        data-id="{{ $product->id }}" data-action="decrease">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                
                                <span class="stock-display font-black text-sm text-gray-800 px-2 min-w-[28px]" id="stock-count-{{ $product->id }}">
                                    {{ $product->quantity }}
                                </span>
                                
                                <button type="button" class="update-stock-btn w-7 h-7 flex items-center justify-center bg-white rounded-lg border text-gray-600 hover:bg-green-50 hover:text-green-600 transition font-bold" 
                                        data-id="{{ $product->id }}" data-action="increase">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </td>
                        
                        {{-- شارة حالة المخزون التفاعلية --}}
                        <td class="p-4 text-center status-badge-cell">
                            @if($product->quantity == 0)
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-black status-tag">منتهي</span>
                            @elseif($product->quantity <= 5)
                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-black status-tag">وشك النفاذ</span>
                            @else
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-black status-tag">متوفر</span>
                            @endif
                        </td>
                        
                        {{-- العمليات القياسية --}}
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="تعديل تفاصيل المنتج">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج نهائياً من المستودع؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="حذف">
                                        <i class="fas fa-trash-alt text-base"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="no-products-row">
                        <td colspan="8" class="text-center p-8 text-gray-400">
                            <i class="fas fa-box-open text-4xl mb-3 block text-gray-200"></i>
                            لا توجد منتجات مسجلة بالمستودع حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- 🛠️ محرك الأجاكس والفلترة الفورية (jQuery Script) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // 1. نظام الفلترة والبحث الفوري بدون تحديث الصفحة
    function filterWarehouse() {
        const searchTerm = $('#warehouse-search').val().toLowerCase().trim();
        const filterStatus = $('#stock-filter').val();
        let visibleCount = 0;

        $('.product-row').each(function() {
            const row = $(this);
            const name = row.data('name');
            const code = row.data('code');
            const status = row.data('status');

            const matchesSearch = name.includes(searchTerm) || code.includes(searchTerm);
            const matchesStatus = (filterStatus === 'all') || (status === filterStatus);

            if (matchesSearch && matchesStatus) {
                row.show();
                visibleCount++;
            } else {
                row.hide();
            }
        });
        
        $('#items-count').text(visibleCount);
    }

    $('#warehouse-search').on('input', filterWarehouse);
    $('#stock-filter').on('change', filterWarehouse);

    // 2. معالج الأجاكس السريع لتحديث مخزون قطع المستودع (+ / -)
    $('.update-stock-btn').on('click', function() {
        const button = $(this);
        const productId = button.data('id');
        const action = button.data('action');
        const displaySpan = $(`#stock-count-${productId}`);
        const row = button.closest('.product-row');
        const badgeCell = row.find('.status-badge-cell');
        
        // تعطيل الزر مؤقتاً لمنع التكرار المفرط أثناء الإرسال
        button.prop('disabled', true);

        $.ajax({
            url: `/admin/products/${productId}/update-stock`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: action
            },
            success: function(response) {
                if(response.status === 'success') {
                    // تحديث الرقم في العرض
                    displaySpan.text(response.new_quantity);
                    
                    // تحديث خاصية حالة المخزون في السطر لتعمل الفلترة بشكل صحيح
                    let newStatus = 'available';
                    if(response.new_quantity == 0) newStatus = 'out';
                    else if(response.new_quantity <= 5) newStatus = 'low';
                    row.data('status', newStatus);

                    // تحديث شكل الشارة الملونة للمخزون تلقائياً
                    if(response.new_quantity == 0) {
                        badgeCell.html('<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-black status-tag">منتهي</span>');
                        displaySpan.removeClass('text-gray-800').addClass('text-red-500');
                    } else if(response.new_quantity <= 5) {
                        badgeCell.html('<span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-black status-tag">وشك النفاذ</span>');
                        displaySpan.removeClass('text-gray-800').addClass('text-red-500');
                    } else {
                        badgeCell.html('<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-black status-tag">متوفر</span>');
                        displaySpan.removeClass('text-red-500').addClass('text-gray-800');
                    }
                }
                button.prop('disabled', false);
            },
            error: function(xhr) {
                console.error('فشل تحديث كمية المستودع الرقمية.');
                button.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection
