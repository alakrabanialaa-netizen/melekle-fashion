@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-12">
    <div class="grid lg:grid-cols-2 gap-16">

        {{-- =====================
             PRODUCT IMAGES
        ===================== --}}
        <div>
            <div class="relative bg-white rounded-2xl shadow-sm border overflow-hidden group">
                @if($product->images && $product->images->count() > 0)
                    @php 
                        $firstImg = $product->images->first()->image;
                        $firstPath = Str::contains($firstImg, ['http', 'https']) ? $firstImg : asset('storage/' . $firstImg);
                    @endphp
                    <img
                        id="mainImage"
                        src="{{ $firstPath }}"
                        alt="{{ $product->name }}"
                        class="w-full h-[500px] object-contain transition duration-500 cursor-zoom-in"
                        onmousemove="zoom(event)"
                        onmouseleave="resetZoom()">
                @else
                    <div class="w-full h-[500px] bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400">No image available</span>
                    </div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($product->images->count() > 1)
            <div class="flex gap-3 mt-4 overflow-x-auto pb-2 custom-scrollbar">
                @foreach($product->images as $image)
                    @php 
                        $thumbPath = Str::contains($image->image, ['http', 'https']) ? $image->image : asset('storage/' . $image->image);
                    @endphp
                    <img
                        src="{{ $thumbPath }}"
                        class="w-24 h-24 rounded-xl border-2 border-transparent cursor-pointer hover:border-orange-500 transition-all object-cover bg-white"
                        onclick="changeImage(this)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- =====================
             PRODUCT DETAILS
        ===================== --}}
        <div class="sticky top-24 h-fit">
            <nav class="flex text-sm text-gray-500 mb-4">
                <a href="/" class="hover:text-orange-600">Home</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium truncate">{{ $product->name }}</span>
            </nav>

            <h1 class="text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                {{ $product->name }}
            </h1>

            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center bg-orange-50 px-3 py-1 rounded-full">
                    <span class="text-orange-600 font-bold text-2xl">{{ $product->price }} ₺</span>
                </div>
                @if($product->original_price)
                    <span class="line-through text-gray-400 text-lg">{{ $product->original_price }} ₺</span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">
                        SALE
                    </span>
                @endif
            </div>

            <div class="prose prose-sm text-gray-600 mb-8">
                <p class="leading-relaxed">{{ $product->description }}</p>
            </div>

            {{-- Size Selector --}}
            @if($product->sizes)
            <div class="mb-8">
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">Select Size</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($product->sizes as $size)
                        <button
                            onclick="selectSize(this)"
                            class="sizeBtn border-2 border-gray-200 px-6 py-2 rounded-xl font-medium hover:border-orange-500 transition-all">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-10">
                <div class="flex border-2 border-gray-200 rounded-xl overflow-hidden bg-white">
                    <button onclick="minus()" class="px-5 py-3 hover:bg-gray-50 transition">-</button>
                    <span id="qty" class="px-6 py-3 font-bold text-lg min-w-[60px] text-center">1</span>
                    <button onclick="plus()" class="px-5 py-3 hover:bg-gray-50 transition">+</button>
                </div>

                <button class="w-full sm:flex-1 bg-orange-600 hover:bg-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-orange-200 transition-all transform active:scale-95">
                    🛒 Add To Cart
                </button>

                <button class="p-4 rounded-xl border-2 border-gray-200 hover:bg-red-50 hover:border-red-200 transition-all group">
                    <span class="text-2xl group-hover:scale-110 inline-block transition">❤️</span>
                </button>
            </div>

            {{-- Product Info --}}
            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Category</p>
                    <p class="font-semibold text-gray-800">{{ $product->category }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-bold">Shipping</p>
                    <p class="font-semibold text-gray-800">2-4 Days</p>
                </div>
            </div>
        </div>
    </div>

    {{-- =====================
         RELATED PRODUCTS
    ===================== --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-24">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Similar Products</h2>
            <div class="flex gap-2">
                <button onclick="slideLeft()" class="p-3 bg-white border rounded-full shadow-sm hover:bg-gray-50">‹</button>
                <button onclick="slideRight()" class="p-3 bg-white border rounded-full shadow-sm hover:bg-gray-50">›</button>
            </div>
        </div>

        <div id="relatedSlider" class="flex gap-6 overflow-x-auto scroll-smooth no-scrollbar pb-4">
            @foreach($relatedProducts as $item)
                <a href="{{ route('product.show', $item->id) }}" class="min-w-[280px] group">
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 transition-all group-hover:shadow-xl group-hover:-translate-y-1">
                        <div class="relative rounded-xl overflow-hidden mb-4 h-64">
                            @php 
                                $rImg = $item->images->first() ? $item->images->first()->image : null;
                                $rPath = Str::contains($rImg, ['http', 'https']) ? $rImg : asset('storage/' . $rImg);
                            @endphp
                            <img src="{{ $rPath }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        </div>
                        <h3 class="font-bold text-gray-900 group-hover:text-orange-600 transition mb-1">{{ $item->name }}</h3>
                        <p class="text-orange-600 font-extrabold">{{ $item->price }} ₺</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .custom-scrollbar::-webkit-scrollbar { height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ed8936; border-radius: 10px; }
</style>

<script>
    function changeImage(img) {
        const main = document.getElementById("mainImage");
        main.src = img.src;
        // إضافة تأثير وميض عند تغيير الصورة
        main.classList.add('opacity-50');
        setTimeout(() => main.classList.remove('opacity-50'), 100);
    }

    function plus() {
        let qty = document.getElementById("qty");
        qty.innerText = parseInt(qty.innerText) + 1;
    }

    function minus() {
        let qty = document.getElementById("qty");
        if(parseInt(qty.innerText) > 1) qty.innerText = parseInt(qty.innerText) - 1;
    }

    function selectSize(btn) {
        document.querySelectorAll(".sizeBtn").forEach(el => el.classList.remove("border-orange-500", "text-orange-600", "bg-orange-50"));
        btn.classList.add("border-orange-500", "text-orange-600", "bg-orange-50");
    }

    function zoom(e) {
        const img = e.target;
        const x = e.offsetX / img.offsetWidth * 100;
        const y = e.offsetY / img.offsetHeight * 100;
        img.style.transformOrigin = `${x}% ${y}%`;
        img.style.transform = "scale(1.8)";
    }

    function resetZoom() {
        document.getElementById("mainImage").style.transform = "scale(1)";
    }

    function slideLeft() { document.getElementById("relatedSlider").scrollBy({ left: -300, behavior: 'smooth' }); }
    function slideRight() { document.getElementById("relatedSlider").scrollBy({ left: 300, behavior: 'smooth' }); }
</script>

@endsection
