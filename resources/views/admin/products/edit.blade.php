@extends('admin.layouts.app')

@section('page-title', 'تعديل المنتج: ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto py-8" dir="rtl">

    {{-- رسائل الأخطاء (Validation Errors) --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
            <p class="font-bold mb-2 text-lg">⚠️ يرجى تصحيح الأخطاء التالية:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-xl space-y-10 border border-gray-100">
        @csrf
        @method('PUT')

        <div class="space-y-8">

            {{-- 1. المعلومات الأساسية --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">1</span>
                    المعلومات الأساسية للمنتج
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="product_code" class="block text-sm font-bold text-gray-700 mb-2">كود المنتج (Barcode / SKU) <span class="text-rose-500">*</span></label>
                        <input type="text" name="product_code" id="product_code" value="{{ old('product_code', $product->product_code) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-mono font-bold" required>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">اسم المنتج <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-2">القسم الرئيسي <span class="text-rose-500">*</span></label>
                        <select name="category" id="category" 
                                class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none appearance-none bg-white transition-all" required>
                            <option value="">-- اختر القسم المناسب --</option>
                            <option value="girls" {{ old('category', $product->category) == 'girls' ? 'selected' : '' }}>بنات</option>
                            <option value="boys" {{ old('category', $product->category) == 'boys' ? 'selected' : '' }}>أولاد</option>
                            <option value="babies" {{ old('category', $product->category) == 'babies' ? 'selected' : '' }}>مواليد / رضع</option>
                            <option value="mothers" {{ old('category', $product->category) == 'mothers' ? 'selected' : '' }}>أمهات</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. الأسعار والمخزون والتفاصيل المادية --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">2</span>
                    الأسعار والمخزون والتفاصيل المادية
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="cost_price" class="block text-sm font-bold text-gray-700 mb-2">سعر الشراء / التكلفة (₺) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="cost_price" id="cost_price" value="{{ old('cost_price', $product->cost_price) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-amber-700" required>
                    </div>

                    <div>
                        <label for="original_price" class="block text-sm font-bold text-gray-700 mb-2">السعر الأصلي (قبل الخصم)</label>
                        <input type="number" step="0.01" name="original_price" id="original_price" value="{{ old('original_price', $product->original_price) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-gray-500">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">سعر البيع النهائي (₺) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-emerald-600" required>
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-bold text-gray-700 mb-2">الكمية المتاحة (المخزون)</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg font-bold text-gray-800">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="color" class="block text-sm font-bold text-gray-700 mb-2">اللون الأساسي</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $product->color) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all" 
                               placeholder="مثال: أحمر / منقّط">
                    </div>
                    <div>
                        <label for="badge_text" class="block text-sm font-bold text-gray-700 mb-2">نص الشارة (Badge)</label>
                        <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $product->badge_text) }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all" 
                               placeholder="مثال: الأكثر مبيعاً">
                    </div>
                </div>
            </div>

            {{-- 3. الوصف والملفات --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">3</span>
                    الصور والوصف
                </h2>
                <div class="space-y-8">
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">شرح المنتج</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">إضافة صور جديدة (اختياري)</label>
                            <div class="relative border-2 border-dashed border-indigo-300 rounded-xl p-4 hover:bg-indigo-50 transition-colors">
                                <input type="file" name="images[]" multiple accept="image/*" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="text-center">
                                    <svg class="mx-auto h-10 w-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-1 text-sm text-gray-600 font-medium">اضغط لرفع صور إضافية</p>
                                </div>
                            </div>
                            
                            {{-- عرض الصور الحالية المستضافة على Cloudinary --}}
                            @if($product->images && $product->images->count() > 0)
                                <div class="mt-4">
                                    <p class="text-xs font-bold text-gray-500 mb-2">الصور الحالية للمنتج:</p>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($product->images as $image)
                                            <div class="relative">
                                                <img src="{{ $image->image }}" class="w-20 h-20 object-cover rounded-xl border shadow-sm">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="video" class="block text-sm font-bold text-gray-700 mb-2">استبدال فيديو المنتج (اختياري)</label>
                            <input type="file" name="video" id="video" accept="video/*" 
                                   class="w-full border-gray-300 border rounded-xl p-2.5 bg-white shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @if($product->video)
                                <div class="mt-3">
                                    <a href="{{ $product->video }}" target="_blank" class="text-xs text-indigo-600 font-bold underline flex items-center gap-1">
                                        🎥 استعراض الفيديو الحالي للمنتج
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. المقاسات والأعمار --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">4</span>
                    المقاسات والأعمار المتاحة
                </h2>
                
                <div class="space-y-6">
                    {{-- مقاسات الملابس العالمية --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">المقاسات (للأمهات أو المقاسات العامة)</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <label class="inline-flex items-center p-3 bg-white border rounded-xl cursor-pointer hover:border-indigo-500 transition-all shadow-sm">
                                    <input type="checkbox" name="sizes[]" value="{{ $size }}" 
                                           {{ in_array($size, (array)old('sizes', $product->sizes ?? [])) ? 'checked' : '' }}
                                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="mr-3 font-bold text-gray-700">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    {{-- مقاسات الأطفال بالأعمار --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">الأعمار المتاحة (للأطفال والمواليد)</label>
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
                                    '10-12y' => '10-12 سنة'
                                ];
                            @endphp

                            @foreach($ages as $value => $label)
                                <label class="inline-flex items-center p-3 bg-white border rounded-xl cursor-pointer hover:border-indigo-500 transition-all shadow-sm">
                                    <input type="checkbox" name="ages[]" value="{{ $value }}" 
                                           {{ in_array($value, (array)old('ages', $product->ages ?? [])) ? 'checked' : '' }}
                                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span class="mr-3 text-sm font-bold text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. الأزرار --}}
            <div class="flex items-center justify-center gap-6 pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-12 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transform hover:scale-105 transition-all shadow-lg active:scale-95">
                    💾 حفظ التعديلات المحدثة
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-10 py-4 rounded-xl border border-gray-300 font-bold text-gray-600 hover:bg-gray-100 transition-all">
                    إلغاء والتراجع
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
