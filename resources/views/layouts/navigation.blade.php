<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Melekler Fashion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Cairo --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Cairo', sans-serif; }
        /* Floating Buttons */
        .floating-btn {
            position: fixed;
            bottom: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            color: white;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: background 0.3s, transform 0.2s;
            z-index: 50;
        }
        .floating-btn:hover { transform: scale(1.1); }
        .cart-btn { background-color: #6366f1; right: 20px; }
        .chat-btn { background-color: #ec4899; left: 20px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

{{-- Top Bar --}}
<div class="bg-indigo-600 text-white text-center py-2 font-bold">
    ✨ توصيل مجاني للطلبات فوق 200 ₺ ✨
</div>

{{-- Header --}}
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-black text-indigo-600">
            Melekler Fashion
        </h1>

        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded-full font-bold hover:bg-indigo-700 transition">
                تسجيل دخول 🔐
            </a>
        </div>
    </div>
</header>

{{-- Hero --}}
<section class="bg-gradient-to-br from-indigo-50 to-white py-20 text-center">
    <h2 class="text-4xl font-black mb-4">مجموعة الربيع الجديدة 🌸</h2>
    <p class="text-gray-600 mb-8">أزياء عصرية ومريحة لأطفالك بأفضل الأسعار</p>
    <a href="#products"
       class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-700 transition">
        تسوق الآن 🛍️
    </a>
</section>

{{-- Categories --}}
<section class="py-16">
    <h3 class="text-2xl font-black text-center mb-10">تسوق حسب الفئة</h3>
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 px-6">
        @foreach ([
            '👦 ملابس أولاد',
            '👧 ملابس بنات',
            '👶 ملابس رضع',
            '🎒 إكسسوارات'
        ] as $cat)
            <div class="bg-white rounded-2xl p-6 text-center shadow hover:shadow-lg transition cursor-pointer">
                <span class="text-4xl block mb-3">{{ explode(' ', $cat)[0] }}</span>
                <p class="font-bold">{{ explode(' ', $cat, 2)[1] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- Products --}}
<section id="products" class="bg-white py-16">
    <h3 class="text-2xl font-black text-center mb-10">منتجاتنا المميزة</h3>
    <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 px-6">
        @forelse($products as $product)
            <div class="border rounded-2xl p-5 text-center hover:shadow-lg transition">

                <img src="{{ $product->images->count() ? Storage::url($product->images->first()->image) : 'https://via.placeholder.com/400x300' }}"
                     alt="{{ $product->name }}"
                     class="w-full h-40 object-cover rounded-xl mb-4">

                <h4 class="font-bold mb-2">{{ $product->name }}</h4>
                <p class="text-indigo-600 font-black mb-4">{{ $product->price }} ₺</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button class="w-full bg-indigo-600 text-white py-2 rounded-xl font-bold hover:bg-indigo-700 transition">
                        أضف للسلة 🛒
                    </button>
                </form>
            </div>
        @empty
            <p class="col-span-4 text-center text-gray-500 font-bold">
                لا توجد منتجات حالياً
            </p>
        @endforelse
    </div>
</section>

{{-- Floating Buttons --}}
<div class="floating-btn cart-btn" onclick="window.location='{{ route('cart.index') }}'" title="سلة التسوق">🛒</div>
<div class="floating-btn chat-btn" onclick="window.location='https://wa.me/0000000000'" title="الدردشة معنا">💬</div>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-300 py-10 text-center">
    <h4 class="text-xl font-black text-white mb-3">Melekler Fashion</h4>
    <p class="mb-4">متجرك الموثوق لملابس الأطفال</p>
    <p class="text-sm text-gray-500">© {{ date('Y') }} جميع الحقوق محفوظة</p>
</footer>

</body>
</html>
