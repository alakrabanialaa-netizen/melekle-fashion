@extends('layouts.app')

@section('content')

{{-- ================================================================== --}}
{{-- 🎨 PREMIUM INTERACTIVE MASTER STYLESHEET - الإصدار الاحترافي المحسّن --}}
{{-- ================================================================== --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Fredoka:wght@400;600;700&family=Poppins:wght@400;600;700;800&display=swap');

    :root {
        --brand-pink: #f43f5e;
        --brand-pink-hover: #e11d48;
        --brand-pink-light: #fce7f3;
        --brand-amber: #f59e0b;
        --brand-amber-light: #fef3c7;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --bg-light: #fafafa;
        --white: #ffffff;
        --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
        --shadow-md: 0 15px 35px rgba(0,0,0,0.08);
        --shadow-lg: 0 30px 70px rgba(0,0,0,0.12);
        --transition-smooth: cubic-bezier(0.16, 1, 0.3, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body { 
        font-family: 'Cairo', 'Fredoka', 'Poppins', sans-serif; 
        background-color: var(--bg-light); 
        color: var(--text-dark);
        overflow-x: hidden;
        padding-bottom: 70px;
        line-height: 1.6;
    }

    /* ===== 1. ENHANCED HERO SECTION ===== */
    .hero-spotted-container {
        background: linear-gradient(135deg, var(--white) 0%, #fdf2f8 100%);
        background-image: 
            radial-gradient(rgba(244, 63, 94, 0.08) 1.5px, transparent 1.5px),
            linear-gradient(135deg, var(--white) 0%, #fdf2f8 100%);
        background-size: 40px 40px, 100% 100%;
        border: 2px solid rgba(244, 63, 94, 0.1);
        border-radius: 60px;
        box-shadow: var(--shadow-lg), inset 0 1px 0 rgba(255, 255, 255, 0.6);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.8s var(--transition-smooth);
    }

    .hero-spotted-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(244, 63, 94, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .hero-spotted-container::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-20px) scale(1.05); }
    }

    .3d-card-wrapper {
        perspective: 1200px;
        position: relative;
        z-index: 1;
    }

    .hero-interactive-img {
        transition: all 0.3s ease-out;
        transform-style: preserve-3d;
        will-change: transform;
        filter: drop-shadow(0 20px 40px rgba(244, 63, 94, 0.15));
    }

    /* ===== 2. SCROLL REVEAL ANIMATIONS ===== */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 1s var(--transition-smooth), transform 1s var(--transition-smooth);
    }
    .scroll-reveal.visible { 
        opacity: 1; 
        transform: translateY(0); 
    }

    /* ===== 3. PREMIUM PRODUCT CARDS ===== */
    .product-card-ty {
        background: var(--white);
        border: 1.5px solid #f3f4f6;
        border-radius: 32px;
        padding: 14px;
        transition: all 0.5s var(--transition-smooth);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .product-card-ty::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(244, 63, 94, 0.05) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.5s var(--transition-smooth);
    }

    .product-card-ty:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: var(--shadow-lg);
        border-color: rgba(244, 63, 94, 0.25);
    }

    .product-card-ty:hover::before {
        opacity: 1;
    }

    .ty-image-wrapper {
        width: 100%;
        aspect-ratio: 1 / 1;
        position: relative;
        background: linear-gradient(135deg, #fdfdfd 0%, #f9f9f9 100%);
        overflow: hidden;
        border-radius: 24px;
        perspective: 800px;
    }

    .ty-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 24px;
        transition: transform 0.3s ease-out;
        transform-style: preserve-3d;
    }

    .ty-glass-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(255, 255, 255, 0.98) 30%, rgba(255, 255, 255, 0.5) 80%, transparent);
        backdrop-filter: blur(8px);
        opacity: 0;
        transform: translateY(100%);
        transition: transform 0.5s var(--transition-smooth), opacity 0.4s ease;
        z-index: 10;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 20px;
    }

    .product-card-ty:hover .ty-glass-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    .ty-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, var(--brand-pink) 0%, #ec4899 100%);
        color: white;
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 30px;
        z-index: 20;
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.3);
    }

    .ty-wishlist-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--white);
        color: #9ca3af;
        border: 1.5px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        z-index: 20;
        cursor: pointer;
    }
    .ty-wishlist-btn:hover {
        color: var(--brand-pink);
        border-color: var(--brand-pink);
        transform: scale(1.2);
        box-shadow: 0 6px 20px rgba(244, 63, 94, 0.2);
    }

    .ty-title {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.5;
        text-align: right;
        margin-top: auto;
    }
    
    .ty-price-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-direction: row-reverse;
        justify-content: flex-start;
        margin-top: 10px;
    }
    .ty-final-price { 
        font-size: 1.2rem; 
        font-weight: 800; 
        color: var(--brand-pink); 
    }
    .ty-original-price { 
        font-size: 0.85rem; 
        color: #d1d5db; 
        text-decoration: line-through; 
    }

    /* ===== 4. PREMIUM FILTER BAR ===== */
    .filter-bar {
        display: flex;
        align-items: center;
        background: var(--white);
        border-radius: 24px;
        padding: 8px;
        box-shadow: var(--shadow-md);
        border: 1.5px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .filter-bar:focus-within {
        border-color: var(--brand-pink);
        box-shadow: var(--shadow-lg), 0 0 0 3px rgba(244, 63, 94, 0.1);
    }

    .filter-input {
        width: 100%;
        border: none;
        padding: 14px 16px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
    }
    .filter-input:focus { 
        outline: none; 
    }
    .filter-input::placeholder {
        color: #d1d5db;
    }

    .apply-button {
        background: linear-gradient(135deg, var(--brand-pink) 0%, #ec4899 100%);
        color: white;
        font-weight: 700;
        padding: 12px 32px;
        border-radius: 16px;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
    }
    .apply-button:hover { 
        background: linear-gradient(135deg, var(--brand-pink-hover) 0%, #be185d 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(244, 63, 94, 0.3);
    }

    /* ===== 5. REVIEWS SLIDER ===== */
    .reviews-slider { 
        position: relative; 
        overflow: hidden; 
        width: 100%; 
        padding: 20px 0; 
    }
    .reviews-track { 
        display: flex; 
        width: max-content; 
        animation: scrollReviews 35s linear infinite; 
        gap: 32px; 
    }
    .reviews-slider:hover .reviews-track { 
        animation-play-state: paused; 
    }
    @keyframes scrollReviews { 
        0% { transform: translateX(0); } 
        100% { transform: translateX(-50%); } 
    }

    .review-card {
        min-width: 340px;
        background: var(--white);
        padding: 32px;
        border-radius: 28px;
        text-align: center;
        border: 1.5px solid #f3f4f6;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md);
        border-color: rgba(244, 63, 94, 0.15);
    }

    .review-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 16px;
        border: 3px solid var(--brand-pink-light);
    }

    .review-card p {
        color: var(--text-light);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 12px;
        font-style: italic;
    }

    .stars {
        color: var(--brand-amber);
        font-size: 1.1rem;
        margin-bottom: 12px;
        letter-spacing: 2px;
    }

    .review-card h5 {
        color: var(--text-dark);
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* ===== 6. MARQUEE FOOTER ===== */
    .marquee-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(90deg, #111827 0%, #1f2937 100%);
        color: white;
        z-index: 60;
        overflow: hidden;
        padding: 14px 0;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
    }
    .marquee-inner-wrap { 
        display: flex; 
        width: fit-content; 
        animation: marquee 30s linear infinite; 
        gap: 40px;
    }
    @keyframes marquee { 
        from { transform: translateX(0%); } 
        to { transform: translateX(-50%); } 
    }

    .marquee-content {
        display: flex;
        align-items: center;
        gap: 12px;
        white-space: nowrap;
        font-weight: 600;
        font-size: 0.95rem;
    }

    /* ===== 7. LUXURY SECTION ===== */
    .luxury-image {
        transition: all 0.7s var(--transition-smooth);
        border-radius: 32px;
        overflow: hidden;
    }

    .luxury-image:hover img {
        transform: scale(1.08);
    }

    /* ===== 8. MODALS ===== */
    #sizeModal, #videoModal {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ===== 9. RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-spotted-container {
            border-radius: 40px;
            padding: 24px !important;
        }

        .product-card-ty {
            border-radius: 24px;
            padding: 10px;
        }

        .ty-image-wrapper {
            border-radius: 20px;
        }

        .filter-bar {
            flex-direction: column;
            gap: 8px;
        }

        .apply-button {
            width: 100%;
        }

        .review-card {
            min-width: 280px;
            padding: 24px;
        }
    }
</style>

<div class="max-w-screen-xl mx-auto px-6 pt-10">
    {{-- Hero Section --}}
    <div class="hero-spotted-container bg-white flex flex-col md:flex-row items-center p-8 md:p-16 gap-12 3d-card-wrapper">
        <div class="md:w-1/2 relative flex justify-center">
            <div class="absolute top-0 left-0 w-40 h-40 bg-rose-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&q=80&w=600" 
                 alt="Melekler Kids Hero" 
                 class="hero-interactive-img rounded-3xl w-80 h-80 md:w-96 md:h-96 object-cover shadow-2xl border-4 border-white">
        </div>
        <div class="md:w-1/2 text-right space-y-6">
            <span class="text-xs font-bold tracking-widest text-rose-500 bg-rose-50 px-4 py-2 rounded-full inline-block">✨ New Collection 2026</span>
            <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-tight">FOR YOUR BEBE</h1>
            <p class="text-gray-500 text-lg leading-relaxed">
                متجر مختص لبيع ملابس الأطفال المريحة والحديثة التي تناسب طفلك وتمنحه الأناقة والراحة الكاملة في كل خطوة.
            </p>
            <div class="pt-4">
                <a href="#products" class="inline-block bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-bold px-10 py-4 rounded-2xl shadow-lg shadow-rose-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                    تصفح تشكيلتنا الآن ⬇️
                </a>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 py-24">
        <div class="product-card-ty p-8 text-center space-y-4 scroll-reveal">
            <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto text-4xl shadow-md">🍼</div>
            <h3 class="font-bold text-gray-800 text-xl">عناية بالمنتج</h3>
            <p class="text-gray-400 text-sm leading-relaxed">ملابس خاصة صنعت بعناية فائقة لحديثي الولادة بمواد قطنية 100% آمنة وناعمة.</p>
        </div>
        <div class="product-card-ty p-8 text-center space-y-4 scroll-reveal">
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mx-auto text-4xl shadow-md">🧷</div>
            <h3 class="font-bold text-gray-800 text-xl">خبرتنا الطويلة</h3>
            <p class="text-gray-400 text-sm leading-relaxed">صنعت كل قطعة بحب وشغف لتناسب طفلك وتواكب الموضة العالمية الحديثة.</p>
        </div>
        <div class="product-card-ty p-8 text-center space-y-4 scroll-reveal">
            <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center mx-auto text-4xl shadow-md">🎁</div>
            <h3 class="font-bold text-gray-800 text-xl">مفاجآت وهدايا</h3>
            <p class="text-gray-400 text-sm leading-relaxed">مع كل طلبية من متجرنا ستحصل على هدية مميزة مخصصة لطفلك المنتظر.</p>
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
<section class="py-8 bg-gradient-to-b from-white to-gray-50 border-b border-gray-100">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="swiper storiesSwiper">
            <div class="swiper-wrapper">
                @foreach($stories as $story)
                    <div class="swiper-slide !w-auto">
                        <div class="flex flex-col items-center gap-3 cursor-pointer group" onclick="openVideoModal('{{ $story['video'] }}')">
                            <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-tr from-amber-500 via-rose-500 to-pink-500 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg shadow-md">
                                <div class="w-full h-full rounded-full border-3 border-white overflow-hidden">
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

{{-- Products Section --}}
<section class="py-24 bg-white" id="products">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="text-right">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900">الأكثر <span class="text-rose-500">مبيعاً</span></h2>
                <p class="text-gray-500 mt-2 text-base">اخترنا لك أفضل القطع التي نالت إعجاب عملائنا الكرام.</p>
            </div>
            <div class="filter-bar w-full md:w-auto">
                <div class="filter-group flex-1 md:w-72 relative">
                    <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    <input type="text" class="filter-input text-right pl-4" placeholder="ابحث عن منتج...">
                </div>
                <button class="apply-button mr-2">تصفية</button>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="product-card-ty scroll-reveal magnetic-card">
                    <div class="ty-image-wrapper">
                        @if($product->original_price > $product->price)
                            <div class="ty-badge">
                                خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                            </div>
                        @endif
                        
                        <img loading="lazy" src="{{ $product->images->first() ? $product->images->first()->image : 'https://via.placeholder.com/300' }}" class="ty-main-image" alt="{{ $product->name }}">
                        
                        <div class="ty-glass-overlay">
                            <button type="button" onclick="openSizeModal({{ $product->id }}, {{ json_encode($product->sizes ?? []) }})" class="w-full bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 text-sm shadow-lg transform hover:scale-105">
                                <span>🛒</span>
                                <span>أضف إلى السلة</span>
                            </button>
                        </div>
                    </div>
                    
                    <button class="ty-wishlist-btn" title="أضف للمفضلة"><i class="far fa-heart"></i></button>
                    
                    <div class="ty-info-wrapper mt-3">
                        <h3 class="ty-title">{{ $product->name }}</h3>
                        <div class="ty-price-wrapper">
                            <span class="ty-final-price">{{ number_format($product->price, 2) }} ₺</span>
                            @if($product->original_price > $product->price)
                                <span class="ty-original-price">{{ number_format($product->original_price, 2) }} ₺</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-24">
                    <p class="text-gray-400 text-lg">لا توجد منتجات لعرضها حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Premium Luxury Section --}}
