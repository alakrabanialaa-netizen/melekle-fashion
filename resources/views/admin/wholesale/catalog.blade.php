@extends('layouts.app')

@section('content')
<div dir="rtl" class="min-h-screen bg-stone-50 px-4 py-10">
    <div class="mx-auto max-w-6xl">
        <div class="mb-8 flex flex-col gap-4 rounded-3xl bg-zinc-950 p-6 text-white md:flex-row md:items-center md:justify-between">
            <div><p class="text-xs font-black tracking-[.2em] text-amber-300">MELEKLER BUSINESS</p><h1 class="mt-2 text-2xl font-black">مواد تجار الجملة</h1><p class="mt-1 text-sm text-white/60">مرحباً {{ session('wholesale_customer_name') }}</p></div>
            <form method="POST" action="{{ route('wholesale.logout') }}">@csrf<button class="rounded-xl border border-white/20 px-4 py-2 text-sm font-bold hover:bg-white hover:text-zinc-950">تسجيل الخروج</button></form>
        </div>

        {{-- استبدل هذا الاستدعاء بمنتجات مشروعك، مع إبقاء الشرط is_wholesale. --}}
        @php
            $wholesaleProducts = isset($products) ? $products->where('is_wholesale', true) : collect();
        @endphp
        @if($wholesaleProducts->isEmpty())
            <div class="rounded-3xl border border-dashed border-amber-300 bg-white p-12 text-center"><p class="text-lg font-black text-zinc-800">لا توجد مواد تجار مضافة حالياً</p><p class="mt-2 text-sm text-zinc-500">ستظهر هنا المنتجات التي يحددها المدير للتجار فقط.</p></div>
        @else
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach($wholesaleProducts as $product)
                    <article class="overflow-hidden rounded-2xl bg-white shadow-sm border border-zinc-100"><img src="{{ $product->image_url ?? asset('images/placeholder.png') }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover"><div class="p-4"><h2 class="font-black text-zinc-900">{{ $product->name }}</h2><p class="mt-2 font-bold text-amber-700">{{ $product->price }} ₺</p></div></article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
