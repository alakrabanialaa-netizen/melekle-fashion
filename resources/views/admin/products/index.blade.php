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
                   class="bg-gray-50 rounded-xl px-4 py-2 w-full md:w-72 border-none focus:ring-2 focus:ring-indigo-500">

            <div class="flex gap-2 bg-gray-100 p-1 rounded-xl">
                <button @click="layout='grid'"
                        :class="layout==='grid' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500'"
                        class="w-10 h-9 rounded-lg transition-all">
                    <i class="fas fa-th-large"></i>
                </button>
                <button @click="layout='list'"
                        :class="layout==='list' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500'"
                        class="w-10 h-9 rounded-lg transition-all">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= GRID VIEW ================= --}}
    <div x-show="layout === 'grid'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                {{-- الصورة الكبيرة --}}
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $product->images->count() ? Storage::url($product->images->first()->image) : 'https://via.placeholder.com/400x300' }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>

                {{-- تفاصيل المنتج --}}
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 truncate">{{ $product->name }}</h3>
                    <p class="mt-2 font-black text-indigo-600 text-lg">{{ number_format($product->price, 2) }} $</p>
                    
                    <div class="mt-2">
                        @if($product->stock > 10)
                            <span class="text-[10px] bg-green-50 text-green-600 px-2 py-1 rounded-lg font-bold">متوفر ({{ $product->stock }})</span>
                        @elseif($product->stock > 0)
                            <span class="text-[10px] bg-yellow-50 text-yellow-600 px-2 py-1 rounded-lg font-bold">مخزون منخفض ({{ $product->stock }})</span>
                        @else
                            <span class="text-[10px] bg-red-50 text-red-600 px-2 py-1 rounded-lg font-bold">نفد المخزون</span>
                        @endif
                    </div>
                </div>

                {{-- أزرار التحكم القابلة للظهور عند التحويم --}}
                <div class="p-3 bg-gray-50 border-t flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="flex-1 bg-white border border-blue-200 text-blue-600 text-center py-2 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition">تعديل</a>

                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('هل أنت متأكد من الحذف؟')"
                                class="w-full bg-white border border-red-200 text-red-600 py-2 rounded-xl text-sm font-bold hover:bg-red-600 hover:text-white transition">حذف</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-20 bg-white rounded-3xl border border-dashed">لا يوجد منتجات حالياً</div>
        @endforelse
    </div>

    {{-- ================= LIST VIEW ================= --}}
    <div x-show="layout === 'list'" 
         x-transition:enter="transition ease-out duration-300"
         class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-right">
            <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500 border-b">
                <tr>
                    <th class="px-6 py-4">المنتج</th>
                    <th class="px-6 py-4">السعر</th>
                    <th class="px-6 py-4">المخزون</th>
                    <th class="px-6 py-4 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @foreach($products as $product)
                <tr class="hover:bg-indigo-50/30 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->images->count() ? Storage::url($product->images->first()->image) : 'https://via.placeholder.com/60' }}"
                                 class="w-12 h-12 rounded-xl object-cover shadow-sm">
                            <span class="font-bold text-gray-700">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-black text-indigo-600">{{ number_format($product->price, 2) }} $</td>
                    <td class="px-6 py-4">
                        @if($product->stock > 10)
                            <span class="text-green-600 text-sm font-bold">متوفر</span>
                        @elseif($product->stock > 0)
                            <span class="text-yellow-600 text-sm font-bold">منخفض</span>
                        @else
                            <span class="text-red-600 text-sm font-bold">نفد</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('هل أنت متأكد؟')"
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>

@endsection
