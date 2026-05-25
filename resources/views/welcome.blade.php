@extends('layouts.app')

@section('content')

{{-- ------------------------------------------------------------------ --}}
{{-- 🎨 MASTER STYLESHEET - النسخة الاحترافية الفاخرة المطورة لعام 2026 --}}
{{-- ------------------------------------------------------------------ --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Fredoka:wght@400;600;700&display=swap');

    /* --- 1. Global & Variables --- */
    :root {
        --brand-pink: #f43f5e;
        --brand-pink-hover: #e11d48;
        --brand-gold: #eab308;
        --soft-bg: #fafafa;
        --text-dark: #1f2937;
    }

    body { 
        font-family: 'Cairo', 'Fredoka', sans-serif; 
        background-color: var(--soft-bg); 
        color: var(--text-dark);
        overflow-x: hidden;
        padding-bottom: 50px; 
    }

    /* --- 2. Advanced Animations & Parallax --- */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .scroll-reveal.visible { opacity: 1; transform: translateY(0); }

    .tilt-container {
        transform-style: preserve-3d;
        perspective: 1000px;
    }
    .tilt-element {
        transition: transform 0.1s ease-out, box-shadow 0.3s ease;
    }

    /* --- 3. Refined Hero Section --- */
    .hero-spotted-container {
        background-image: radial-gradient(#e5e7eb 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        border: 8px solid white;
        border-radius: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    }

    /* --- 4. Premium Cards (Glassmorphism Light) --- */
    .premium-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 30px rgba(244, 63, 94, 0.08);
        border-color: rgba(244, 63, 94, 0.2);
    }

    /* --- 5. Clean Product Cards --- */
    .product-card-ty {
        background: #ffffff;
        border: 1px solid #f3f4f6;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .product-card-ty:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.06);
    }
    .ty-image-wrapper {
        padding: 12px;
        aspect-ratio: 1 / 1;
        position: relative;
        background: #fafafa;
        overflow: hidden;
    }
    .ty-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 14px;
        transition: transform 0.5s ease;
    }
    .product-card-ty:hover .ty-main-image {
        transform: scale(1.04);
    }
    .ty-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: var(--brand-pink);
        color: white;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 30px;
        z-index: 10;
    }
    .ty-wishlist-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: white;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        z-index: 10;
    }
    .ty-wishlist-btn:hover {
        color: var(--brand-pink);
        transform: scale(1.1);
    }
    .ty-info-wrapper {
        padding: 16px;
        text-align: right;
        flex-grow: 1;
    }
    .ty-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    .ty-price-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-direction: row-reverse;
        justify-content: flex-start;
    }
    .ty-final-price { font-size: 1.1rem; font-weight: 700; color: var(--brand-pink); }
    .ty-original-price { font-size: 0.85rem; color: #9ca3af; text-decoration: line-through; }

    /* --- 6. Modern Filter Bar --- */
    .filter-bar {
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 16px;
        padding: 6px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        border: 1px solid #f3f4f6;
    }
    .filter-input {
        width: 100%;
        border: none;
        padding: 10px 40px 10px 12px;
        font-weight: 600;
        color: #374151;
    }
    .filter-input:focus { outline: none; }
    .apply-button {
        background-color: var(--brand-pink);
        color: white;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    .apply-button:hover { background-color: var(--brand-pink-hover); transform: scale(1.02); }

    /* --- 7. Continuous Smooth Reviews --- */
    .reviews-slider { position: relative; overflow: hidden; width: 100%; padding: 10px 0; }
    .reviews-track { display: flex; width: max-content; animation: scrollReviews 30s linear infinite; gap: 24px; }
    .reviews-slider:hover .reviews-track { animation-play-state: paused; }
    @keyframes scrollReviews { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    
    /* --- 8. Infinite Marquee Footer --- */
    .marquee-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #111827;
        color: white;
        z-index: 60;
        overflow: hidden;
        padding: 10px 0;
    }
    .marquee-inner-wrap { display: flex; width: fit-content; animation: marquee 25s linear infinite; }
    @keyframes marquee { from { transform: translateX(0%); } to { transform: translateX(-50%); } }

    /* --- 9. Wave Decorative Div --- */
    .wave-divider {
        background: var(--brand-pink);
        position: relative;
        border-radius: 40px 40px 0 0;
    }
</style>

<div class="max-w-screen-xl mx-auto px-6 pt-8">
    {{-- Hero Section (The Elegant Spotted Interactive Container) --}}
    <div class="hero-spotted-container bg-white tilt-container flex flex-col md:flex-row items-center p-8 md:p-16 gap-12">
        <div class="md:w-1/2 relative flex justify-center">
            <div class="absolute top-0 left-0 w-40 h-40 bg-rose-100 rounded-full mix-blend-multiply filter blur-2xl opacity-60"></div>
            {{-- تفعيل تأثير الـ 3D هنا --}}
            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&q=80&w=600" 
                 alt="Melekler Kids Hero" 
                 class="tilt-element rounded-3xl w-80 h-80 md:w-96 md:h-96 object-cover shadow-2xl border-4 border-white">
        </div>
        <div class="md:w-1/2 text-right md:text-right space-y-6">
            <span class="text-xs font-bold tracking-widest text-rose-500 uppercase bg-rose-50 px-3 py-1 rounded-full">New Collection 2026</span>
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 leading-tight">FOR YOUR BEBE</h1>
            <p class="text-gray-500 text-lg leading-relaxed">
                متجر مختص لبيع ملابس الأطفال المريحة والحديثة التي تناسب طفلك وتمنحه الأناقة والراحة الكاملة في كل خطوة.
            </p>
            <div class="pt-2">
                <a href="#" class="inline-block bg-rose-500 hover:bg-rose-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-rose-200 transition-all duration-300 transform hover:-translate-y-1">تصفح تشكيلتنا الآن</a>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-20">
        <div class="premium-card p-8 text-center space-y-4">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto text-3xl shadow-inner">🍼</div>
            <h3 class="font-bold text-gray-800 text-xl">عناية بالمنتج</h3>
            <p class="text-gray-400 text-sm leading-relaxed">ملابس خاصة صنعت بعناية فائقة لحديثي الولادة بمواد قطنية 100%.</p>
        </div>
        <div class="premium-card p-8 text-center space-y-4">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mx-auto text-3xl shadow-inner">🧷</div>
            <h3 class="font-bold text-gray-800 text-xl">خبرتنا الطويلة</h3>
            <p class="text-gray-400 text-sm leading-relaxed">صنعت كل قطعة بحب وشغف لتناسب طفلك وتواكب الموضة العالمية.</p>
        </div>
        <div class="premium-card p-8 text-center space-y-4">
            <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mx-auto text-3xl shadow-inner">🪄</div>
            <h3 class="font-bold text-gray-800 text-xl">مفاجآت وهدايا</h3>
            <p class="text-gray-400 text-sm leading-relaxed">مع كل طلبية من متجرنا ستحصل على هدية مميزة مخصصة لطفلك المنتظر.</p>
        </div>
    </div>
</div>

{{-- Bottom Event Section --}}
<div class="wave-divider py-20 text-white">
    <div class="max-w-screen-xl mx-auto px-6 flex flex-col md:flex-row gap-16">
        <div class="md:w-1/2 space-y-6">
            <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-bold">فعاليات Melekler</span>
            <h2 class="text-4xl font-black">حدث أبريل المرتقب للأطفال</h2>
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10 space-y-4">
                <div class="flex flex-wrap gap-4 text-xs font-bold opacity-90">
                    <span>📅 17.04.2026</span>
                    <span>⏰ 09:00 AM</span>
                    <span>📍 إسطنبول، تركيا</span>
                </div>
                <p class="leading-relaxed text-sm opacity-90">
                    انضموا إلينا في فعاليتنا القادمة حيث سنقوم بالعديد من الأنشطة التفاعلية والمسابقات الممتعة للأطفال مع توزيع الهدايا الكبرى.
                </p>
                <a href="#" class="inline-block bg-white text-rose-600 font-bold px-6 py-3 rounded-xl text-sm shadow-md hover:bg-gray-50 transition">معرفة المزيد</a>
            </div>
        </div>

        {{-- Calendar --}}
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/10 w-full max-w-sm">
                <div class="flex justify-between items-center mb-6 font-bold text-sm tracking-wider uppercase">
                    <button class="hover:text-amber-300">←</button>
                    <span>April 2026</span>
                    <button class="hover:text-amber-300">→</button>
                </div>
                <div class="calendar-grid text-center text-xs opacity-60 mb-3 font-bold">
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

@php
    $stories = [
        ['name' => 'جديدنا', 'image' => 'https://i.pravatar.cc/150?u=1', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
        ['name' => 'عروض العيد', 'image' => 'https://i.pravatar.cc/150?u=2', 'video' => 'https://www.w3schools.com/html/movie.mp4'],
        ['name' => 'وصل حديثاً', 'image' => 'https://i.pravatar.cc/150?u=3', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
        ['name' => 'ملابس أولاد', 'image' => 'https://i.pravatar.cc/150?u=4', 'video' => 'https://www.w3schools.com/html/movie.mp4'],
        ['name' => 'ملابس بنات', 'image' => 'https://i.pravatar.cc/150?u=5', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
        ['name' => 'تخفيضات', 'image' => 'https://i.pravatar.cc/150?u=6', 'video' => 'https://www.w3schools.com/html/movie.mp4'],
    ];
@endphp

{{-- Stories Section --}}
<section class="py-12 bg-white border-b border-gray-100">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="swiper storiesSwiper">
            <div class="swiper-wrapper">
                @foreach($stories as $story)
                    <div class="swiper-slide !w-auto">
                        <div class="flex flex-col items-center gap-2 cursor-pointer group" onclick="openVideoModal('{{ $story['video'] }}')">
                            <div class="w-20 h-20 rounded-full p-0.5 bg-gradient-to-tr from-amber-500 to-rose-500 transition-all duration-300 group-hover:scale-105">
                                <div class="w-full h-full rounded-full border-2 border-white overflow-hidden">
                                    <img src="{{ $story['image'] }}" class="w-full h-full object-cover" alt="{{ $story['name'] }}">
                                </div>
                            </div>
                            <span class="text-xs font-bold text-gray-700 group-hover:text-rose-500 transition-colors">{{ $story['name'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Categories Grid --}}
<section class="py-20 bg-gray-50/50">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-8 category-grid">
            <div class="category-card scroll-reveal" style="--bg-image: url('https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?q=80&w=1972&auto=format&fit=crop')">
                <div class="card-glow"></div>
                <div class="card-content">
                    <span class="card-subtitle">تشكيلة الأولاد</span>
                    <h2 class="card-title text-3xl md:text-4xl">الأناقة والراحة</h2>
                </div>
            </div>
            <div class="category-card scroll-reveal" style="--bg-image: url('https://images.unsplash.com/photo-1518833278463-d3055863572f?q=80&w=2070&auto=format&fit=crop')">
                <div class="card-glow"></div>
                <div class="card-content">
                    <span class="card-subtitle">تشكيلة البنات</span>
                    <h2 class="card-title text-3xl md:text-4xl">عالم من الألوان</h2>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Products Section --}}
<section class="py-20 bg-white">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="text-right">
                <h2 class="text-3xl font-black text-gray-900">الأكثر <span class="text-rose-500">مبيعاً</span></h2>
                <p class="text-gray-500 mt-1 text-sm">اخترنا لك أفضل القطع التي نالت إعجاب عملائنا.</p>
            </div>
            <div class="filter-bar w-full md:w-auto">
                <div class="filter-group flex-1 md:w-64">
                    <i class="fas fa-search filter-icon"></i>
                    <input type="text" class="filter-input text-right" placeholder="بحث عن منتج...">
                </div>
                <button class="apply-button mr-2">تصفية</button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="product-card-ty scroll-reveal">
                    <a href="{{ route('product.show', $product->id) }}">
                        <div class="ty-image-wrapper">
                            @if($product->original_price > $product->price)
                                <div class="ty-badge">
                                    خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                </div>
                            @endif
                            <img loading="lazy" src="{{ $product->images->first() ? $product->images->first()->image : 'https://via.placeholder.com/300' }}" class="ty-main-image" alt="{{ $product->name }}">
                        </div>
                    </a>
                    <button class="ty-wishlist-btn" title="أضف للمفضلة"><i class="far fa-heart"></i></button>
                    
                    <div class="ty-info-wrapper">
                        <h3 class="ty-title">{{ $product->name }}</h3>
                        <div class="ty-price-wrapper">
                            <span class="ty-final-price">{{ number_format($product->price, 2) }} ₺</span>
                            @if($product->original_price > $product->price)
                                <span class="ty-original-price">{{ number_format($product->original_price, 2) }} ₺</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4">
                        <button type="button" onclick="openSizeModal({{ $product->id }}, {{ json_encode($product->sizes ?? []) }})" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-2.5 px-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 text-sm shadow-md">
                            <span>🛒</span>
                            <span>أضف إلى السلة</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-400">لا توجد منتجات لعرضها حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Premium Luxury Section --}}
<section class="relative py-24 bg-gray-50/50">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative group cursor-pointer overflow-hidden rounded-3xl shadow-xl">
                <img src="https://static.aljamila.com/styles/1100x732_scale/public/2018/12/20/2393901-1727507459.jpg" class="w-full h-[500px] object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 right-8 text-right text-white max-w-sm space-y-2">
                    <span class="bg-amber-500 px-3 py-1 rounded-full text-xs font-bold">إطلالة العيد</span>
                    <h3 class="text-2xl font-black leading-tight">أناقة الأطفال تبدأ من اختيار القطع الصحيحة</h3>
                </div>
            </div>

            <div class="space-y-6 text-right">
                <span class="inline-block py-1 px-4 bg-rose-50 text-rose-600 rounded-full text-xs font-bold">ستايل مختار لك</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 leading-tight">إطلالة كاملة <span class="text-rose-500">بضغطة واحدة</span></h2>
                <p class="text-gray-500 text-base">اخترنا لك مجموعة قطع متناسقة لتسهيل تجربة التسوق وجعل الإطلالة أكثر أناقة واحترافية.</p>

                <div class="space-y-4">
                    <div class="flex flex-row-reverse items-center p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <img src="https://i.pinimg.com/236x/8f/2b/4c/8f2b4c2ea900323aec716ee886f7f066.jpg" class="w-16 h-16 rounded-xl object-cover">
                        <div class="mr-4 flex-1 text-right">
                            <h4 class="text-base font-bold text-gray-800">طقم كامل لأطفالكِ</h4>
                            <p class="text-rose-500 font-bold text-sm mt-0.5">250 ₺</p>
                        </div>
                    </div>

                    <div class="flex flex-row-reverse items-center p-4 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <img src="https://image.made-in-china.com/202f0j00ZbRuNDByfPoI/New-International-School-Uniforms-Summer-Boys-Girls-School-Uniforms-Design-with-Pictures-Clothes-Children.webp" class="w-16 h-16 rounded-xl object-cover">
                        <div class="mr-4 flex-1 text-right">
                            <h4 class="text-base font-bold text-gray-800">طقمين بسعر طقم</h4>
                            <p class="text-rose-500 font-bold text-sm mt-0.5">170 ₺</p>
                        </div>
                    </div>

                    <button class="w-full py-4 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-bold text-md shadow-lg transition-all transform hover:-translate-y-0.5">
                        شراء الإطلالة كاملة — 420 ₺
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Reviews Section --}}
<section class="py-20 bg-white overflow-hidden">
    <div class="max-w-screen-xl mx-auto px-6">
        <h2 class="text-3xl font-black text-center mb-12">ماذا يقول <span class="text-rose-500">عملاؤنا</span></h2>
        <div class="reviews-slider">
            <div class="reviews-track flex">
                @for ($i = 0; $i < 3; $i++ )
                    <div class="review-card">
                        <img src="https://ui-avatars.com/api/?name=سارة+أحمد&background=FFE4E6&color=F43F5E&size=128" class="review-img">
                        <p>"جودة الملابس ممتازة والتوصيل كان سريع جداً في اسطنبول. شكراً لكم!"</p>
                        <div class="stars">★★★★★</div>
                        <h5 class="text-gray-800 font-bold">سارة أحمد</h5>
                    </div>
                    <div class="review-card">
                        <img src="https://ui-avatars.com/api/?name=محمد+علي&background=FFE4E6&color=F43F5E&size=128" class="review-img">
                        <p>"أفضل متجر لملابس الأطفال، تصاميم رائعة وأسعار مناسبة جداً."</p>
                        <div class="stars">★★★★★</div>
                        <h5 class="text-gray-800 font-bold">محمد علي</h5>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>

{{-- Marquee Footer --}}
<div class="marquee-footer">
    <div class="marquee-inner-wrap">
        <div class="marquee-content">
            <span>شحن مجاني للطلبات فوق 1000 ₺</span><i class="fas fa-star text-amber-400"></i>
            <span>خصم 10% على أول طلب</span><i class="fas fa-star text-amber-400"></i>
            <span>جودة تركية فاخرة</span><i class="fas fa-star text-amber-400"></i>
        </div>
        <div class="marquee-content">
            <span>شحن مجاني للطلبات فوق 1000 ₺</span><i class="fas fa-star text-amber-400"></i>
            <span>خصم 10% على أول طلب</span><i class="fas fa-star text-amber-400"></i>
            <span>جودة تركية فاخرة</span><i class="fas fa-star text-amber-400"></i>
        </div>
    </div>
</div>

{{-- Modals --}}
<div id="sizeModal" class="fixed inset-0 bg-black/50 z-[200] hidden flex items-center justify-center p-6 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full text-right">
        <h3 class="text-xl font-bold mb-4">اختر المقاس المناسب</h3>
        <div id="sizesContainer" class="flex flex-wrap gap-3 mb-6 justify-start flex-row-reverse"></div>
        <div class="flex gap-4">
            <button onclick="confirmAddToCart()" class="flex-1 bg-rose-500 text-white py-3 rounded-xl font-bold hover:bg-rose-600 transition">تأكيد</button>
            <button onclick="document.getElementById('sizeModal').classList.add('hidden')" class="flex-1 bg-gray-100 py-3 rounded-xl font-bold hover:bg-gray-200 transition">إلغاء</button>
        </div>
    </div>
</div>

<div id="videoModal" class="fixed inset-0 bg-black/90 z-[300] hidden flex items-center justify-center">
    <button onclick="closeVideoModal()" class="absolute top-6 right-6 text-white text-3xl">&times;</button>
    <video id="storyVideo" class="max-h-[85vh] max-w-full rounded-2xl" controls></video>
</div>

<script>
    // Global State
    let selectedProduct = null;
    let selectedSize = null;

    // 3D Parallax Tilt Effect For Hero Image
    const tiltContainer = document.querySelector('.tilt-container');
    const tiltElement = document.querySelector('.tilt-element');

    if(tiltContainer && tiltElement) {
        tiltContainer.addEventListener('mousemove', (e) => {
            const { left, top, width, height } = tiltContainer.getBoundingClientRect();
            const x = (e.clientX - left) - width / 2;
            const y = (e.clientY - top) - height / 2;
            
            // تحديد زاوية الدوران مع اتجاه حركة الماوس
            const rotateX = (y / height) * -25; 
            const rotateY = (x / width) * 25;

            tiltElement.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(30px)`;
        });

        tiltContainer.addEventListener('mouseleave', () => {
            tiltElement.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0)';
        });
    }

    function openSizeModal(productId, sizes) {
        selectedProduct = productId;
        selectedSize = null;
        const container = document.getElementById("sizesContainer");
        if (!container) return;
        container.innerHTML = "";
        
        if (!sizes || sizes.length === 0) { 
            // إذا لم يكن هناك مقاسات أضف مباشرة
            confirmAddToCart(); 
            return; 
        }
        
        document.getElementById('sizeModal').classList.remove('hidden');
        sizes.forEach(size => {
            const btn = document.createElement("button");
            btn.innerText = size;
            btn.className = "border border-gray-200 px-4 py-2 rounded-xl font-semibold text-sm hover:border-rose-500 transition";
            btn.onclick = () => {
                selectedSize = size;
                container.querySelectorAll("button").forEach(b => b.classList.remove("bg-rose-500", "text-white", "border-rose-500"));
                btn.classList.add("bg-rose-500", "text-white", "border-rose-500");
            };
            container.appendChild(btn);
        });
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
            showToast("تمت إضافة القطعة بنجاح إلى سلتك 🛒✨");
        } catch (e) {
            document.getElementById("sizeModal").classList.add("hidden");
            showToast("تمت إضافة القطعة بنجاح إلى سلتك 🛒✨");
        }
    }

    function showToast(message) {
        const toast = document.createElement("div");
        toast.innerText = message;
        toast.className = "fixed bottom-16 right-5 bg-gray-900 text-white text-sm font-bold px-5 py-3 rounded-xl z-[1000] shadow-2xl text-right";
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2500);
    }

    function openVideoModal(src) {
        const v = document.getElementById('storyVideo');
        const m = document.getElementById('videoModal');
        if (v && m) { v.src = src; m.classList.remove('hidden'); v.play(); }
    }

    function closeVideoModal() {
        const v = document.getElementById('storyVideo');
        const m = document.getElementById('videoModal');
        if (v && m) { v.pause(); v.src = ""; m.classList.add('hidden'); }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('.storiesSwiper')) {
            new Swiper('.storiesSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 16,
                freeMode: true,
                grabCursor: true
            });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
    });
</script>

@endsection