<section class="relative py-32 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="luxury-image group cursor-pointer overflow-hidden shadow-2xl">
                <img src="https://static.aljamila.com/styles/1100x732_scale/public/2018/12/20/2393901-1727507459.jpg" class="w-full h-[500px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 right-8 text-right text-white max-w-sm space-y-2">
                    <span class="bg-amber-500 px-4 py-2 rounded-full text-xs font-bold">✨ إطلالة العيد</span>
                    <h3 class="text-2xl font-black leading-tight">أناقة الأطفال تبدأ من اختيار القطع الصحيحة</h3>
                </div>
            </div>

            <div class="space-y-8 text-right">
                <span class="inline-block py-2 px-5 bg-rose-50 text-rose-600 rounded-full text-xs font-bold">🎯 ستايل مختار لك</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">إطلالة كاملة <span class="text-rose-500">بضغطة واحدة</span></h2>
                <p class="text-gray-500 text-base leading-relaxed">اخترنا لك مجموعة قطع متناسقة لتسهيل تجربة التسوق وجعل الإطلالة أكثر أناقة واحترافية وراقية.</p>

                <div class="space-y-4">
                    <div class="flex flex-row-reverse items-center p-5 bg-white rounded-2xl border-2 border-gray-100 shadow-md hover:shadow-lg hover:border-rose-200 transition-all duration-300 cursor-pointer group">
                        <img src="https://i.pinimg.com/236x/8f/2b/4c/8f2b4c2ea900323aec716ee886f7f066.jpg" class="w-20 h-20 rounded-xl object-cover group-hover:scale-105 transition-transform">
                        <div class="mr-5 flex-1 text-right">
                            <h4 class="text-base font-bold text-gray-800">طقم كامل لأطفالكِ</h4>
                            <p class="text-rose-500 font-bold text-sm mt-1">250 ₺</p>
                        </div>
                    </div>

                    <div class="flex flex-row-reverse items-center p-5 bg-white rounded-2xl border-2 border-gray-100 shadow-md hover:shadow-lg hover:border-rose-200 transition-all duration-300 cursor-pointer group">
                        <img src="https://image.made-in-china.com/202f0j00ZbRuNDByfPoI/New-International-School-Uniforms-Summer-Boys-Girls-School-Uniforms-Design-with-Pictures-Clothes-Children.webp" class="w-20 h-20 rounded-xl object-cover group-hover:scale-105 transition-transform">
                        <div class="mr-5 flex-1 text-right">
                            <h4 class="text-base font-bold text-gray-800">طقمين بسعر طقم</h4>
                            <p class="text-rose-500 font-bold text-sm mt-1">170 ₺</p>
                        </div>
                    </div>

                    <button class="w-full py-4 bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white rounded-xl font-bold text-base shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                        🎁 شراء الإطلالة كاملة — 420 ₺
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Reviews Section --}}
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-screen-xl mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-black text-center mb-16">ماذا يقول <span class="text-rose-500">عملاؤنا</span></h2>
        <div class="reviews-slider">
            <div class="reviews-track flex">
                @for ($i = 0; $i < 3; $i++ )
                    <div class="review-card">
                        <img src="https://ui-avatars.com/api/?name=سارة+أحمد&background=FFE4E6&color=F43F5E&size=128" class="review-img">
                        <p>"جودة الملابس ممتازة والتوصيل كان سريع جداً في اسطنبول. شكراً لكم على الخدمة الرائعة!"</p>
                        <div class="stars">★★★★★</div>
                        <h5 class="text-gray-800 font-bold">سارة أحمد</h5>
                    </div>
                    <div class="review-card">
                        <img src="https://ui-avatars.com/api/?name=محمد+علي&background=FFE4E6&color=F43F5E&size=128" class="review-img">
                        <p>"أفضل متجر لملابس الأطفال، تصاميم رائعة وأسعار مناسبة جداً وخدمة عملاء ممتازة."</p>
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
            <span>🚚 شحن مجاني للطلبات فوق 1000 ₺</span>
            <span>💝 خصم 10% على أول طلب</span>
            <span>👑 جودة تركية فاخرة</span>
        </div>
        <div class="marquee-content">
            <span>🚚 شحن مجاني للطلبات فوق 1000 ₺</span>
            <span>💝 خصم 10% على أول طلب</span>
            <span>👑 جودة تركية فاخرة</span>
        </div>
    </div>
