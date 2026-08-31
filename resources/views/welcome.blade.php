@extends('layouts.app')

@section('content')

{{-- ==================== HERO SECTION (SWIPER) ==================== --}}
<section class="relative w-full h-[85vh] bg-[#121214] overflow-hidden select-none">
    <div class="swiper hero-swiper w-full h-full">
        <div class="swiper-wrapper">
            
            {{-- Slide 1 --}}
            <div class="swiper-slide relative w-full h-full">
                <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="Hero Slide 1">
                <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-[#121214]/40 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 max-w-4xl mx-auto space-y-4">
                    <span class="px-4 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-bold tracking-widest uppercase backdrop-blur-md">تشكيلة الموسم الجديدة 2026</span>
                    <h1 class="text-4xl md:text-6xl font-black text-white leading-tight">أناقة استثنائية <br><span class="bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">لتفاصيل طفلك المميزة</span></h1>
                    <p class="text-gray-300 text-sm md:text-base max-w-xl font-light">اكتشف أحدث التصاميم العصرية التي تجمع بين الراحة والجمال لأطفالك في كل المناسبات.</p>
                    <div class="pt-4">
                        <a href="#products-section" class="px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white font-bold rounded-2xl shadow-xl transition-all duration-300 inline-block">تسوق المجموعة الآن</a>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="swiper-slide relative w-full h-full">
                <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="Hero Slide 2">
                <div class="absolute inset-0 bg-gradient-to-t from-[#121214] via-[#121214]/40 to-transparent"></div>
                <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 max-w-4xl mx-auto space-y-4">
                    <span class="px-4 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-bold tracking-widest uppercase backdrop-blur-md">عروض خاصة</span>
                    <h1 class="text-4xl md:text-6xl font-black text-white leading-tight">إطلالات كاملة <br><span class="bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">بلمسة واحدة</span></h1>
                    <div class="pt-4">
                        <a href="#products-section" class="px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white font-bold rounded-2xl shadow-xl transition-all duration-300 inline-block">استكشف العروض</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

{{-- ==================== PRODUCTS SECTION ==================== --}}
<section id="products-section" class="py-16 bg-[#121214] min-h-screen">
    <div class="max-w-screen-xl mx-auto px-6">
        
        {{-- Section Title --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-2">المنتجات المختارة</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-amber-500 to-orange-500 mx-auto rounded-full"></div>
        </div>

        {{-- Dynamic Categories & Products Loop --}}
        @foreach($categories as $category)
            @if($category->products && $category->products->count() > 0)
                <div class="mb-12">
                    <h3 class="text-xl font-bold text-amber-400 mb-6 border-r-4 border-amber-500 pr-3">{{ $category->name }}</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($category->products as $product)
                            <div class="bg-[#18181b] rounded-3xl border border-gray-800/80 overflow-hidden shadow-xl hover:border-amber-500/40 transition-all duration-300 group flex flex-col justify-between">
                                
                                {{-- Image Container --}}
                                <div class="relative h-72 overflow-hidden bg-gray-900">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    
                                    {{-- Fitting Room Trigger Button --}}
                                    <button onclick="openFittingRoom('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ asset('storage/' . $product->image) }}')" 
                                            class="absolute top-3 left-3 bg-black/60 hover:bg-amber-600 text-white p-2.5 rounded-full backdrop-blur-md transition-colors duration-300 shadow-lg"
                                            title="تجربة القطعة في غرفة القياس">
                                        <i class="fas fa-[#hanger] text-xs">👕</i>
                                    </button>
                                </div>

                                {{-- Details --}}
                                <div class="p-5 flex flex-col flex-grow justify-between text-right">
                                    <div>
                                        <h4 class="text-base font-bold text-white mb-1 line-clamp-1">{{ $product->name }}</h4>
                                        <p class="text-xs text-gray-400 mb-4 line-clamp-2">{{ $product->description }}</p>
                                    </div>
                                    
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-800">
                                        <span class="text-lg font-black text-amber-400 dir-ltr">{{ number_format($product->price, 2) }} ₺</span>
                                        <button onclick="addToCart({{ $product->id }})" class="bg-amber-600/20 hover:bg-amber-600 text-amber-400 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300">
                                            إضافة للسلة
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</section>

{{-- ==================== FITTING ROOM MODAL (طراز الصورة المرفقة) ==================== --}}
<div id="fittingRoomModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-[#18181b] text-gray-100 w-full max-w-md rounded-3xl p-6 relative shadow-2xl border border-gray-800 text-left dir-ltr">
        
        {{-- Header --}}
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-extrabold text-white tracking-tight">Fitting room</h3>
                <p class="text-xs text-gray-400 mt-0.5">Tap the hanger on any product to wear it.</p>
            </div>
            <button onclick="closeFittingRoom()" class="text-gray-400 hover:text-white text-lg w-8 h-8 rounded-full bg-gray-800/60 flex items-center justify-center transition">&times;</button>
        </div>

        {{-- Main Mannequin Preview --}}
        <div class="relative w-full h-80 bg-[#27272a] rounded-2xl overflow-hidden flex items-center justify-center border border-gray-700/50 mb-4 group">
            <img id="fittingProductImg" src="" class="h-full w-full object-cover" alt="Virtual Try-On Mannequin">
            
            <button class="absolute bottom-3 right-3 w-8 h-8 rounded-full bg-black/50 text-white flex items-center justify-center backdrop-blur-sm hover:bg-black/80 transition">
                <i class="fas fa-search text-xs"></i>
            </button>

            {{-- Loading Overlay --}}
            <div id="fittingLoader" class="absolute inset-0 bg-black/70 backdrop-blur-sm flex flex-col items-center justify-center p-4 transition-opacity">
                <div class="w-9 h-9 border-3 border-amber-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                <p class="text-xs text-gray-300 font-medium">Generating AI Outfit...</p>
            </div>
        </div>

        {{-- Your Picks Strip --}}
        <div class="mb-4">
            <div class="flex justify-between items-center text-xs mb-2">
                <span class="text-gray-400 font-medium">Your picks</span>
                <span class="text-gray-400" id="picksCount">1 piece</span>
            </div>
            
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none" id="picksContainer">
                <div class="relative flex-shrink-0 w-12 h-12 bg-gray-800 rounded-xl border border-gray-700 overflow-hidden group">
                    <img id="thumbPickedImg" src="" class="w-full h-full object-cover">
                    <button onclick="removePick(this)" class="absolute top-0.5 right-0.5 w-4 h-4 bg-black/70 text-white rounded-full flex items-center justify-center text-[10px] opacity-80 hover:opacity-100">&times;</button>
                </div>
            </div>
            <p class="text-[11px] text-gray-500 mt-1">Add another piece and it goes on top.</p>
        </div>

        {{-- Footer Controls --}}
        <div class="flex items-center justify-between pt-3 border-t border-gray-800 text-xs">
            <button class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 transition">
                <span class="text-[11px] font-medium">🔑 Your API key</span>
            </button>
            <button onclick="resetFitting()" class="flex items-center gap-1.5 text-gray-400 hover:text-white transition text-[11px]">
                <i class="fas fa-redo-alt text-[10px]"></i>
                <span>Start over</span>
            </button>
        </div>
    </div>
</div>

{{-- ==================== PREMIUM BANNER SECTION ==================== --}}
<section class="relative py-20 bg-[#121214] border-t border-gray-900 select-none">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            
            <div class="relative group cursor-pointer overflow-hidden rounded-3xl shadow-2xl border border-gray-800">
                <img src="https://static.aljamila.com/styles/1100x732_scale/public/2018/12/20/2393901-1727507459.jpg" alt="Kids Premium Fashion" class="w-full h-[480px] object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-8 right-8 left-8 text-right text-white space-y-2">
                    <span class="inline-block bg-amber-600 text-white px-3 py-1 rounded-full text-xs font-bold tracking-wider">كشخة العيد ✨</span>
                    <h3 class="text-2xl md:text-3xl font-black leading-tight">أناقة أطفالكِ تبدأ من التفاصيل الصغيرة</h3>
                </div>
            </div>

            <div class="space-y-6 text-right">
                <div>
                    <span class="text-amber-500 font-bold tracking-widest text-xs uppercase block mb-2">MATCHING SET</span>
                    <h2 class="text-3xl md:text-4xl font-black text-white leading-tight">إطلالة كاملة <span class="bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">بضغطة واحدة</span> 🪄</h2>
                </div>
                
                <form action="{{ url('cart-add/premium-set') }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="size" value="Free Size">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-500 hover:to-orange-500 text-white rounded-2xl font-black text-base md:text-lg shadow-xl transition-all duration-300">
                        شراء الإطلالة كاملة الآن — 420.00 ₺
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

{{-- ==================== SMART CURRENCY CONVERTER ==================== --}}
<section class="py-12 bg-[#121214] text-white relative overflow-hidden border-y border-gray-800">
    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        
        <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-gray-800/80 border border-gray-700 text-xs font-bold tracking-wider uppercase mb-3 text-amber-400">
            <span>🔱 حاسبة أسعار التسوق الحية</span>
        </div>

        <h3 class="text-2xl md:text-3xl font-black text-white mb-2">
            حاسبة العملات <span class="bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">الذكية</span> ✨
        </h3>
        <p class="text-gray-400 text-xs md:text-sm mb-6 font-light">
            اعرف تكلفة مشترياتك بعملك المفضلة وبأسعار الصرف الحية لحظة بلحظة.
        </p>

        <div class="bg-[#18181b] rounded-3xl p-6 md:p-8 border border-gray-800 shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                
                <div class="text-right">
                    <label class="block text-xs font-bold text-gray-400 mb-2">المبلغ بالليرة التركية (₺):</label>
                    <input type="number" id="tryAmount" value="1000" min="1" class="w-full bg-gray-900 border border-gray-700 rounded-2xl py-3 px-4 text-white font-bold text-lg focus:outline-none focus:border-amber-500 transition">
                </div>

                <div class="text-right">
                    <label class="block text-xs font-bold text-gray-400 mb-2">تحويل إلى:</label>
                    <select id="targetCurrency" class="w-full bg-gray-900 border border-gray-700 rounded-2xl py-3 px-4 text-white font-bold text-lg focus:outline-none focus:border-amber-500 transition cursor-pointer">
                        <option value="USD" selected>💵 دولار أمريكي ($)</option>
                        <option value="EUR">💶 يورو (€)</option>
                        <option value="SAR">🇸🇦 ريال سعودي (SAR)</option>
                        <option value="AED">🇦🇪 درهم إماراتي (AED)</option>
                        <option value="JOD">🇯🇴 دينار أردني (JOD)</option>
                        <option value="KWD">🇰🇼 دينار كويتي (KWD)</option>
                    </select>
                </div>

                <div class="text-right md:text-center bg-gray-900 border border-gray-800 p-4 rounded-2xl">
                    <span class="block text-xs font-bold text-gray-400 mb-1">المبلغ المقابل تقريباً:</span>
                    <span class="text-2xl font-black text-amber-400" id="convertedResult">0.00 $</span>
                </div>

            </div>

            <div class="mt-6 pt-4 border-t border-gray-800 flex flex-wrap justify-between items-center text-xs text-gray-400 gap-2">
                <div class="flex items-center gap-4">
                    <span>💲 1 USD = <strong class="text-white" id="rateUSD">--</strong> TRY</span>
                    <span>💶 1 EUR = <strong class="text-white" id="rateEUR">--</strong> TRY</span>
                    <span>🇸🇦 1 SAR = <strong class="text-white" id="rateSAR">--</strong> TRY</span>
                </div>
                <span class="text-gray-500 text-[10px]" id="lastUpdate">🔄 جاري تحديث الأسعار...</span>
            </div>
        </div>

    </div>
</section>

{{-- ==================== FOOTER ==================== --}}
<footer class="bg-black text-gray-400 pt-16 pb-8 border-t border-gray-900">
    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-10 mb-12">
            <div>
                <h4 class="text-xl font-black text-white mb-4 tracking-wide">MELEKLER GROUP</h4>
                <p class="text-gray-400 leading-relaxed text-xs">متجرك الموثوق لأزياء الأطفال والنساء بتصاميم عصرية جودة عالية.</p>
                <div class="flex gap-4 mt-4 text-lg">
                    <a href="https://www.instagram.com/meleklerkids/" target="_blank" class="hover:text-amber-500 transition"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/MELEKLERKIDSTR" target="_blank" class="hover:text-amber-500 transition"><i class="fab fa-facebook"></i></a>
                    <a href="https://api.whatsapp.com/message/CL67ADRC7PMFO1" target="_blank" class="hover:text-amber-500 transition"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div>
                <h5 class="font-bold text-white mb-4 text-sm">التسوق</h5>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-amber-400 transition">وصل حديثاً</a></li>
                    <li><a href="{{ Route::has('category.boys') ? route('category.boys') : '/category/boys' }}" class="hover:text-amber-400 transition">ملابس أطفال</a></li>
                    <li><a href="{{ Route::has('category.women') ? route('category.women') : '/category/women' }}" class="hover:text-amber-400 transition">ملابس نساء</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold text-white mb-4 text-sm">خدمة العملاء</h5>
                <ul class="space-y-2 text-xs text-gray-400">
                    <li><a href="{{ Route::has('contact') ? route('contact') : '/contact' }}" class="hover:text-amber-400 transition">اتصل بنا</a></li>
                    <li><a href="/refund-policy" class="hover:text-amber-400 transition">سياسة الإرجاع</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold text-white mb-4 text-sm">اشترك في العروض</h5>
                <form action="#" method="POST" class="flex dir-ltr">
                    @csrf
                    <input type="email" name="email" placeholder="بريدك الإلكتروني" class="w-full px-3 py-2.5 rounded-l-xl bg-gray-900 border border-gray-800 text-white focus:outline-none focus:border-amber-500 transition text-xs" required>
                    <button type="submit" class="px-4 bg-amber-600 rounded-r-xl hover:bg-amber-500 text-white font-bold transition text-xs">اشتراك</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-900 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-xs">© 2026 Melekler Fashion — جميع الحقوق محفوظة</p>
            <p class="text-gray-600 text-[11px]">CREATED BY ALAA ALAKRABANI</p>
        </div>
    </div>
</footer>

<div class="bg-amber-600 text-white py-2 text-xs font-bold overflow-hidden">
    <div class="flex whitespace-nowrap gap-8 animate-marquee justify-around">
        <span>شحن مجاني للطلبات فوق 1000 ₺</span>
        <span>خصم 10% على أول طلب</span>
        <span>أحدث صيحات الموضة للأطفال 2026</span>
    </div>
</div>

{{-- ==================== ALL JAVASCRIPTS ==================== --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Swiper Slider Init
    new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
    });

    // 2. Currency Rates Fetcher
    const apiUrl = "https://open.er-api.com/v6/latest/TRY";
    let exchangeRates = {};

    const tryInput = document.getElementById('tryAmount');
    const targetSelect = document.getElementById('targetCurrency');
    const convertedResult = document.getElementById('convertedResult');
    const lastUpdateSpan = document.getElementById('lastUpdate');

    const currencySymbols = { USD: '$', EUR: '€', SAR: 'ر.س', AED: 'د.إ', JOD: 'د.أ', KWD: 'د.ك' };

    async function fetchRates() {
        try {
            const response = await fetch(apiUrl);
            const data = await response.json();
            
            if(data.result === "success") {
                exchangeRates = data.rates;
                document.getElementById('rateUSD').innerText = (1 / exchangeRates.USD).toFixed(2);
                document.getElementById('rateEUR').innerText = (1 / exchangeRates.EUR).toFixed(2);
                document.getElementById('rateSAR').innerText = (1 / exchangeRates.SAR).toFixed(2);

                const now = new Date();
                lastUpdateSpan.innerText = `تحديث مباشر: ${now.getHours()}:${now.getMinutes() < 10 ? '0' : ''}${now.getMinutes()}`;
                calculateConversion();
            }
        } catch (error) {
            console.error("خطأ في أسعار العملات:", error);
            lastUpdateSpan.innerText = "تعذر تحديث الأسعار التلقائي";
        }
    }

    function calculateConversion() {
        const amount = parseFloat(tryInput.value) || 0;
        const targetCurrency = targetSelect.value;
        const symbol = currencySymbols[targetCurrency] || targetCurrency;

        if (exchangeRates[targetCurrency]) {
            const converted = amount * exchangeRates[targetCurrency];
            convertedResult.innerText = `${converted.toFixed(2)} ${symbol}`;
        }
    }

    if(tryInput && targetSelect) {
        tryInput.addEventListener('input', calculateConversion);
        targetSelect.addEventListener('change', function() {
            localStorage.setItem('preferred_currency', targetSelect.value);
            calculateConversion();
        });

        const savedCurrency = localStorage.getItem('preferred_currency');
        if (savedCurrency && targetSelect.querySelector(`option[value="${savedCurrency}"]`)) {
            targetSelect.value = savedCurrency;
        }

        fetchRates();
    }
});

// 3. Fitting Room Functions
function openFittingRoom(id, name, img) {
    document.getElementById('fittingProductImg').src = img;
    document.getElementById('thumbPickedImg').src = img;
    document.getElementById('fittingRoomModal').classList.remove('hidden');
    
    const loader = document.getElementById('fittingLoader');
    loader.classList.remove('hidden');
    setTimeout(() => {
        loader.classList.add('hidden');
    }, 1200);
}

function closeFittingRoom() {
    document.getElementById('fittingRoomModal').classList.add('hidden');
}

function resetFitting() {
    const loader = document.getElementById('fittingLoader');
    loader.classList.remove('hidden');
    setTimeout(() => {
        loader.classList.add('hidden');
    }, 800);
}

function removePick(btn) {
    btn.parentElement.remove();
    document.getElementById('picksCount').innerText = "0 pieces";
}

// 4. Cart Action
function addToCart(productId) {
    fetch(`/cart-add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: 1, size: 'Free Size' })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response failure');
        return response.json();
    })
    .then(data => {
        if (typeof openCart === 'function') openCart();
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof openCart === 'function') openCart(); 
    });
}
</script>

@endsection
