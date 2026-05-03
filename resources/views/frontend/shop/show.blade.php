@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-12" dir="rtl">
    <div class="grid lg:grid-cols-2 gap-16">

        {{-- =====================
             PRODUCT IMAGES
        ===================== --}}
        <div>
            <div class="relative bg-white rounded-2xl shadow-sm border overflow-hidden group">
                @if($product->images && $product->images->count() > 0)
                    @php 
                        $firstImg = $product->images->first()->image;
                        // تصحيح عرض الصورة: إذا كان الرابط كاملاً (Cloudinary) يعرض مباشرة، وإلا يستخدم asset
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
                        <span class="text-gray-400">لا توجد صور متاحة</span>
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
                        class="thumbnail-img w-24 h-24 rounded-xl border-2 {{ $loop->first ? 'border-orange-500' : 'border-transparent' }} cursor-pointer hover:border-orange-500 transition-all object-cover bg-white"
                        onclick="changeImage(this)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- =====================
             PRODUCT DETAILS
        ===================== --}}
        <div class="sticky top-24 h-fit text-right">
            <nav class="flex text-sm text-gray-500 mb-4 justify-start">
                <a href="/" class="hover:text-orange-600">الرئيسية</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium truncate">{{ $product->name }}</span>
            </nav>

            <h1 class="text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                {{ $product->name }}
            </h1>

            {{-- Stock Status Badge (إضافة جديدة) --}}
            <div class="mb-4">
                @if($product->stock <= 0)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <span class="w-2 h-2 ml-2 rounded-full bg-red-600"></span>
                        نفدت الكمية
                    </span>
                @elseif($product->stock <= 5)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 animate-pulse">
                        <span class="w-2 h-2 ml-2 rounded-full bg-orange-600"></span>
                        كمية محدودة جداً: متبقي {{ $product->stock }} فقط!
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 ml-2 rounded-full bg-green-600"></span>
                        متوفر في المخزون
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-4 mb-6 justify-start">
                <div class="flex items-center bg-orange-50 px-3 py-1 rounded-full">
                    <span class="text-orange-600 font-bold text-2xl">{{ number_format($product->price, 2) }} ₺</span>
                </div>
                @if($product->original_price && $product->original_price > $product->price)
                    <span class="line-through text-gray-400 text-lg">{{ number_format($product->original_price, 2) }} ₺</span>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">
                        خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                    </span>
                @endif
            </div>

            <div class="prose prose-sm text-gray-600 mb-8">
                <p class="leading-relaxed">{{ $product->description }}</p>
            </div>

       {{-- Size & Age Selector --}}
<div class="mb-8 space-y-6">
    
    {{-- عرض المقاسات --}}
    @php
        $sizes = $product->sizes;
        if (is_string($sizes)) {
            $sizes = json_decode($sizes, true);
        }
    @endphp

    @if(is_array($sizes) && count($sizes) > 0)
        <div>
            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">المقاسات المتاحة:</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($sizes as $size)
                    <button type="button" onclick="selectSize(this)" class="sizeBtn border-2 border-gray-200 px-6 py-2 rounded-xl font-medium hover:border-orange-500 transition-all">
                        {{ $size }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- عرض الأعمار --}}
    @php
        $ages = $product->ages;
        if (is_string($ages)) {
            $ages = json_decode($ages, true);
        }
        $ageLabels = [
            'newborn' => 'حديث ولادة', '0-3m' => '0-3 أشهر', '3-6m' => '3-6 أشهر',
            '6-12m' => '6-12 شهر', '1-2y' => '1-2 سنة', '2-3y' => '2-3 سنوات',
            '3-4y' => '3-4 سنوات', '4-5y' => '4-5 سنوات', '6-7y' => '6-7 سنوات',
            '8-9y' => '8-9 سنوات', '10-12y' => '10-12 سنة'
        ];
    @endphp

    @if(is_array($ages) && count($ages) > 0)
        <div>
            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 mb-3">الأعمار المتاحة:</h3>
            <div class="flex flex-wrap gap-3">
                @foreach($ages as $age)
                    <button type="button" onclick="selectSize(this)" class="sizeBtn border-2 border-gray-200 px-4 py-2 rounded-xl font-medium hover:border-orange-500 transition-all bg-gray-50">
                        {{ $ageLabels[$age] ?? $age }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-10">
                <div class="flex border-2 border-gray-200 rounded-xl overflow-hidden bg-white">
                    <button onclick="minus()" class="px-5 py-3 hover:bg-gray-50 transition">-</button>
                    <span id="qty" class="px-6 py-3 font-bold text-lg min-w-[60px] text-center">1</span>
                    <button onclick="plus()" class="px-5 py-3 hover:bg-gray-50 transition">+</button>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full sm:flex-1">
                    @csrf
                    <input type="hidden" name="quantity" id="form-qty" value="1">
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-orange-200 transition-all transform active:scale-95">
                        🛒 أضف إلى السلة
                    </button>
                </form>

                <button class="p-4 rounded-xl border-2 border-gray-200 hover:bg-red-50 hover:border-red-200 transition-all group">
                    <span class="text-2xl group-hover:scale-110 inline-block transition text-red-500">♥</span>
                </button>
            </div>

            {{-- Product Info & Share --}}
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">القسم</p>
                        <p class="font-semibold text-gray-800">{{ $product->category }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">الشحن</p>
                        <p class="font-semibold text-gray-800">2-4 أيام عمل</p>
                    </div>
                </div>
                
                {{-- Social Share (إضافة جديدة) --}}
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs font-bold text-gray-500 mb-3">مشاركة المنتج:</p>
                    <div class="flex gap-3">
                        <a href="https://wa.me/?text={{ urlencode($product->name . ' ' . url()->current()) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-green-500 text-white hover:opacity-80 transition"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-600 text-white hover:opacity-80 transition"><i class="fab fa-facebook-f"></i></a>
                        <button onclick="copyLink()" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 hover:bg-gray-400 transition"><i class="fas fa-link"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .custom-scrollbar::-webkit-scrollbar { height: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #ed8936; border-radius: 10px; }
</style>

<script>
    function changeImage(imgElement) {
        const main = document.getElementById("mainImage");
        main.src = imgElement.src;
        
        // تحسين بصري: تمييز الصورة المصغرة النشطة
        document.querySelectorAll('.thumbnail-img').forEach(el => {
            el.classList.remove('border-orange-500');
            el.classList.add('border-transparent');
        });
        imgElement.classList.remove('border-transparent');
        imgElement.classList.add('border-orange-500');

        main.classList.add('opacity-50');
        setTimeout(() => main.classList.remove('opacity-50'), 100);
    }

    function plus() {
        let qty = document.getElementById("qty");
        let val = parseInt(qty.innerText) + 1;
        qty.innerText = val;
        document.getElementById("form-qty").value = val;
    }

    function minus() {
        let qty = document.getElementById("qty");
        let val = parseInt(qty.innerText);
        if(val > 1) {
            val--;
            qty.innerText = val;
            document.getElementById("form-qty").value = val;
        }
    }

    function selectSize(btn) {
        document.querySelectorAll(".sizeBtn").forEach(el => el.classList.remove("border-orange-500", "text-orange-600", "bg-orange-50"));
        btn.classList.add("border-orange-500", "text-orange-600", "bg-orange-50");
    }

    function copyLink() {
        navigator.clipboard.writeText(window.location.href);
        alert('تم نسخ الرابط بنجاح!');
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
</script>

@endsection
