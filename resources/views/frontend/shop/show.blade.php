@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-12">

<div class="grid lg:grid-cols-2 gap-16">

{{-- =====================
PRODUCT IMAGES
===================== --}}
<div>
    <div class="relative bg-white rounded-xl shadow overflow-hidden">
        @if($product->images->count())
            <img
                id="mainImage"
                src="{{ asset('storage/'.$product->images->first()->image) }}" {{-- تم حذف النقطة الزائدة هنا --}}
                class="w-full object-cover transition duration-500 cursor-zoom-in"
                onmousemove="zoom(event)"
                onmouseleave="resetZoom()">
        @endif
    </div>

    {{-- thumbnails slider --}}
    <div class="flex gap-3 mt-4 overflow-x-auto">
        @foreach($product->images as $image)
            <img
                src="{{ asset('storage/'.$image->image) }}" {{-- تم تصحيح المتغير وحذف النقطة الزائدة هنا --}}
                class="w-20 h-20 rounded-lg border cursor-pointer hover:border-orange-500"
                onclick="changeImage(this)">
        @endforeach
    </div>
</div>




{{-- =====================
PRODUCT DETAILS
===================== --}}

<div class="sticky top-24 h-fit">

<h1 class="text-3xl font-bold mb-3">

{{ $product->name }}

</h1>

{{-- rating --}}

<div class="flex items-center gap-2 mb-4">

<div class="text-yellow-400 text-lg">
★★★★★
</div>

<span class="text-gray-500 text-sm">
(42 reviews)
</span>

</div>


{{-- price --}}

<div class="flex items-center gap-4 mb-6">

@if($product->original_price)

<span class="line-through text-gray-400 text-xl">

{{ $product->original_price }} ₺

</span>

@endif

<span class="text-4xl font-bold text-orange-600">

{{ $product->price }} ₺

</span>

</div>


{{-- description --}}

<p class="text-gray-600 leading-relaxed mb-8">

{{ $product->description }}

</p>



{{-- SIZE SELECTOR --}}

@if($product->sizes)

<div class="mb-8">

<h3 class="font-semibold mb-3">
Size
</h3>

<div class="flex flex-wrap gap-3">

@foreach($product->sizes as $size)

<button
onclick="selectSize(this)"
class="sizeBtn border px-5 py-2 rounded-lg hover:border-orange-500 transition">

{{ $size }}

</button>

@endforeach

</div>

</div>

@endif



{{-- ADD TO CART --}}

<div class="flex items-center gap-6 mb-10">

<div class="flex border rounded-lg overflow-hidden">

<button onclick="minus()" class="px-4 py-2 text-lg">
-
</button>

<span id="qty" class="px-6 py-2 font-bold">
1
</span>

<button onclick="plus()" class="px-4 py-2 text-lg">
+
</button>

</div>


<button class="bg-orange-600 hover:bg-orange-700 text-white px-10 py-3 rounded-lg font-bold shadow-lg transition">

🛒 Add To Cart

</button>


<button class="border px-4 py-3 rounded-lg hover:bg-gray-100">

❤️

</button>

</div>



{{-- PRODUCT INFO --}}

<div class="bg-gray-50 p-6 rounded-xl space-y-4">

<div class="flex justify-between">

<span class="text-gray-500">
Stock
</span>

<span class="font-semibold text-green-600">
Available
</span>

</div>


<div class="flex justify-between">

<span class="text-gray-500">
Shipping
</span>

<span class="font-semibold">
2-4 Days
</span>

</div>


<div class="flex justify-between">

<span class="text-gray-500">
Category
</span>

<span class="font-semibold">

{{ $product->category }}

</span>

</div>

</div>

</div>

</div>



{{-- =====================
RELATED PRODUCTS SLIDER
===================== --}}

@if(isset($relatedProducts) && $relatedProducts->count())

<div class="mt-24">

<h2 class="text-2xl font-bold mb-10">

Similar Products

</h2>

<div class="relative">

<button onclick="slideLeft()" class="absolute -left-6 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-3">

‹

</button>

<div id="relatedSlider" class="flex gap-6 overflow-x-auto scroll-smooth">

@foreach($relatedProducts as $item)

<a href="{{ route('product.show',$item->slug) }}">

<div class="min-w-[220px] bg-white rounded-xl shadow hover:shadow-lg transition p-3">

@if($item->images->count())

<img
src="{{ asset('storage/'.$item->images->first()->image) }}"
class="rounded-lg mb-3 h-48 w-full object-cover">

@endif

<h3 class="font-semibold text-sm mb-2">

{{ $item->name }}

</h3>

<div class="text-orange-600 font-bold">

{{ $item->price }} ₺

</div>

</div>

</a>

@endforeach

</div>

<button onclick="slideRight()" class="absolute -right-6 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-3">

›

</button>

</div>

</div>

@endif

</div>



<script>

function changeImage(img){

document.getElementById("mainImage").src = img.src

}



function plus(){

let qty = document.getElementById("qty")

qty.innerText = parseInt(qty.innerText) + 1

}



function minus(){

let qty = document.getElementById("qty")

if(qty.innerText > 1){

qty.innerText = parseInt(qty.innerText) - 1

}

}



function selectSize(btn){

document.querySelectorAll(".sizeBtn").forEach(el=>{

el.classList.remove("border-orange-500","text-orange-500")

})

btn.classList.add("border-orange-500","text-orange-500")

}



function zoom(e){

const img = e.target

const rect = img.getBoundingClientRect()

const x = e.clientX - rect.left

const y = e.clientY - rect.top

img.style.transformOrigin = x+"px "+y+"px"

img.style.transform = "scale(2)"

}



function resetZoom(){

const img = document.getElementById("mainImage")

img.style.transform = "scale(1)"

}



function slideLeft(){

document.getElementById("relatedSlider").scrollBy({

left:-300,

behavior:'smooth'

})

}



function slideRight(){

document.getElementById("relatedSlider").scrollBy({

left:300,

behavior:'smooth'

})

}

</script>



@endsection