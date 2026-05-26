@extends('layouts.app')



@section('content')
{{-- 🎨 MASTER STYLESHEET - الروابط النظيفة بدون تكرار --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Fredoka:wght@400;600;700&display=swap');

    /* --- 1. الهوية البصرية والألوان الموحدة (عام 2026) --- */
    :root {
        --brand-pink: #f43f5e;
        --brand-pink-hover: #e11d48;
        --brand-amber: #f59e0b;
        --soft-cream: #fffaf0;
        --text-dark: #1f2937;
    }

    body { 
        font-family: 'Cairo', 'Fredoka', sans-serif; 
        background-color: var(--soft-cream); 
        color: var(--text-dark);
        overflow-x: hidden;
        padding-bottom: 60px; /* مساحة الفوتر المتحرك */
    }

    h1, h2, h3, h4, h5, h6, .font-bold { font-weight: 700; }
    .font-black { font-weight: 900; }

    /* --- 2. تأثيرات الحركة والأنيميشن النظيفة --- */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .scroll-reveal.visible { opacity: 1; transform: translateY(0); }

    @keyframes gradientMove { 0% { background-position: 0% } 100% { background-position: 200% } }
    @keyframes shine { from { transform: translateX(-100%); } to { transform: translateX(100%); } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(25px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scrollReviews { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    @keyframes marquee { from { transform: translateX(0%); } to { transform: translateX(-50%); } }
    @keyframes float-huge { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-12px) scale(1.02); } }
    @keyframes pulse-border { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.03); opacity: 0.9; } }

    /* --- 3. قسم الـ Hero والـ Badges الفاخرة --- */
    .hero-spotted-container {
        background-image: radial-gradient(rgba(244, 63, 94, 0.15) 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        border: 12px solid white;
        border-radius: 50px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
    }
    .lux-badge { letter-spacing: 0.2em; font-size: 13px; font-weight: 600; color: var(--brand-amber); }
    .lux-gradient {
        background: linear-gradient(90deg, var(--brand-amber), var(--brand-pink), var(--brand-amber));
        background-size: 200% 100%; -webkit-background-clip: text; color: transparent;
        animation: gradientMove 6s linear infinite;
    }
    .slider-img-huge-anim { animation: float-huge 6s ease-in-out infinite; }
    .bg-gradient-to-tr { animation: pulse-border 2s infinite ease-in-out; }

    /* --- 4. كروت المنتجات الذكية السائلة (Interactive Cards) --- */
    .product-card-ty {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        padding: 12px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .product-card-ty:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(244, 63, 94, 0.06);
        border-color: rgba(244, 63, 94, 0.15);
    }
    .ty-image-wrapper {
        width: 100%;
        aspect-ratio: 1 / 1;
        position: relative;
        background: #fdfdfd;
        overflow: hidden;
        border-radius: 18px;
    }
    .ty-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 18px;
        transition: transform 0.3s ease-out;
    }

    /* الستارة الزجاجية الانسيابية لزر السلة والتفاصيل */
    .ty-glass-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(255, 255, 255, 0.95) 45%, rgba(255, 255, 255, 0.3));
        backdrop-filter: blur(4px);
        opacity: 0;
        transform: translateY(100%);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 16px;
    }
    .product-card-ty:hover .ty-glass-overlay { opacity: 1; transform: translateY(0); }

    .ty-badge {
        position: absolute; top: 12px; left: 12px; background-color: var(--brand-pink);
        color: white; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; border-radius: 30px; z-index: 20;
    }
    .ty-wishlist-btn {
        position: absolute; top: 12px; right: 12px; width: 36px; height: 36px;
        border-radius: 50%; background-color: white; color: #6b7280;
        display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: all 0.2s ease; z-index: 20;
    }
    .ty-wishlist-btn:hover { color: var(--brand-pink); transform: scale(1.15); }

    .ty-info-wrapper { padding: 12px 4px 4px; text-align: right; }
    .ty-title { font-size: 0.9rem; font-weight: 600; color: #374151; line-height: 1.4; }
    .ty-price-wrapper { display: flex; align-items: center; gap: 8px; flex-direction: row-reverse; justify-content: flex-start; margin-top: 6px; }
    .ty-final-price { font-size: 1.1rem; font-weight: 700; color: var(--brand-pink); }
    .ty-original-price { font-size: 0.85rem; color: #9ca3af; text-decoration: line-through; }

    /* --- 5. شريط التصفية والبحث الذكي (Filter Bar) --- */
    .filter-bar {
        display: flex; align-items: center; background-color: #ffffff;
        border-radius: 16px; padding: 6px; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid #e5e7eb;
    }
    .filter-group { position: relative; display: flex; align-items: center; flex-grow: 1; }
    .filter-input {
        width: 100%; border: none; padding: 12px 44px 12px 16px;
        font-weight: 600; color: #374151;
    }
    .filter-input:focus { outline: none; }
    .apply-button {
        background-color: var(--brand-pink); color: white; font-weight: 700;
        padding: 12px 24px; border-radius: 12px; transition: all 0.2s ease;
    }
    .apply-button:hover { background-color: var(--brand-pink-hover); transform: scale(1.02); }

    /* --- 6. سلايدر التقييمات اللانهائي (Smooth Reviews) --- */
    .reviews-slider { position: relative; overflow: hidden; width: 100%; padding: 10px 0; }
    .reviews-track { display: flex; width: max-content; animation: scrollReviews 35s linear infinite; gap: 24px; }
    .reviews-slider:hover .reviews-track { animation-play-state: paused; }

    .review-card {
        min-width: 310px; max-width: 310px; background: white; padding: 24px;
        border-radius: 24px; text-align: center; border: 1px solid #f3f4f6;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02); transition: transform 0.3s;
    }
    .review-card:hover { transform: translateY(-6px); }
    .review-img { width: 75px; height: 75px; border-radius: 50%; margin: 0 auto 12px; object-fit: cover; }
    .stars { color: #fbbf24; font-size: 16px; }

    /* --- 7. الشاشات الصغيرة والموبايل (Responsive) --- */
    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; gap: 8px; padding: 12px; }
        .filter-input { padding: 10px 40px 10px 12px; }
        .apply-button { width: 100%; text-align: center; }
        .hero-spotted-container { border-radius: 32px; padding: 20px; }
    }

    /* --- 8. الفوتر الإعلاني المتحرك (Marquee Footer) --- */
    .marquee-footer {
        position: fixed; bottom: 0; left: 0; width: 100%;
        background-color: #111827; color: white; z-index: 60;
        overflow: hidden; padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.1);
    }
    .marquee-inner-wrap { display: flex; width: fit-content; animation: marquee 30s linear infinite; }
    .marquee-footer:hover .marquee-inner-wrap { animation-play-state: paused; }
    .marquee-content { display: flex; align-items: center; white-space: nowrap; }
    .marquee-content span { font-size: 0.85rem; opacity: 0.9; margin: 0 2rem; }
    .marquee-content i { margin: 0 1rem; }
