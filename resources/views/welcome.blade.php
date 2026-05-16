@extends('layouts.app')

@section('content')

{{-- ------------------------------------------------------------------ --}}
{{-- 🎨 PROFESSIONAL CSS STYLES (OPTIIMIZED & SHORTENED) --}}
{{-- ------------------------------------------------------------------ --}}
<style>
    /* Hero Fade Effect & Animation */
    .swiper-slide-active .hero-title { animation: fadeInUp 0.8s ease forwards 0.2s; }
    .swiper-slide-active .hero-desc { animation: fadeInUp 0.8s ease forwards 0.4s; }
    .swiper-slide-active .hero-btn { animation: fadeInUp 0.8s ease forwards 0.6s; }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Professional Category Cards */
    .category-card {
        position: relative;
        height: 450px;
        background-size: cover;
        background-position: center;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .category-card::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
        transition: opacity 0.5s;
    }
    .category-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
    .category-card:hover::before { opacity: 0.85; }

    /* Luxury Product Cards */
    .product-card-ty {
        background: #ffffff; border-radius: 20px; overflow: hidden; position: relative;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #f3f4f6;
    }
    .product-card-ty:hover { transform: translateY(-6px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
    .ty-image-wrapper { position: relative; width: 100%; pt: 125%; overflow: hidden; background: #f9fafb; }
    .ty-image-wrapper img { transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
    .product-card-ty:hover .ty-image-wrapper img { transform: scale(1.06); }

    /* Infinite Marquee */
    .marquee-footer { background: #000; color: #fff; padding: 14px 0; overflow: hidden; white-space: nowrap; font-size: 0.875rem; font-weight: 600; letter-spacing: 0.05em; }
    .marquee-inner-wrap { display: inline-block; animation: marquee linear infinite; animation-duration: 25s; }
    .marquee-content { display: inline-flex; align-items: center; gap: 2rem; padding-right: 2rem; }
    @keyframes marquee { from { transform: translate3d(0, 0, 0); } to { transform: translate3d(-50%, 0, 0); } }

    /* Fixed Floating Contacts Override (Aligning Tawk.to & WhatsApp) */
    .floating-contact-buttons { position: fixed; left: 24px; bottom: 24px; display: flex; flex-col; gap: 16px; z-index: 99; }
    .contact-button { width: 54px; height: 54px; border-radius: 50%; display: flex; items-center; justify-content: center; color: white; box-shadow: 0 8px 24px rgba(0,0,0,0.15); transition: all 0.3s; }
    .whatsapp-button { background-color: #25D366; }
    .whatsapp-button:hover { transform: scale(1.1); background-color: #20ba5a; }
    
    /* Tawk.to Embedded Positioning Customizer */
    iframe#tawkchat-iframe-container { bottom: 90px !important; left: 24px !important; right: auto !important; }

    /* Instagram Style Mobile Video Modal */
    .instagram-modal-content { width: 100%; max-width: 420px; height: 85vh; background: #000; border-radius: 24px; overflow: hidden; position: relative; }
</style>

{{-- ------------------------------------------------------------------ --}}
{{-- 🚀 1. HERO SLIDER SECTION (MAIN SWIPER) --}}
{{-- ------------------------------------------------------------------ --}}
<section class="relative w-full bg-gray-50 overflow-hidden">
    <div class="swiper mainHeroSwiper h-[70vh] md:h-[85vh]">
        <div class="swiper-wrapper">
            <div class="swiper-slide relative flex items-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?q=80&w=1920&auto=format&fit=crop')">
                <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]"></div>
                <div class="max-w-screen-xl mx-auto px-6 w-full relative z-10 text-right text-white">
                    <span class="hero-desc opacity-0 inline-block bg-orange-500 text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">وصل حديثاً</span>
                    <h1 class="hero-title opacity-0 text-5xl md:text-7xl font-black mb-6 leading-tight">عالم الأناقة للأطفال</h1>
                    <p class="hero-desc opacity-0 text-lg md:text-xl text-gray-100 max-w-xl ml-auto mb-8 leading-relaxed">اكتشفوا تشكيلة ربيع وصيف 2026 الحصرية، المنسوجة بكل حب لتمنح طفلك الراحة التامة والمظهر الفخم.</p>
                    <div class="hero-btn opacity-0"><a href="#shop" class="inline-block bg-white text-gray-900 font-bold px-8 py-4 rounded-xl shadow-xl hover:bg-orange-500 hover:text-white transition-all duration-300">تسوق التشكيلة الآن</a></div>
                </div>
            </div>
            <div class="swiper-slide relative flex items-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1518833278463-d3055863572f?q=80&w=1920&auto=format&fit=crop')">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="max-w-screen-xl mx-auto px-6 w-full relative z-10 text-right text-white">
                    <span class="hero-desc opacity-0 inline-block bg-white text-orange-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest mb-4">عروض حصرية</span>
                    <h1 class="hero-title opacity-0 text-5xl md:text-7xl font-black mb-6 leading-tight">إطلالة العيد الفاخرة</h1>
                    <p class="hero-desc opacity-0 text-lg md:text-xl text-gray-200 max-w-xl ml-auto mb-8 leading-relaxed">فساتين بناتي وأطقم أولادي بتصاميم تركية راقية وألوان تبهج القلب وتليق بمناسباتكم السعيدة.</p>
                    <div class="hero-btn opacity-0"><a href="#shop" class="inline-block bg-orange-500 text-white font-bold px-8 py-4 rounded-xl shadow-xl hover:bg-white hover:text-gray-900 transition-all duration-300">شاهد العروض</a></div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination !bottom-8"></div>
        <div class="swiper-button-next !text-white/70 hover:!text-white after:!text-2xl hidden md:flex"></div>
        <div class="swiper-button-prev !text-white/70 hover:!text-white after:!text-2xl hidden md:flex"></div>
    </div>
</section>

{{-- ------------------------------------------------------------------ --}}
{{-- 📸 2. INSTAGRAM STORIES SECTION --}}
{{-- ------------------------------------------------------------------ --}}
@php
    $stories = [
        ['name' => 'جديدنا 🔥', 'image' => 'https://images.unsplash.com/photo-1503944583220-79d8926ad5e2?auto=format&fit=crop&w=150&q=80', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
        ['name' => 'عروض الموسم', 'image' => 'https://images.unsplash.com/photo-1519457431-44ccd64a579b?auto=format&fit=crop&w=150&q=80', 'video' => 'https://www.w3schools.com/html/movie.mp4'],
        ['name' => 'ملابس أولاد', 'image' => 'https://images.unsplash.com/photo-1471286174243-e7a4d9afb34a?auto=format&fit=crop&w=150&q=80', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
        ['name' => 'ملابس بنات', 'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?auto=format&fit=crop&w=150&q=80', 'video' => 'https://www.w3schools.com/html/movie.mp4'],
        ['name' => 'تخفيضات 50%', 'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=150&q=80', 'video' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
        ['name' => 'إطلالة اليوم', 'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&w=150&q=80', 'video' => 'https://www.w3schools.com/html/movie.mp4']
    ];
@endphp

<section class="py-8 bg-white border-b border-gray-100">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="swiper storiesSwiper">
            <div class="swiper-wrapper">
                @foreach($stories as $story)
                    <div class="swiper-slide !w-auto">
                        <div class="flex flex-col items-center gap-2.5 cursor-pointer group" onclick="openVideoModal('{{ $story['video'] }}')">
                            <div class="w-20 h-20 rounded-full p-[3px] bg-gradient-to-tr from-orange-500 via-pink-500 to-yellow-400 transition-transform duration-300 group-hover:scale-105">
                                <div class="w-full h-full rounded-full border-2 border-white overflow-hidden">
                                    <img src="{{ $story['image'] }}" class="w-full h-full object-cover grayscale-[10%] group-hover:grayscale-0" alt="{{ $story['name'] }}">
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 group-hover:text-orange-500 transition-colors">{{ $story['name'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ------------------------------------------------------------------ --}}
{{-- 🏷️ 3. PREMIUM CATEGORIES GRID --}}
{{-- ------------------------------------------------------------------ --}}
<section class="py-20 bg-gray-50/50">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="category-card group cursor-pointer" style="background-image: url('https://images.unsplash.com/photo-1622290291468-a28f7a7dc6a8?q=80&w=1000&auto=format&fit=crop')">
                <div class="absolute inset-0 p-10 flex flex-col justify-end text-right text-white z-10">
                    <span class="text-orange-400 text-sm font-bold uppercase tracking-wider mb-2">الأناقة والسرعة</span>
                    <h2 class="text-3xl font-black mb-4">تشكيلة الأولاد الفاخرة</h2>
                    <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-orange-500 group-hover:border-transparent transition-all duration-300">
                        <i class="fas fa-arrow-left text-sm transition-transform group-hover:-translate-x-1"></i>
                    </div>
                </div>
            </div>
            <div class="category-card group cursor-pointer" style="background-image: url('https://images.unsplash.com/photo-1518833278463-d3055863572f?q=80&w=1000&auto=format&fit=crop')">
                <div class="absolute inset-0 p-10 flex flex-col justify-end text-right text-white z-10">
                    <span class="text-orange-400 text-sm font-bold uppercase tracking-wider mb-2">عالم من الألوان</span>
                    <h2 class="text-3xl font-black mb-4">إبداعات البنات الراقية</h2>
                    <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-orange-500 group-hover:border-transparent transition-all duration-300">
                        <i class="fas fa-arrow-left text-sm transition-transform group-hover:-translate-x-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ------------------------------------------------------------------ --}}
{{-- 🛍️ 4. DYNAMIC PRODUCTS SECTION (BEST SELLERS) --}}
{{-- ------------------------------------------------------------------ --}}
<section id="shop" class="py-20 bg-white">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 border-b border-gray-100 pb-6">
            <div class="text-right">
                <h2 class="text-4xl font-black text-gray-900">القطع الأكثر <span class="text-orange-500">مبيعاً</span></h2>
                <p class="text-gray-500 mt-2">مجموعة مختارة بعناية فائقة نالت ثقة وإعجاب عملائنا هذا الأسبوع.</p>
            </div>
            <div class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl px-4 py-2.5 w-full md:w-80">
                <i class="fas fa-search text-gray-400 ml-3"></i>
                <input type="text" class="bg-transparent text-sm w-full focus:outline-none text-right" placeholder="بحث عن منتج معين...">
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="product-card-ty">
                    <a href="{{ route('product.show', $product->id) }}">
                        <div class="ty-image-wrapper relative pt-[125%] overflow-hidden">
                            @if($product->original_price > $product->price)
                                <span class="absolute top-4 right-4 bg-red-500 text-white text-[10px] font-black px-2.5 py-1 rounded-full z-10 shadow-sm">
                                    خصم {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
                                </span>
                            @endif
                            <img loading="lazy" 
                                 src="{{ $product->images->first() ? $product->images->first()->image : 'https://via.placeholder.com/400x500' }}" 
                                 class="absolute inset-0 w-full h-full object-cover" 
                                 alt="{{ $product->name }}">
                        </div>
                    </a>
                    <button class="absolute top-4 left-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-gray-700 hover:bg-orange-500 hover:text-white transition-all shadow-sm z-10">
                        <i class="far fa-heart text-xs"></i>
                    </button>
                    <div class="p-5 text-right">
                        <h3 class="text-gray-800 font-bold text-sm mb-2 hover:text-orange-500 transition-colors truncate">{{ $product->name }}</h3>
                        <div class="flex items-center justify-between flex-row-reverse mt-3">
                            <div class="flex items-center gap-2 flex-row-reverse">
                                <span class="text-orange-600 font-black text-base">{{ number_format($product->price, 2) }} ₺</span>
                                @if($product->original_price > $product->price)
                                    <span class="text-gray-400 line-through text-xs">{{ number_format($product->original_price, 2) }} ₺</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="px-5 pb-5">
                        @csrf
                        <button type="submit" class="w-full bg-gray-900 text-white text-xs font-bold py-3 rounded-xl hover:bg-orange-500 transition-all duration-300 shadow-md shadow-gray-100">
                            أضف إلى السلة
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-gray-50 rounded-3xl">
                    <p class="text-gray-400 text-base">لا توجد منتجات معروضة حالياً في هذا القسم.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ------------------------------------------------------------------ --}}
{{-- 👑 5. PREMIUM LUXURY EDITORIAL SECTION (INSTEAD OF CALENDAR) --}}
{{-- ------------------------------------------------------------------ --}}
<section class="py-24 overflow-hidden bg-gradient-to-b from-gray-50 via-white to-gray-50">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="relative group cursor-pointer overflow-hidden rounded-3xl shadow-2xl">
                <img src="https://static.aljamila.com/styles/1100x732_scale/public/2018/12/20/2393901-1727507459.jpg" 
                     alt="Kids Luxury Editorial" 
                     class="w-full h-[550px] object-cover transition-transform duration-700 group-hover:scale-102"
                     onclick="openLightbox(this.src)">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                <div class="absolute bottom-10 right-10 text-right text-white max-w-sm">
                    <span class="bg-orange-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">إصدار خاص</span>
                    <h3 class="text-3xl font-black mt-4 leading-tight">جلسات تصوير حصرية لمجموعتنا التركية الفاخرة</h3>
                </div>
            </div>

            <div class="text-right space-y-8">
                <span class="inline-block py-1 px-4 bg-orange-50 text-orange-600 rounded-full text-xs font-bold font-mono">STYLING EXPERT</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">إطلالة كاملة متناسقة <br><span class="text-orange-500">بضغطة زر واحدة</span></h2>
                <p class="text-gray-500 text-base leading-relaxed">خبراء الموضة لدينا قاموا بتنسيق هذه الأطقم الفاخرة لتوفير عناء البحث، سحر الألوان وتناسق الخامات يمنح طفلك حضوراً ملكياً في كل مناسبة.</p>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md flex-row-reverse">
                        <div class="flex items-center gap-4 flex-row-reverse">
                            <img src="https://i.pinimg.com/236x/8f/2b/4c/8f2b4c2ea900323aec716ee886f7f066.jpg" class="w-20 h-20 rounded-xl object-cover cursor-pointer shadow-sm" onclick="openLightbox(this.src)">
                            <div class="text-right">
                                <h4 class="text-base font-bold text-gray-800">طقم السهرة المخملي الكامل</h4>
                                <p class="text-orange-600 font-black text-sm mt-1">250 ₺</p>
                            </div>
                        </div>
                        <button class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white rounded-xl hover:bg-orange-500 transition-colors shadow-sm">+</button>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md flex-row-reverse">
                        <div class="flex items-center gap-4 flex-row-reverse">
                            <img src="https://image.made-in-china.com/202f0j00ZbRuNDByfPoI/New-International-School-Uniforms-Summer-Boys-Girls-School-Uniforms-Design-with-Pictures-Clothes-Children.webp" class="w-20 h-20 rounded-xl object-cover cursor-pointer shadow-sm" onclick="openLightbox(this.src)">
                            <div class="text-right">
                                <h4 class="text-base font-bold text-gray-800">حذاء كلاسيكي جلد فاخر</h4>
                                <p class="text-orange-600 font-black text-sm mt-1">170 ₺</p>
                            </div>
                        </div>
                        <button class="w-10 h-10 flex items-center justify-center bg-gray-900 text-white rounded-xl hover:bg-orange-500 transition-colors shadow-sm">+</button>
                    </div>

                    <button class="w-full py-4 bg-gradient-to-l from-orange-500 to-orange-600 text-white rounded-xl font-bold text-base shadow-lg shadow-orange-100 hover:shadow-none transition-all duration-300">
                        شراء الإطلالة المنسقة كاملة — 420 ₺
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="lightbox" class="fixed inset-0 bg-black/95 hidden items-center justify-center z-[999]" onclick="closeLightbox()">
        <img id="lightbox-img" src="" class="max-h-[85vh] max-w-[85vw] rounded-xl shadow-2xl object-contain">
    </div>
</section>

{{-- ------------------------------------------------------------------ --}}
{{-- ⭐️ 6. BRAND REVIEWS SECTION --}}
{{-- ------------------------------------------------------------------ --}}
<section class="py-20 bg-gray-50/50 border-t border-b border-gray-100">
    <div class="max-w-screen-xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-black text-center mb-16 text-gray-900">آراء ومحبة <span class="text-orange-500">عملائنا</span></h2>
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white border border-gray-100 rounded-2xl p-8 text-right shadow-sm space-y-4">
                <div class="flex items-center gap-4 flex-row-reverse">
                    <img src="https://ui-avatars.com/api/?name=سارة+أحمد&background=FFEDD5&color=F97316&size=128" alt="سارة أحمد" class="w-14 h-14 rounded-full object-cover shadow-inner">
                    <div>
                        <h5 class="font-bold text-gray-900 text-base">سارة أحمد</h5>
                        <div class="stars text-orange-400 text-xs mt-1">★★★★★</div>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">"خامات الملابس مذهلة وتتحمل الغسيل المتكرر دون تغيير في الألوان. التوصيل في إسطنبول كان سريعاً جداً، تجربة ممتازة سأكررها دائماً."</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-8 text-right shadow-sm space-y-4">
                <div class="flex items-center gap-4 flex-row-reverse">
                    <img src="https://ui-avatars.com/api/?name=محمد+علي&background=FFEDD5&color=F97316&size=128" alt="محمد علي" class="w-14 h-14 rounded-full object-cover shadow-inner">
                    <div>
                        <h5 class="font-bold text-gray-900 text-base">محمد علي</h5>
                        <div class="stars text-orange-400 text-xs mt-1">★★★★★</div>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">"أفضل متجر لملابس الأطفال من ناحية مطابقة القياسات وجودة التقفيل التركي الفخم. تعامل خدمة العملاء راقٍ وسريع جداً."</p>
            </div>
        </div>
    </div>
</section>

{{-- ------------------------------------------------------------------ --}}
{{-- 📦 7. FOOTER & SUBSCRIPTION --}}
{{-- ------------------------------------------------------------------ --}}
<footer class="bg-gray-950 text-gray-400 pt-20 pb-10 border-t border-gray-900">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 text-right">
            <div>
                <h4 class="text-xl font-black text-white mb-5 tracking-wide">MELEKLER GROUP</h4>
                <p class="text-sm text-gray-400 leading-relaxed">علامتكم التجارية الموثوقة لأزياء الأطفال والنساء المصنوعة بأعلى معايير الجودة التركية الفاخرة.</p>
                <div class="flex gap-4 mt-6 text-lg justify-end">
                    <a href="https://www.instagram.com/meleklerkids/" target="_blank" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/MELEKLERKIDSTR" target="_blank" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"><i class="fab fa-facebook"></i></a>
                    <a href="https://api.whatsapp.com/message/CL67ADRC7PMFO1" target="_blank" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <h5 class="font-bold text-white mb-5 text-sm uppercase tracking-wider">أقسام التسوق</h5>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white transition-colors">وصل حديثاً للمتجر</a></li>
                    <li><a href="{{ route('category.boys') }}" class="hover:text-white transition-colors">أزياء الأطفال (أولاد)</a></li>
                    <li><a href="{{ route('category.mothers') }}" class="hover:text-white transition-colors">أزياء النساء والأمهات</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold text-white mb-5 text-sm uppercase tracking-wider">الدعم والمساعدة</h5>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">اتصل بنا مباشرة</a></li>
                    <li><a href="/refund-policy" class="hover:text-white transition-colors">سياسة الإرجاع والتبديل</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold text-white mb-5 text-sm uppercase tracking-wider">النشرة البريدية</h5>
                <p class="text-xs mb-4 text-gray-500">اشترك لتصلك أحدث التخفيضات وكوبونات الخصم الحصرية.</p>
                <div class="flex flex-row-reverse bg-gray-900 border border-gray-800 rounded-xl overflow-hidden p-1">
                    <input type="email" placeholder="بريدك الإلكتروني" class="w-full px-3 bg-transparent text-sm text-white focus:outline-none text-right">
                    <button class="px-5 py-2.5 bg-orange-500 text-white font-bold text-xs rounded-lg hover:bg-orange-600 transition-colors">اشتراك</button>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
            <p class="text-gray-600">© 2026 Melekler Fashion — جميع الحقوق محفوظة لـ مجمّع ملائكة للأزياء</p>
            <p class="text-gray-500 font-mono tracking-widest">DEVELOPED & OPTIMIZED BY ALAA ALAKRABANI</p>
        </div>
    </div>
</footer>

{{-- ------------------------------------------------------------------ --}}
{{-- ♾️ 8. LUXURY INFINITE MARQUEE RUNNER --}}
{{-- ------------------------------------------------------------------ --}}
<div class="marquee-footer">
    <div class="marquee-inner-wrap">
        <div class="marquee-content">
            <span>شحن مجاني لكافة الولايات التركية للطلبات فوق 1000 ₺</span><i class="fas fa-star text-orange-500 text-[8px]"></i>
            <span>خصم حصرى 10% عند أول عملية شراء من المتجر</span><i class="fas fa-star text-orange-500 text-[8px]"></i>
            <span>جودة تركية فاخرة وخامات قطنية 100% خاضعة لرقابة الجودة</span><i class="fas fa-star text-orange-500 text-[8px]"></i>
        </div>
        <div class="marquee-content">
            <span>شحن مجاني لكافة الولايات التركية للطلبات فوق 1000 ₺</span><i class="fas fa-star text-orange-500 text-[8px]"></i>
            <span>خصم حصرى 10% عند أول عملية شراء من المتجر</span><i class="fas fa-star text-orange-500 text-[8px]"></i>
            <span>جودة تركية فاخرة وخامات قطنية 100% خاضعة لرقابة الجودة</span><i class="fas fa-star text-orange-500 text-[8px]"></i>
        </div>
    </div>
</div>

{{-- ------------------------------------------------------------------ --}}
{{-- 💬 9. EMBEDDED CONTACT INTERACTION UTILITIES --}}
{{-- ------------------------------------------------------------------ --}}
<div class="floating-contact-buttons">
    <a href="https://api.whatsapp.com/send?phone=YOUR_NUMBER" target="_blank" class="contact-button whatsapp-button" title="تواصل معنا عبر واتساب">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
</div>

{{-- 📱 MODAL: INSTAGRAM STYLE STORIES OVERLAY --}}
<div id="videoModal" class="fixed inset-0 bg-black/95 z-[9999] hidden flex items-center justify-center p-4" onclick="closeVideoModal()">
    <button onclick="closeVideoModal()" class="absolute top-6 right-6 text-white text-3xl hover:text-orange-500 transition-colors z-[10000]">&times;</button>
    <div class="instagram-modal-content shadow-2xl" onclick="event.stopPropagation()">
        <video id="storyVideo" class="w-full h-full object-cover" controls autoplay playsinline></video>
    </div>
</div>

{{-- ------------------------------------------------------------------ --}}
{{-- ⚙️ 10. REAL-TIME ENGINE JAVASCRIPT --}}
{{-- ------------------------------------------------------------------ --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// A. Tawk.to Embedded Widget Integration
var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
(function() {
    var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/699b1c15c165071c358882eb/1ji2ubd4s';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();

// B. Video Modal Core Mechanics (Instagram Style)
function openVideoModal(src) {
    const video = document.getElementById('storyVideo');
    const modal = document.getElementById('videoModal');
    if (video && modal) {
        video.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        video.play();
        document.body.style.overflow = 'hidden';
    }
}

function closeVideoModal() {
    const video = document.getElementById('storyVideo');
    const modal = document.getElementById('videoModal');
    if (video && modal) {
        video.pause();
        video.src = "";
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
}

// C. Premium Lightbox Feature For Product Inspection
function openLightbox(src) {
    const box = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    if(box && img) {
        img.src = src;
        box.classList.remove('hidden');
        box.classList.add('flex');
    }
}

function closeLightbox() {
    const box = document.getElementById('lightbox');
    if(box) {
        box.classList.add('hidden');
        box.classList.remove('flex');
    }
}

// D. Layout Dynamic Architecture Setup
document.addEventListener('DOMContentLoaded', function() {
    // Premium Main Hero Slider Integration
    if (document.querySelector('.mainHeroSwiper')) {
        new Swiper('.mainHeroSwiper', {
            loop: true,
            speed: 1200,
            effect: "fade",
            fadeEffect: { crossFade: true },
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            grabCursor: false
        });
    }

    // High Velocity Stories Swiper Horizontal Scroller
    if (document.querySelector('.storiesSwiper')) {
        new Swiper('.storiesSwiper', {
            slidesPerView: 'auto',
            spaceBetween: 16,
            freeMode: true,
            grabCursor: true
        });
    }
});
</script>

@endsection
