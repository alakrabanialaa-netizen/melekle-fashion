<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- أيقونة المتصفح المحدثة (Favicon) -->
    <link class="rounded-full" rel="icon" type="image/png" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png">
    <!-- أيقونة المتصفح (تم إضافة ?v=3 لكسر الكاش وقراءة الصورة الجديدة فوراً) -->
<link class="rounded-full" rel="icon" type="image/png" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png?v=3">

<!-- أيقونة الآيفون (iOS) -->
<link class="apple-touch-icon" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png?v=3">
    <title>MK| @yield('title', 'Premium Fashion')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- أيقونات المتصفح العامة -->
<link rel="icon" type="image/png" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png?v=99">

<!-- إعدادات وتوافقية أجهزة الآيفون (iOS) الكاملة -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Melekler">

<!-- أيقونة التطبيق عند التثبيت على شاشة الآيفون الرئيسية -->
<link rel="apple-touch-icon" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png?v=99">
<link rel="apple-touch-icon" sizes="180x180" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png?v=99">

<!-- كود شاشة الإقلاع (Splash Screen) المخصص للآيفون لتظهر الصورة قبل الدخول للموقع -->
<link rel="apple-touch-startup-image" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png?v=99">

    <style>
        /* --- Global Styles --- */
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fffaf0;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .font-black { font-weight: 900; }

        /* --- Floating Header Styles --- */
        #main-header {
            position: fixed;
            top: 1rem;       
            left: 1.5rem;    
            right: 1.5rem;   
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Cairo', sans-serif;
        }

        .header-transparent {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding-top: 1rem;
            padding-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03);
        }

        .header-scrolled {
            top: 0.5rem !important;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(244, 63, 94, 0.1);
            box-shadow: 0 10px 30px rgba(244, 63, 94, 0.05);
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
        }

        .nav-link { transition: all 0.3s ease; font-weight: 700; color: #1f2937; position: relative; }
        .nav-link:hover { color: #f43f5e !important; }
        
        .nav-icon { transition: all 0.3s ease; cursor: pointer; color: #1f2937; }
        .nav-icon:hover { color: #f43f5e !important; transform: translateY(-2px); }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            color: #1f2937;
        }
        .lang-btn:hover { color: #f43f5e !important; border-color: #f43f5e; transform: translateY(-2px); }

        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        .group:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }

        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        #mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>
<body>

<header id="main-header" class="z-50 header-transparent">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-3 items-center">
        
        {{-- 1. Left Side: Language & User Dashboard --}}
        <div class="flex items-center gap-4 justify-start">
            <div class="relative group">
                <button class="lang-btn">
                    <i class="fas fa-globe-americas text-sm"></i>
                    <span class="text-xs font-black uppercase">{{ app()->getLocale() }}</span>
                </button>
                <div class="dropdown-menu absolute left-0 mt-2 w-36 bg-white rounded-2xl shadow-2xl py-2 border border-gray-100 overflow-hidden z-[100]">
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇸🇦</span> العربية
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇺🇸</span> English
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:bg-pink-50 text-gray-700 transition font-bold text-sm">
                        <span class="text-base">🇹🇷</span> Türkçe
                    </a>
                </div>
            </div>

            <a href="/admin/dashboard" class="nav-icon text-xl hidden md:block" title="لوحة التحكم">
                <i class="fas fa-user-shield"></i>
            </a>
        </div>
        
        {{-- 2. Center Side: Logo Image (تم تحديثه باللوغو الجديد) --}}
        <div class="logo-container text-center flex justify-center items-center">
            <a href="/" class="inline-block">
                <img src="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png" alt="Melekler Logo" class="logo-img h-12 md:h-16 w-auto object-contain transition-all duration-300 rounded-full">
            </a>
        </div>

        {{-- 3. Right Side: Navigation & Cart --}}
        <div class="flex items-center gap-6 justify-end">
            <nav class="hidden lg:flex items-center gap-8 text-sm">
                <a href="/" class="nav-link">الرئيسية</a>
                
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1.5">
                        <span>الأقسام</span>
                        <i class="fas fa-chevron-down text-[9px] transition-transform group-hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-menu absolute right-0 mt-4 w-56 bg-white rounded-3xl shadow-2xl py-4 border border-pink-50 overflow-hidden z-[120]">
                        <a href="/category/boys" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👦 ملابس أولاد</a>
                        <a href="/category/girls" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👧 ملابس بنات</a>
                        <a href="/category/babies" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👶 ملابس رضع</a>
                        <a href="/category/mothers" class="block px-6 py-3 text-gray-600 hover:bg-pink-50 hover:text-pink-500 transition font-bold">👩 ملابس نساء</a>
                        <a href="{{ route('category.offers') }}" class="block px-6 py-3 text-red-500 bg-red-50 hover:bg-red-100 transition font-black border-t border-dashed border-red-100">🔥 عروض تركية</a>
                    </div>
                </div>
            </nav>

            <button id="cart-icon" class="relative nav-icon text-xl">
                <i class="fas fa-shopping-bag"></i>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-pink-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-white font-bold shadow-sm">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </button>

            <button id="mobile-menu-button" class="lg:hidden nav-icon text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- رابط ملف الـ Manifest لتثبيت التطبيق على الموبايل -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- أيقونات تدعم أجهزة الآيفون (iOS) باستخدام رابط الصورة المحدثة والمباشرة -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Melekler Fashion">
    <link rel="apple-touch-icon" href="https://mykfqkcohkiptzqkzgyx.supabase.co/storage/v1/object/public/MELEKLER/icon-192.png">
    
</header>

{{-- 📱 Mobile Menu --}}
<div id="mobile-menu" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl z-[150] p-8">
    <button id="close-mobile-menu" class="absolute top-6 left-6 text-2xl text-gray-600">&times;</button>
    <nav class="flex flex-col gap-6 mt-12 font-bold text-gray-800">
        <a href="/" class="hover:text-pink-500">الرئيسية</a>
        
        <h3 class="text-gray-400 text-sm mt-4">الأقسام</h3>
        <a href="/category/boys" class="hover:text-pink-500 pr-4">ملابس أولاد</a>
        <a href="/category/girls" class="hover:text-pink-500 pr-4">ملابس بنات</a>
        <a href="/category/babies" class="hover:text-pink-500 pr-4">ملابس رضع</a>
        <a href="/category/mothers" class="hover:text-pink-500 pr-4">ملابس نساء</a>
        <a href="{{ route('category.offers') }}" class="text-red-500 font-black pr-4 hover:text-red-600">🔥 التشكيلة الجديدة %</a>
        
        <hr class="border-gray-100">
        <a href="/shop" class="hover:text-pink-500">كل المنتجات</a>
        <a href="/blog" class="hover:text-pink-500">المدونة</a>
        <hr class="border-gray-100">
        <a href="/admin/dashboard" class="hover:text-pink-500 flex items-center gap-2">
            <i class="fas fa-user-shield text-sm"></i> لوحة التحكم
        </a>
    </nav>
</div>

<main class="pt-28 md:pt-36 min-h-screen">
    @yield('content')
</main>

{{-- 🛒 Mini Cart Container --}}
<div id="mini-cart" class="fixed top-0 right-[-420px] w-[400px] h-screen bg-white shadow-2xl transition-all duration-300 z-[150] flex flex-col">
    <div class="p-6 border-b flex justify-between items-center">
        <h2 class="text-xl font-bold">🛒 سلة المشتريات</h2>
        <button onclick="closeCart()" class="text-2xl hover:text-red-500 transition">&times;</button>
    </div>

    <div id="mini-cart-items-wrapper" class="flex-1 p-6 overflow-y-auto">
        @php 
            $cart = session('cart', []); 
            
            // جلب أسعار الصرف الممررة من AppServiceProvider (مع قيم احتياطية)
            $rateTry = $rates['USD_TRY'] ?? 33.0;
            $rateSyp = $rates['USD_SYP'] ?? 14000.0;
        @endphp

        @if(count($cart) > 0)
            @foreach($cart as $id => $item)
                @php
                    $imageUrl = 'https://via.placeholder.com/150';
                    if (isset($item['image']) && $item['image']) {
                        if (str_starts_with($item['image'], 'http://') || str_starts_with($item['image'], 'https://')) {
                            $imageUrl = $item['image'];
                        } else {
                            $imageUrl = asset('storage/' . $item['image']);
                        }
                    }

                    // الحسابات المالية بالعملات الثلاث (بافتراض السعر الأساسي TL)
                    $priceTry = $item['price'];
                    $priceUsd = $priceTry / ($rateTry > 0 ? $rateTry : 1);
                    $priceSyp = $priceUsd * $rateSyp;
                @endphp

                <div class="flex gap-4 border-b py-4 items-center">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $item['name'] }}" 
                         class="w-16 h-16 object-cover rounded shadow-sm">
                    
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">{{ $item['name'] }}</h4>
                        @if(isset($item['size']))
                            <p class="text-xs text-gray-400">المقاس: {{ $item['size'] }}</p>
                        @endif

                        <div class="mt-2 space-y-0.5 bg-gray-50 p-2 rounded-lg text-xs">
                            <div class="flex justify-between font-bold text-pink-600">
                                <span>تركية (TRY):</span>
                                <span>{{ number_format($priceTry, 2) }} ₺</span>
                            </div>
                            <div class="flex justify-between text-green-700 font-semibold">
                                <span>دولار (USD):</span>
                                <span>${{ number_format($priceUsd, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-blue-700 font-semibold">
                                <span>سورية (SYP):</span>
                                <span>{{ number_format($priceSyp, 0) }} ل.س</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                            <span>الكمية: {{ $item['quantity'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="p-4 border-t mt-auto">
                <a href="{{ route('mycart') }}" class="block text-center bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl transition shadow-md">عرض سلة المشتريات الكاملة</a>
            </div>
        @else
            <div class="text-center mt-20">
                <div class="text-6xl mb-4 text-gray-200">🛒</div>
                <p class="text-gray-500">السلة فارغة حالياً</p>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. التعامل مع حركة الهيدر عند النزول
    const header = document.getElementById('main-header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 30) {
            header.classList.remove('header-transparent');
            header.classList.add('header-scrolled');
        } else {
            header.classList.add('header-transparent');
            header.classList.remove('header-scrolled');
        }
    });

    // 2. التحكم في فتح وإغلاق السلة المنبثقة
    const miniCart = document.getElementById('mini-cart');
    const cartIcon = document.getElementById('cart-icon');
    
    window.openCart = () => miniCart.style.right = "0";
    window.closeCart = () => miniCart.style.right = "-420px";
    
    if (cartIcon) {
        cartIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            openCart();
        });
    }
    document.addEventListener('click', function(e) {
        if (!miniCart.contains(e.target) && !cartIcon.contains(e.target) && !e.target.closest('.add-to-cart-btn')) {
            closeCart();
        }
    });

    // 3. قائمة الموبايل
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu');
    mobileMenuButton.addEventListener('click', () => mobileMenu.classList.add('open'));
    closeMobileMenuButton.addEventListener('click', () => mobileMenu.classList.remove('open'));

    // 4. محرك الأجاكس المطور
    $(document).on('submit', 'form[action*="cart/data/store"]', function(e) {
        e.preventDefault(); 
        
        const form = $(this);
        const url = form.attr('action');
        const formData = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.status === 'success') {
                    $('#cart-count').text(response.cart_count);
                    updateMiniCartUI(response.cart);
                    openCart();
                }
            },
            error: function(xhr) {
                console.error('حدث خطأ أثناء إضافة المنتج للسلة.');
            }
        });
    });

    // بناء دالة البناء التلقائي لتدعم الروابط الخارجية والمسارات المحلية
    function updateMiniCartUI(cart) {
        const wrapper = $('#mini-cart-items-wrapper');
        wrapper.empty(); 

        const cartKeys = Object.keys(cart);

        if(cartKeys.length > 0) {
            let htmlContent = '';
            cartKeys.forEach(id => {
                const item = cart[id];
                
                let itemImage = 'https://via.placeholder.com/150';
                if (item.image) {
                    if (item.image.startsWith('http://') || item.image.startsWith('https://')) {
                        itemImage = item.image; 
                    } else {
                        itemImage = `/storage/${item.image}`; 
                    }
                }

                const itemSize = item.size ? `<p class="text-xs text-gray-400">المقاس: ${item.size}</p>` : '';
                const itemPrice = parseFloat(item.price).toFixed(2);

                htmlContent += `
                    <div class="flex gap-4 border-b py-4 items-center">
                        <img src="${itemImage}" alt="${item.name}" class="w-16 h-16 object-cover rounded shadow-sm">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">${item.name}</h4>
                            ${itemSize}
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-sm text-gray-600">الكمية: ${item.quantity}</p>
                                <p class="font-bold text-pink-600">${itemPrice} ₺</p>
                            </div>
                        </div>
                    </div>
                `;
            });

            htmlContent += `
                <div class="p-4 border-t mt-4">
                    <a href="/mycart" class="block text-center bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-xl transition shadow-md">عرض سلة المشتريات الكاملة</a>
                </div>
            `;
            wrapper.html(htmlContent);
        } else {
            wrapper.html(`
                <div class="text-center mt-20">
                    <div class="text-6xl mb-4 text-gray-200">🛒</div>
                    <p class="text-gray-500">السلة فارغة حالياً</p>
                </div>
            `);
        }
    }

    // 5. تسجيل الـ Service Worker بشكل صحيح داخل نطاق الـ DOMContentLoaded
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js?v=99')
            .then(function(registration) {
                console.log('Service Worker registered successfully with scope: ', registration.scope);
            })
            .catch(function(err) {
                console.log('Service Worker registration failed: ', err);
            });
    }
}); // القوس هنا يغلق الـ DOMContentLoaded بشكل سليم قبل إغلاق السكريبت
</script>
</body>
</html>