</style>


        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&family=Fredoka:wght@400;600;700&display=swap');
{{-- Hero Section (The Curved Box) --}}

    <div class="hero-curved-container bg-white shadow-xl flex flex-col md:flex-row items-center p-8 md:p-16 gap-10">

        <div class="md:w-1/2 relative">

            <div class="absolute -top-10 -left-10 w-32 h-32 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>

            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&q=80&w=600" 

                 alt="Kids Education" 

                 class="rounded-full w-80 h-80 object-cover border-8 border-pink-50 shadow-inner">

        </div>

        <div class="md:w-1/2 text-right md:text-left">

            <h1 class="text-4xl md:text-5xl font-black text-pink-500 mb-4 leading-tight">FOR YOUR BEBE</h1>

            <p class="text-gray-400 leading-relaxed mb-8">

              متجر مختص لبيع ملابس الأطفال المريحة والحديثة التي تناسب طفلك 

            </p>

            <a href="#" class="btn-rounded bg-pink-500 text-white shadow-lg shadow-pink-200 inline-block">Learn more</a>

        </div>

    </div>



    {{-- Features Section (The Three Icons) --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 py-20 text-center">

        <div class="group">

            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-2 border-dashed border-green-200 group-hover:rotate-12 transition-transform">

                <span class="text-4xl">🍼</span>

            </div>

            <h3 class="font-black text-green-500 text-xl mb-3">About proudct</h3>

            <p class="text-gray-400 text-sm px-4">ملابس خاصة صنعت بعناية لحديثي الولادة.</p>

        </div>

        <div class="group">

            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-2 border-dashed border-pink-200 group-hover:-rotate-12 transition-transform">

                <span class="text-4xl">🧷</span>

            </div>

            <h3 class="font-black text-pink-500 text-xl mb-3">Our experience</h3>

            <p class="text-gray-400 text-sm px-4">صنعت كل قطعة بحب خاصة لطفلك.</p>

        </div>

        <div class="group">

            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border-2 border-dashed border-blue-200 group-hover:rotate-12 transition-transform">

                <span class="text-4xl">🪄</span>

            </div>

            <h3 class="font-black text-blue-500 text-xl mb-3">Big fun for kids!</h3>

            <p class="text-gray-400 text-sm px-4">مع كل قطعة معنا ممكن تربح هدية كبيرة.</p>

        </div>

    </div>



</div>



{{-- Bottom Event & Calendar Section --}}

<div class="zigzag-border mt-10 py-20 text-white">

    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row gap-16">

        

        {{-- Event Info --}}

        <div class="md:w-1/2">

            <h2 class="text-4xl font-black mb-8">April's upcoming event</h2>

            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20">

                <div class="flex gap-4 text-sm mb-4 font-bold opacity-80">

                    <span>📅 17.04.2026</span>

                    <span>⏰ 09:00 AM</span>

                    <span>📍 Lorem ipsum dolor</span>

                </div>

                <p class="mb-8 leading-relaxed">

                    انضموا إلينا في فعاليتنا القادمة حيث سنقوم بالعديد من الأنشطة التفاعلية والمسابقات الممتعة للأطفال مع توزيع الهدايا.

                </p>

                <a href="#" class="btn-rounded bg-white text-pink-500">Learn more</a>

            </div>

        </div>



        {{-- Calendar --}}

        <div class="md:w-1/2 flex flex-col items-center">

            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 w-full max-w-sm">

                <div class="flex justify-between items-center mb-6 font-black uppercase tracking-widest">

                    <button class="hover:text-yellow-300">←</button>

                    <span>April 2026</span>

                    <button class="hover:text-yellow-300">→</button>

                </div>

                

                <div class="calendar-grid text-center font-bold text-xs mb-4 opacity-60">

                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>

                </div>

                

                <div class="calendar-grid">

                    @for($i=1; $i<=30; $i++)

                        <div class="calendar-day {{ in_array($i, [17, 22, 25, 28]) ? 'active' : '' }}">

                            {{ $i }}

                        </div>

                    @endfor

                </div>

            </div>

        </div>



    </div>

</div>



{{-- ------------------------------------------------------------------ --}}

{{-- 🚀 MAIN CONTENT --}}

{{-- ------------------------------------------------------------------ --}}

{{-- 

    💡 ملاحظة للمبرمج: 

    يمكنك تعديل هذه المصفوفة (Array) لإضافة قصصك الخاصة. 

    كل قصة تحتاج إلى: 'name' (الاسم تحت الصورة)، 'image' (رابط الصورة)، و 'video' (رابط الفيديو).

--}}

@php

    $stories = [

        ['name' => 'جديدنا', 'image' => 'https://i.pravatar.cc/150?u=1', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],

        ['name' => 'عروض العيد', 'image' => 'https://i.pravatar.cc/150?u=2', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'وصل حديثاً', 'image' => 'https://i.pravatar.cc/150?u=3', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],

        ['name' => 'ملابس أولاد', 'image' => 'https://i.pravatar.cc/150?u=4', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'ملابس بنات', 'image' => 'https://i.pravatar.cc/150?u=5', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],

        ['name' => 'تخفيضات', 'image' => 'https://i.pravatar.cc/150?u=6', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'إطلالة اليوم', 'image' => 'https://i.pravatar.cc/150?u=7', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],

        ['name' => 'آراء العملاء', 'image' => 'https://i.pravatar.cc/150?u=8', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'آراء العملاء', 'image' => 'https://i.pravatar.cc/150?u=8', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'آراء العملاء', 'image' => 'https://i.pravatar.cc/150?u=8', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'آراء العملاء', 'image' => 'https://i.pravatar.cc/150?u=8', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'آراء العملاء', 'image' => 'https://i.pravatar.cc/150?u=8', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

        ['name' => 'آراء العملاء', 'image' => 'https://i.pravatar.cc/150?u=8', 'video' => 'https://www.w3schools.com/html/movie.mp4'],

    ];

@endphp



{{-- Stories Section --}}

<section class="py-12 bg-white">

    <div class="max-w-screen-xl mx-auto px-6">

        <div class="swiper storiesSwiper">

            <div class="swiper-wrapper">

                @foreach($stories as $story)

                    <div class="swiper-slide !w-auto">

                        <div class="flex flex-col items-center gap-2 cursor-pointer group" onclick="openVideoModal('{{ $story['video'] }}')">

                            {{-- دائرة القصة مع تأثير النبض --}}

                            <div class="w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-orange-500 to-pink-500 transition-transform duration-300 group-hover:scale-110">

                                <div class="w-full h-full rounded-full border-2 border-white overflow-hidden">

                                    <img src="{{ $story['image'] }}" class="w-full h-full object-cover" alt="{{ $story['name'] }}">

                                </div>

                            </div>

                            {{-- النص المخصص تحت كل صورة --}}

                            <span class="text-xs font-bold text-gray-800 group-hover:text-orange-500 transition-colors">{{ $story['name'] }}</span>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>





{{-- Categories Grid --}}

<section class="py-20 bg-gray-50">

    <div class="max-w-screen-xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-8 category-grid">

            <div class="category-card scroll-reveal" style="--bg-image: url('https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?q=80&w=1972&auto=format&fit=crop')">

                <div class="card-glow"></div>

                <div class="card-content">

                    <span class="card-subtitle">تشكيلة الأولاد</span>

                    <h2 class="card-title">الأناقة والراحة</h2>

                    <div class="card-arrow"><i class="fas fa-arrow-left"></i></div>

                </div>

            </div>

            <div class="category-card scroll-reveal" style="--bg-image: url('https://images.unsplash.com/photo-1518833278463-d3055863572f?q=80&w=2070&auto=format&fit=crop')">

                <div class="card-glow"></div>

                <div class="card-content">

                    <span class="card-subtitle">تشكيلة البنات</span>

                    <h2 class="card-title">عالم من الألوان</h2>

                    <div class="card-arrow"><i class="fas fa-arrow-left"></i></div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- Products Section --}}

<section class="py-20 bg-white">

    <div class="max-w-screen-xl mx-auto px-6">

        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">

            <div>

                <h2 class="text-4xl font-black text-gray-900">الأكثر <span class="text-orange-500">مبيعاً</span></h2>

                <p class="text-gray-500 mt-2">اخترنا لك أفضل القطع التي نالت إعجاب عملائنا.</p>

            </div>

            <div class="filter-bar">

                <div class="filter-group">

                    <i class="fas fa-search filter-icon"></i>

                    <input type="text" class="filter-input" placeholder="بحث عن منتج...">

                </div>

                <div class="filter-separator"></div>

                <button class="apply-button">تصفية</button>

            </div>

        </div>



        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @forelse($products as $product)

                <div class="product-card-ty scroll-reveal">

                    <a href="{{ route('product.show', $product->id) }}">

                        <div class="ty-image-wrapper">

                            @if($product->original_price > $product->price)

                                <div class="ty-badge">

                                    @if($product->badge_text)

                                        {{ $product->badge_text }}

                                    @else

                                        خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%

                                    @endif

                                </div>

                            @endif

<img loading="lazy" 

     src="{{ $product->images->first() ? $product->images->first()->image : 'https://via.placeholder.com/300' }}" 

     class="ty-main-image" 

     alt="{{ $product->name }}">                        </div>

                    </a>

                    <button class="ty-wishlist-btn" title="أضف للمفضلة">

                        <i class="far fa-heart"></i>

                    </button>

                    <div class="ty-info-wrapper">

                        <h3 class="ty-title">{{ $product->name }}</h3>

                        <div class="ty-price-wrapper">

                            @if($product->original_price > $product->price)

                                <span class="ty-original-price">{{ number_format($product->original_price, 2) }} ₺</span>

                            @endif

                            <span class="ty-final-price">{{ number_format($product->price, 2) }} ₺</span>

                        </div>

                    </div>

                   <form action="{{ route('cart.add', $product->id) }}" method="POST">

    @csrf

{{-- التعديل الجديد: تحويل الزر ليعمل بالـ Ajax السريع ويفتح السلة الجانبية --}}

<button type="button" 

        onclick="addToCart({{ $product->id }}, '{{ $product->sizes[0] ?? 'Free Size' }}')" 

        class="ty-add-to-cart w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-md flex items-center justify-center gap-2">

    <span>🛒</span>

    <span>أضف إلى السلة</span>

</button>

                </div>

            @empty

                <div class="col-span-full text-center py-20">

                    <p class="text-gray-500 text-lg">لا توجد منتجات لعرضها حالياً.</p>

                </div>

            @endforelse

        </div>

    </div>

</section>



{{-- Premium Luxury Section --}}

<section class="relative py-28 overflow-hidden bg-gradient-to-b from-gray-50 via-white to-gray-100">

    <div class="max-w-screen-xl mx-auto px-6">



        <div class="grid lg:grid-cols-2 gap-20 items-center">



            {{-- LEFT IMAGE --}}

            <div class="relative group cursor-pointer">

                <img src="https://static.aljamila.com/styles/1100x732_scale/public/2018/12/20/2393901-1727507459.jpg" 

                     alt="Kids Fashion" 

                     class="w-full h-[600px] object-cover rounded-3xl shadow-xl transition-transform duration-700 group-hover:scale-105"

                     onclick="openLightbox(this.src)">

                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent rounded-3xl"></div>

                <div class="absolute bottom-8 left-8 text-white max-w-xs">

                    <span class="bg-orange-500 px-3 py-1 rounded-full text-xs font-bold">إطلالة العيد</span>

                    <h3 class="text-3xl font-black mt-3 leading-tight">أناقة الأطفال تبدأ من اختيار القطع الصحيحة</h3>

                </div>

            </div>



            {{-- RIGHT CONTENT --}}

            <div class="space-y-8">

                <span class="inline-block py-1 px-4 bg-orange-100 text-orange-600 rounded-full text-xs font-bold">ستايل مختار لك</span>

                <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">إطلالة كاملة <span class="text-orange-500">بضغطة واحدة</span></h2>

                <p class="text-gray-500 text-lg">اخترنا لك مجموعة قطع متناسقة لتسهيل تجربة التسوق وجعل الإطلالة أكثر أناقة واحترافية.</p>



                <div class="grid gap-6">



                    <!-- PRODUCT CARD 1 -->

                    <div class="flex items-center p-4 bg-white rounded-2xl shadow-lg transform opacity-0 translate-y-10 transition-all duration-700 card-scroll">

                        <img src="https://i.pinimg.com/236x/8f/2b/4c/8f2b4c2ea900323aec716ee886f7f066.jpg" 

                             class="w-20 h-20 rounded-xl object-cover cursor-pointer" 

                             onclick="openLightbox(this.src)">

                        <div class="ml-4 flex-1">

                            <h4 class="text-lg font-bold text-gray-800">طقم كامل لأطفالكِ</h4>

                            <p class="text-orange-500 font-black text-md mt-1">250 ₺</p>

                        </div>

                        <button class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white rounded-full hover:bg-orange-500 transition">+</button>

                    </div>



                    <!-- PRODUCT CARD 2 -->

                    <div class="flex items-center p-4 bg-white rounded-2xl shadow-lg transform opacity-0 translate-y-10 transition-all duration-700 card-scroll">

                        <img src="https://image.made-in-china.com/202f0j00ZbRuNDByfPoI/New-International-School-Uniforms-Summer-Boys-Girls-School-Uniforms-Design-with-Pictures-Clothes-Children.webp" 

                             class="w-20 h-20 rounded-xl object-cover cursor-pointer" 

                             onclick="openLightbox(this.src)">

                        <div class="ml-4 flex-1">

                            <h4 class="text-lg font-bold text-gray-800">طقمين بسعر طقم</h4>

                            <p class="text-orange-500 font-black text-md mt-1">170 ₺</p>

                        </div>

                        <button class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white rounded-full hover:bg-orange-500 transition">+</button>

                    </div>



                    <!-- BUY BUTTON -->

                    <button class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl font-bold text-lg shadow-lg hover:shadow-none hover:translate-y-1 transition-all">

                        شراء الإطلالة كاملة — 420 ₺

                    </button>

                </div>

            </div>

        </div>

    </div>

       {{-- Lightbox Overlay --}}

    <div id="lightbox" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50" onclick="closeLightbox()">

        <img id="lightbox-img" src="" class="max-h-[90vh] max-w-[90vw] rounded-2xl shadow-2xl">

    </div>

</section>



{{-- Reviews Section --}}

<section class="py-24 bg-gray-50 overflow-hidden">

    <div class="max-w-screen-xl mx-auto px-6">

        <h2 class="text-4xl md:text-5xl font-black text-center mb-16">ماذا يقول <span class="text-orange-500">عملاؤنا</span></h2>

        <div class="reviews-slider relative">

            <div class="reviews-track flex gap-8 pb-4">

                @for ($i = 0; $i < 2; $i++ )

                    <div class="review-card flex-shrink-0 w-80 bg-white shadow-lg rounded-xl p-6 text-center transform transition duration-300 hover:scale-105">

                        <div class="flex justify-center mb-4">

                            <div class="w-24 h-24 rounded-full border-4 border-orange-500 shadow-md overflow-hidden bg-gray-200">

                                <img loading="lazy" src="https://ui-avatars.com/api/?name=سارة+أحمد&background=FFEDD5&color=F97316&size=128" alt="سارة أحمد" class="w-full h-full object-cover">

                            </div>

                        </div>

                        <p class="text-gray-700 text-base mb-4 italic">"جودة الملابس ممتازة والتوصيل كان سريع جداً. شكراً لكم!"</p>

                        <div class="stars text-orange-400 text-xl mb-2">★★★★★</div>

                        <h5 class="font-semibold text-gray-900 text-lg">سارة أحمد</h5>

                    </div>

                    <div class="review-card flex-shrink-0 w-80 bg-white shadow-lg rounded-xl p-6 text-center transform transition duration-300 hover:scale-105">

                        <div class="flex justify-center mb-4">

                            <div class="w-24 h-24 rounded-full border-4 border-orange-500 shadow-md overflow-hidden bg-gray-200">

                                <img loading="lazy" src="https://ui-avatars.com/api/?name=محمد+علي&background=FFEDD5&color=F97316&size=128" alt="محمد علي" class="w-full h-full object-cover">

                            </div>

                        </div>

                        <p class="text-gray-700 text-base mb-4 italic">"أفضل متجر لملابس الأطفال، تصاميم رائعة وأسعار مناسبة."</p>

                        <div class="stars text-orange-400 text-xl mb-2">★★★★★</div>

                        <h5 class="font-semibold text-gray-900 text-lg">محمد علي</h5>

                    </div>

                @endfor

            </div>

        </div>

    </div>

</section>



{{-- Footer --}}

<footer class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-20 pb-10">

    <div class="max-w-screen-xl mx-auto px-6">

        <div class="grid md:grid-cols-4 gap-12 mb-16">

            <div>

                <h4 class="text-2xl font-black text-white mb-4 tracking-wide">MELEKLER GROUP</h4>

                <p class="text-gray-400 leading-relaxed">متجرك الموثوق لأزياء الأطفال والنساء بتصاميم عصرية وجودة عالية.</p>

                <div class="flex gap-4 mt-6 text-xl">

                    <a href="https://www.instagram.com/meleklerkids/" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-instagram"></i></a>

                    <a href="https://www.facebook.com/MELEKLERKIDSTR" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-facebook"></i></a>

                    <a href="https://api.whatsapp.com/message/CL67ADRC7PMFO1" target="_blank" class="hover:text-orange-500 transition"><i class="fab fa-whatsapp"></i></a>

                </div>

            </div>

            <div>

                <h5 class="font-bold text-white mb-5 text-lg">التسوق</h5>

                <ul class="space-y-3 text-gray-400">

                    <li><a href="#" class="hover:text-white transition">وصل حديثاً</a></li>

                    <li><a href="{{ route('category.boys') }}" class="hover:text-white transition">ملابس أطفال</a></li>

                    <li><a href="{{ route('category.mothers') }}" class="hover:text-white transition">ملابس نساء</a></li>

                </ul>

            </div>

            <div>

                <h5 class="font-bold text-white mb-5 text-lg">خدمة العملاء</h5>

                <ul class="space-y-3 text-gray-400">

                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">اتصل بنا</a></li>

                    <li><a href="/refund-policy" class="hover:text-white transition">سياسة الإرجاع</a></li></ul>

            </div>

            <div>

                <h5 class="font-bold text-white mb-5 text-lg">اشترك في العروض</h5>

                <div class="flex">

                    <input type="email" placeholder="بريدك الإلكتروني" class="w-full px-4 py-3 rounded-l-xl bg-gray-800 border border-gray-700 text-white focus:outline-none" readonly>

                    <button class="px-5 bg-orange-500 rounded-r-xl hover:bg-orange-600 transition">اشتراك</button>

                </div>

            </div>

        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">

            <p class="text-gray-500 text-sm">© 2026 Melekler Fashion — جميع الحقوق محفوظة</p>

            <p class="text-gray-600 text-xs">CREATED BY ALAA ALAKRABANI</p>

        </div>

    </div>

</footer>



{{-- Marquee Footer --}}

<div class="marquee-footer">

    <div class="marquee-inner-wrap">

        <div class="marquee-content">

            <span>شحن مجاني للطلبات فوق 1000 ₺</span>

            <i class="fas fa-star"></i>

            <span>خصم 10% على أول طلب</span>

            <i class="fas fa-star"></i>

            <span>جودة تركية فاخرة</span>

            <i class="fas fa-star"></i>

        </div>

        <div class="marquee-content">

            <span>شحن مجاني للطلبات فوق 1000 ₺</span>

            <i class="fas fa-star"></i>

            <span>خصم 10% على أول طلب</span>

            <i class="fas fa-star"></i>

            <span>جودة تركية فاخرة</span>

            <i class="fas fa-star"></i>

        </div>

    </div>

</div>



{{-- Floating Buttons --}}

<div class="floating-contact-buttons">

    <a href="#" class="contact-button whatsapp-button"><i class="fab fa-whatsapp"></i></a>

    <a href="#" class="contact-button livechat-button"><i class="fas fa-comments"></i></a>

</div>



{{-- Modals --}}

<div id="sizeModal" class="fixed inset-0 bg-black/60 z-[200] hidden flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl p-8 max-w-md w-full">

        <h3 class="text-2xl font-bold mb-6">اختر المقاس</h3>

        <div id="sizesContainer" class="flex flex-wrap gap-3 mb-8"></div>

        <div class="flex gap-4">

            <button onclick="confirmAddToCart()" class="flex-1 bg-black text-white py-4 rounded-xl font-bold">تأكيد</button>

            <button onclick="document.getElementById('sizeModal').classList.add('hidden')" class="flex-1 bg-gray-100 py-4 rounded-xl font-bold">إلغاء</button>

        </div>

    </div>

</div>



<div id="videoModal" class="fixed inset-0 bg-black z-[300] hidden flex items-center justify-center">

    <button onclick="closeVideoModal()" class="absolute top-8 right-8 text-white text-4xl">&times;</button>

    <video id="storyVideo" class="max-h-full max-w-full" controls></video>

</div>



{{-- ------------------------------------------------------------------ --}}
{{-- 🚀 SCRIPTS CLEANED & OPTIMIZED --}}
{{-- ------------------------------------------------------------------ --}}

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // 1. Tawk.to Integration
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/699b1c15c165071c358882eb/1ji2ubd4s';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();

    // 2. Global State
    let selectedProduct = null;
    let selectedSize = null;

    // 3. Functions
    function openSizeModal(productId, sizes) {
        selectedProduct = productId;
        selectedSize = null;
        const container = document.getElementById("sizesContainer");
        if (!container) return;
        container.innerHTML = "";
        
        if (!sizes || sizes.length === 0) { confirmAddToCart(); return; }
        
        sizes.forEach(size => {
            const btn = document.createElement("button");
            btn.innerText = size;
            btn.className = "border px-4 py-2 rounded-xl hover:bg-gray-50 transition";
            btn.onclick = () => {
                selectedSize = size;
                container.querySelectorAll("button").forEach(b => b.classList.remove("bg-black", "text-white"));
                btn.classList.add("bg-black", "text-white");
            };
            container.appendChild(btn);
        });
        document.getElementById("sizeModal").classList.remove("hidden");
    }

    async function confirmAddToCart() {
        try {
            const response = await fetch(`/cart/add/${selectedProduct}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ size: selectedSize })
            });
            const data = await response.json();
            const cartCount = document.getElementById("cart-count");
            if (cartCount) cartCount.innerText = data.count;
            document.getElementById("sizeModal").classList.add("hidden");
            showToast("تمت الإضافة للسلة ✅");
        } catch (e) {
            console.error(e);
            document.getElementById("sizeModal").classList.add("hidden");
            showToast("تمت الإضافة للسلة ✅");
        }
    }

    function showToast(message) {
        const toast = document.createElement("div");
        toast.innerText = message;
        toast.className = "fixed bottom-5 right-5 bg-black text-white px-4 py-2 rounded-lg z-[1000]";
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    }

    function openVideoModal(src) {
        const v = document.getElementById('storyVideo');
        const m = document.getElementById('videoModal');
        if (v && m) {
            v.src = src;
            m.classList.remove('hidden');
            v.play();
            document.body.style.overflow = 'hidden';
        }
    }

    function closeVideoModal() {
        const v = document.getElementById('storyVideo');
        const m = document.getElementById('videoModal');
        if (v && m) {
            v.pause();
            v.src = "";
            m.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // 4. Initializations on DOM Load
    document.addEventListener('DOMContentLoaded', function() {
        
        // دمج السلايدر الرئيسي وحل مشكلة تكراره مع إعادة تشغيل أنميشن النص بسلاسة
        if (document.querySelector('.mainHeroSwiper')) {
            new Swiper('.mainHeroSwiper', {
                loop: true,
                speed: 1200,
                effect: "fade", // تم الحفاظ على تأثير التلاشي الفاخر
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                grabCursor: true,
                on: {
                    slideChangeTransitionStart: function () {
                        document.querySelectorAll('.fadeUp').forEach(el => {
                            el.style.animation = 'none';
                            el.offsetHeight; /* Trigger reflow */
                            el.style.animation = null;
                        });
                    }
                }
            });
        }

        // Stories Swiper
        if (document.querySelector('.storiesSwiper')) {
            new Swiper('.storiesSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 15,
                freeMode: true,
                grabCursor: true
            });
        }

        // Scroll Reveal Element Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
    });
</script>


@endsection
