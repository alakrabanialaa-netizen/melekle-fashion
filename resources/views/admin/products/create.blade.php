@extends('admin.layouts.app')

@section('page-title', 'إضافة منتج جديد')

@section('content')
<div class="max-w-4xl mx-auto py-8">

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
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">1</span>
                    المعلومات الأساسية للمنتج
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="product_name" class="block text-sm font-bold text-gray-700 mb-2">اسم المنتج</label>
                        <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" 
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" 
                               placeholder="مثال: طقم ولادي صيفي 3 قطع" required>
                    </div>

                    <div>
                        <label for="product_category" class="block text-sm font-bold text-gray-700 mb-2">القسم الرئيسي</label>
                        <select name="product_category" id="product_category" 
                                class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none appearance-none bg-white transition-all" required>
                            <option value="">-- اختر القسم المناسب --</option>
                            <option value="girls" {{ old('product_category') == 'girls' ? 'selected' : '' }}>بنات</option>
                            <option value="boys" {{ old('product_category') == 'boys' ? 'selected' : '' }}>أولاد</option>
                            <option value="babies" {{ old('product_category') == 'babies' ? 'selected' : '' }}>مواليد / رضع</option>
                            <option value="mothers" {{ old('product_category') == 'mothers' ? 'selected' : '' }}>أمهات</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. الأسعار والمخزون --}}
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm">2</span>
                    الأسعار والمخزون
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="product_price" class="block text-sm font-bold text-gray-700 mb-2">السعر النهائي (بالأرقام)</label>
                        <input type="text" name="product_price" id="product_price" value="{{ old('product_price') }}" 
                               inputmode="decimal" placeholder="0.00"
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg" required>
                        <p class="mt-1 text-xs text-gray-500">ملاحظة: يمكنك كتابة السعر بأي لغة أرقام، سيقوم النظام بتحويلها.</p>
                    </div>
                    <div>
                        <label for="product_stock" class="block text-sm font-bold text-gray-700 mb-2">الكمية المتاحة (المخزون)</label>
                        <input type="text" name="product_stock" id="product_stock" value="{{ old('product_stock') }}" 
                               inputmode="numeric" placeholder="0"
                               class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-lg">
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
                        <label for="product_description" class="block text-sm font-bold text-gray-700 mb-2">شرح المنتج</label>
                        <textarea name="product_description" id="product_description" rows="4" 
                                  class="w-full px-4 py-3 border-gray-300 border rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all" 
                                  placeholder="اكتب تفاصيل المنتج هنا (المادة، المقاسات، إلخ...)">{{ old('product_description') }}</textarea>
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

            {{-- 4. الأزرار --}}
            <div class="flex items-center justify-center gap-6 pt-6">
                <button type="submit" class="bg-indigo-600 text-white px-12 py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 transform hover:scale-105 transition-all shadow-lg active:scale-95">
                    🚀 حفظ المنتج ونشره
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-10 py-4 rounded-xl border border-gray-300 font-bold text-gray-600 hover:bg-gray-100 transition-all">
                    إلغاء الرجوع
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