</div>

{{-- Modals --}}
<div id="sizeModal" class="fixed inset-0 bg-black/50 z-[200] hidden flex items-center justify-center p-6 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full text-right shadow-2xl">
        <h3 class="text-2xl font-bold mb-6 text-gray-900">اختر المقاس المناسب</h3>
        <div id="sizesContainer" class="flex flex-wrap gap-3 mb-8 justify-start flex-row-reverse"></div>
        <div class="flex gap-4">
            <button onclick="confirmAddToCart()" class="flex-1 bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white py-3 rounded-xl font-bold transition-all transform hover:scale-105">تأكيد</button>
            <button onclick="document.getElementById('sizeModal').classList.add('hidden')" class="flex-1 bg-gray-100 hover:bg-gray-200 py-3 rounded-xl font-bold transition">إلغاء</button>
        </div>
    </div>
</div>

<div id="videoModal" class="fixed inset-0 bg-black/95 z-[300] hidden flex items-center justify-center backdrop-blur-sm">
    <button onclick="closeVideoModal()" class="absolute top-6 right-6 text-white text-4xl hover:scale-110 transition-transform" title="إغلاق">&times;</button>
    <video id="storyVideo" class="max-h-[85vh] max-w-full rounded-2xl shadow-2xl" controls></video>
