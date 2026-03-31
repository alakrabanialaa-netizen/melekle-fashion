@extends('admin.layouts.app')

@section('page-title', 'المنتجات')

@section('content')

<div x-data="{ layout: 'grid' }" class="w-full">

    {{-- رأس الصفحة --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-gray-800">المنتجات</h2>
                <p class="text-sm text-gray-500 mt-1">إدارة جميع منتجات المتجر</p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i>
                إضافة منتج
            </a>
        </div>

        {{-- البحث + نوع العرض --}}
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-white rounded-2xl shadow-sm border">
            <input type="text"
                   placeholder="بحث عن منتج..."
                   class="bg-gray-50 rounded-xl px-4 py-2 w-full md:w-72">

            <div class="flex gap-2 bg-gray-100 p-1 rounded-xl">
                <button @click="layout='grid'"
                        :class="layout==='grid' ? 'bg-white text-indigo-600' : 'text-gray-500'"
                        class="w-10 h-9 rounded-lg">
                    <i class="fas fa-th-large"></i>
                </button>
                <button @click="layout='list'"
                        :class="layout==='list' ? 'bg-white text-indigo-600' : 'text-gray-500'"
                        class="w-10 h-9 rounded-lg">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= GRID VIEW ================= --}}
    <div x-show="layout === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow border overflow-hidden group">

                {{-- الصورة الكبيرة --}}
                <img src="{{ $product->images->count() ? Storage::url($product->images->first()->image) : 'https://via.placeholder.com/400x300' }}"
                     class="w-full h-48 object-cover">

                {{-- تفاصيل المنتج --}}
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 truncate">{{ $product->name }}</h3>
                    <p class="mt-2 font-bold text-indigo-600">{{ number_format($product->price, 2) }} $</p>
                    <p class="mt-1 text-sm">
                        @if($product->stock > 10)
                            <span class="text-green-600 font-bold">متوفر ({{ $product->stock }})</span>
                        @elseif($product->stock > 0)
                            <span class="text-yellow-600 font-bold">مخزون منخفض ({{ $product->stock }})</span>
                        @else
                            <span class="text-red-600 font-bold">نفد المخزون</span>
                        @endif
                    </p>

                    {{-- الصور الصغيرة --}}
                    @if($product->images->count() > 1)
                        <div class="flex gap-2 mt-2 overflow-x-auto">
                            @foreach($product->images as $img)
                                <img src="{{ Storage::url($img->image) }}" alt="صورة المنتج"
                                     class="w-16 h-16 object-cover rounded flex-shrink-0">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- أزرار تعديل وحذف --}}
                <div class="p-3 bg-gray-50 border-t flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</a>

                    <form method="POST"
                          action="{{ route('admin.products.destroy', $product) }}"
                          style="display:inline"
                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">حذف</button>
                    </form>
                </div>

            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-20">لا يوجد منتجات</div>
        @endforelse
    </div>

    {{-- ================= LIST VIEW ================= --}}
    <div x-show="layout === 'list'" class="bg-white rounded-2xl shadow border overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500">
                <tr>
                    <th class="px-6 py-4">المنتج</th>
                    <th class="px-6 py-4">السعر</th>
                    <th class="px-6 py-4">المخزون</th>
                    <th class="px-6 py-4 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->images->count() ? Storage::url($product->images->first()->image) : 'https://via.placeholder.com/60' }}"
                                 class="w-12 h-12 rounded object-cover">
                            <span class="font-bold">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-indigo-600">{{ number_format($product->price, 2) }} $</td>
                    <td class="px-6 py-4">
                        @if($product->stock > 10)
                            <span class="text-green-600 font-bold">متوفر</span>
                        @elseif($product->stock > 0)
                            <span class="text-yellow-600 font-bold">منخفض</span>
                        @else
                            <span class="text-red-600 font-bold">نفد</span>
                        @endif
                    </td>
                   <td class="px-6 py-4 text-center">
    <div class="flex justify-center gap-2">
        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="bg-blue-500 text-white px-3 py-1 rounded">تعديل</a>

        <a href="#"
           onclick="event.preventDefault(); if(confirm('هل أنت متأكد؟')){ document.getElementById('del-{{ $product->id }}').submit(); }"
           class="bg-red-600 text-white px-3 py-1 rounded">حذف</a>

        <form id="del-{{ $product->id }}"
      method="POST"
      action="{{ route('admin.products.destroy', $product) }}">
            @csrf
            @method('DELETE')
        </form>
    </div>
</td>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-gray-500">لا يوجد منتجات</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>

@endsection