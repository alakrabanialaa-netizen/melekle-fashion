@extends('admin.layouts.app')

@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="max-w-5xl mx-auto py-8" dir="rtl">

    {{-- رسائل الأخطاء (Validation Errors) --}}
    @if ($errors->any())
        <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
            <p class="font-bold mb-2 text-lg">⚠️ يرجى تصحيح الأخطاء التالية:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- رسالة خطأ من السيرفر --}}
    @if (session('error'))
        <div class="bg-red-600 text-white p-4 rounded-lg mb-6 shadow-md text-center font-bold">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-xl space-y-10 border border-gray-100">
        @csrf

        <div class="space-y-8">

            {{-- 1. المعلومات الأساسية --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                    المعلومات الأساسية والفيئة
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="product_code" class="block text-sm font-bold text-gray-700 mb-2">كود المنتج (SKU / Barcode) <span class="text-rose-500">*</span></label>
                        <input type="text" name="product_code" id="product_code" value="{{ old('product_code') }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-mono font-bold" 
                               placeholder="مثال: MELEK-101" required>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">اسم المنتج <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" 
                               placeholder="مثال: حقيبة يد جلدية / طقم نسائي" required>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">القسم الرئيسي <span class="text-rose-500">*</span></label>
                        <select name="category" id="category" 
                                class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none appearance-none bg-white transition-all font-medium" required>
                            <option value="">-- اختر القسم المناسب --</option>
                            <optgroup label="الألبسة والموضة">
                                <option value="women" {{ old('category') == 'women' ? 'selected' : '' }}>نسائي</option>
                                <option value="girls" {{ old('category') == 'girls' ? 'selected' : '' }}>بناتي</option>
                                <option value="boys" {{ old('category') == 'boys' ? 'selected' : '' }}>أولادي</option>
                                <option value="babies" {{ old('category') == 'babies' ? 'selected' : '' }}>مواليد / رضع</option>
                                <option value="mothers" {{ old('category') == 'mothers' ? 'selected' : '' }}>أمهات / حوامل</option>
                            </optgroup>
                            <optgroup label="الإكسسوارات والحقائب">
                                <option value="bags" {{ old('category') == 'bags' ? 'selected' : '' }}>حقائب وشنط</option>
                                <option value="shoes" {{ old('category') == 'shoes' ? 'selected' : '' }}>أحذية</option>
                                <option value="accessories" {{ old('category') == 'accessories' ? 'selected' : '' }}>إكسسوارات</option>
                            </optgroup>
                            <optgroup label="العروض الخاصة والتصفية">
                                <option value="turkish_offers" {{ old('category') == 'turkish_offers' ? 'selected' : '' }}>🇹🇷 عروض تركية خاصة</option>
                                <option value="stocks" {{ old('category') == 'stocks' ? 'selected' : '' }}>📦 ستوكات وتصفية</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. الأسعار والمخزون --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                    الأسعار والمخزون والتفاصيل
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="cost_price" class="block text-sm font-bold text-gray-700 mb-2">سعر التكلفة (₺) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" 
                               placeholder="0.00"
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-amber-700" required>
                    </div>

                    <div>
                        <label for="original_price" class="block text-sm font-bold text-gray-700 mb-2">السعر قبل الخصم (₺)</label>
                        <input type="number" step="0.01" name="original_price" id="original_price" value="{{ old('original_price') }}" 
                               placeholder="0.00"
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-gray-400 line-through">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">سعر البيع النهائي (₺) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" 
                               placeholder="0.00"
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-emerald-600" required>
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">الكمية المتاحة</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" 
                               placeholder="0"
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-gray-800">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="color" class="block text-sm font-bold text-gray-700 mb-2">اللون / الألوان المتاحة</label>
                        <input type="text" name="color" id="color" value="{{ old('color') }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all" 
                               placeholder="مثال: أسود، بيج، بني">
                    </div>
                    <div>
                        <label for="badge_text" class="block text-sm font-bold text-gray-700 mb-2">نص الشارة المميزة (Badge)</label>
                        <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text') }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all" 
                               placeholder="مثال: عرض خاص ⚡ / ستوك ممتاز / الأكثر مبيعاً">
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-400">💡 إدخال سعر التكلفة بدقة يساعد في حساب الأرباح التلقائية في النظام.</p>
            </div>

            {{-- 3. الوصف والوسائط --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">3</span>
                    الصور والوصف
                </h2>
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">تفاصيل وشرح المنتج</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all" 
                                  placeholder="اكتب تفاصيل المنتج (نوع القماش/الجلد، بلد التصنيع، تفاصيل العرض أو الستوك...)">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">صور المنتج (متعدد)</label>
                            <div class="relative border-2 border-dashed border-indigo-300 rounded-xl p-4 hover:bg-indigo-50 transition-colors">
                                <input type="file" name="images[]" multiple required accept="image/*" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="text-center">
                                    <svg class="mx-auto h-10 w-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-1 text-sm text-gray-600 font-medium">اضغط لرفع الصور أو اسحبها هنا</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="video" class="block text-sm font-bold text-gray-700 mb-2">فيديو المنتج (اختياري)</label>
                            <input type="file" name="video" id="video" accept="video/*" 
                                   class="w-full border-gray-300 border rounded-xl p-2.5 bg-white shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. المقاسات والخيارات المتنوعة --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">4</span>
                    المقاسات والأبعاد (حسب نوع المنتج)
                </h2>
                
                <div class="space-y-6">
                    {{-- المقاسات القياسية (نسائي / ألبسة عامة) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">مقاسات الألبسة العامة والنسائية</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', 'One Size (قياس موحد)'] as $size)
                                <label class="inline-flex items-center p-3 bg-white border rounded-xl cursor-pointer hover:border-indigo-500 transition-all shadow-sm">
                                    <input type="checkbox" name="sizes[]" value="{{ $size }}" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="mr-2.5 font-bold text-gray-700 text-sm">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    {{-- مقاسات الأطفال --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">أعمار ومقاسات الأطفال والمواليد</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @php
                                $ages = [
                                    'newborn' => 'حديث ولادة',
                                    '0-3m' => '0-3 أشهر',
                                    '3-6m' => '3-6 أشهر',
                                    '6-12m' => '6-12 شهر',
                                    '1-2y' => '1-2 سنة',
                                    '2-3y' => '2-3 سنوات',
                                    '3-4y' => '3-4 سنوات',
                                    '4-5y' => '4-5 سنوات',
                                    '6-7y' => '6-7 سنوات',
                                    '8-9y' => '8-9 سنوات',
                                    '10-12y' => '10-12 سنة',
                                    '13-16y' => '13-16 سنة'
                                ];
                            @endphp

                            @foreach($ages as $value => $label)
                                <label class="inline-flex items-center p-3 bg-white border rounded-xl cursor-pointer hover:border-indigo-500 transition-all shadow-sm">
                                    <input type="checkbox" name="ages[]" value="{{ $value }}" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="mr-2.5 text-sm font-bold text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. الأزرار --}}
            <div class="flex items-center justify-center gap-6 pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-12 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transform hover:scale-105 transition-all shadow-lg active:scale-95">
                    🚀 حفظ المنتج ونشره
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-10 py-4 rounded-xl border border-gray-300 font-bold text-gray-600 hover:bg-gray-100 transition-all">
                    إلغاء والرجوع
                </a>
            </div>

        </div>
    </form>
</div>
@endsection