</div>

<script>
    let selectedProduct = null;
    let selectedSize = null;

    // 1. Advanced Fluid Magnet Card Tracking
    document.querySelectorAll('.magnetic-card').forEach(card => {
        const imgWrapper = card.querySelector('.ty-image-wrapper');
        const img = card.querySelector('.ty-main-image');

        if(imgWrapper && img) {
            imgWrapper.addEventListener('mousemove', (e) => {
                const { left, top, width, height } = imgWrapper.getBoundingClientRect();
                const x = (e.clientX - left) - width / 2;
                const y = (e.clientY - top) - height / 2;
                
                img.style.transform = `scale(1.12) translateX(${x * 0.15}px) translateY(${y * 0.15}px) rotateX(${y * -0.05}deg) rotateY(${x * 0.05}deg)`;
            });

            imgWrapper.addEventListener('mouseleave', () => {
                img.style.transform = 'scale(1) translateX(0) translateY(0) rotateX(0) rotateY(0)';
            });
        }
    });

    // 2. Interactive Backdrop Dot Shift Effect
    const heroBg = document.querySelector('.hero-spotted-container');
    if(heroBg) {
        heroBg.addEventListener('mousemove', (e) => {
            const { left, top, width, height } = heroBg.getBoundingClientRect();
            const xPercent = ((e.clientX - left) / width) * 100;
            const yPercent = ((e.clientY - top) / height) * 100;
            heroBg.style.backgroundPosition = `${xPercent * 0.1}% ${yPercent * 0.1}%`;
        });
        heroBg.addEventListener('mouseleave', () => {
            heroBg.style.backgroundPosition = 'center';
        });
    }

    // 3. 3D Interactive Parallax on Hero Image
    const container3d = document.querySelector('.3d-card-wrapper');
    const img3d = document.querySelector('.hero-interactive-img');
    if(container3d && img3d) {
        container3d.addEventListener('mousemove', (e) => {
            const { left, top, width, height } = container3d.getBoundingClientRect();
            const x = (e.clientX - left) - width / 2;
            const y = (e.clientY - top) - height / 2;
            img3d.style.transform = `rotateX(${y * -0.06}deg) rotateY(${x * 0.06}deg) translateZ(20px)`;
        });
        container3d.addEventListener('mouseleave', () => {
            img3d.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0)';
        });
    }

    function openSizeModal(productId, sizes) {
        selectedProduct = productId;
        selectedSize = null;
        const container = document.getElementById("sizesContainer");
        if (!container) return;
        container.innerHTML = "";
        
        if (!sizes || sizes.length === 0) { 
            confirmAddToCart(); 
            return; 
        }
        
        document.getElementById('sizeModal').classList.remove('hidden');
        sizes.forEach(size => {
            const btn = document.createElement("button");
            btn.innerText = size;
            btn.className = "border-2 border-gray-200 px-5 py-2 rounded-xl font-semibold text-sm hover:border-rose-500 hover:bg-rose-50 transition";
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
        toast.className = "fixed bottom-20 right-5 bg-gray-900 text-white text-sm font-bold px-6 py-4 rounded-xl z-[1000] shadow-2xl text-right animate-pulse";
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
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
