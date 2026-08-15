@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen" dir="rtl">
    
    {{-- 📍 مؤشر خطوات الطلب (Progress Tracker) --}}
    <div class="max-w-3xl mx-auto mb-10">
        <div class="flex items-center justify-between relative">
            <div class="w-full absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -z-0 rounded-full"></div>
            <div class="w-1/2 absolute top-1/2 right-0 h-1 bg-pink-500 -z-0 rounded-full transition-all duration-500"></div>

            <div class="flex flex-col items-center relative z-10">
                <div class="w-10 h-10 rounded-full bg-pink-500 text-white font-bold flex items-center justify-center shadow-lg shadow-pink-200">1</div>
                <span class="text-xs font-bold text-gray-800 mt-2">سلة المشتريات</span>
            </div>
            <div class="flex flex-col items-center relative z-10">
                <div class="w-10 h-10 rounded-full bg-pink-500 text-white font-bold flex items-center justify-center shadow-lg shadow-pink-200">2</div>
                <span class="text-xs font-bold text-gray-800 mt-2">بيانات الشحن</span>
            </div>
            <div class="flex flex-col items-center relative z-10">
                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 font-bold flex items-center justify-center border-2 border-white">3</div>
                <span class="text-xs font-bold text-gray-400 mt-2">تأكيد الطلب</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- 🛒 قسم المنتجات (الجهة اليمنى) --}}
        <div class="lg:w-2/3">
            <div class="bg-white rounded-3xl shadow-sm p-6 md:p-8 border border-gray-100">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 flex items-center gap-3">
                        <span class="bg-pink-100 p-3 rounded-2xl text-pink-600">🛒</span>
                        سلة المشتريات
                    </h2>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="bg-pink-50 text-pink-600 font-bold px-4 py-1.5 rounded-full text-xs md:text-sm">
                            إجمالي العناصر: {{ count(session('cart')) }}
                        </span>
                    @endif
                </div>

                @if(session('cart') && count(session('cart')) > 0)
                    <div class="space-y-4">
                        @foreach(session('cart') as $id => $item)
                            <div class="group flex flex-col sm:flex-row items-center bg-gray-50/80 hover:bg-white hover:shadow-xl hover:shadow-pink-500/5 transition-all duration-300 rounded-3xl p-4 md:p-5 gap-5 border border-gray-100 hover:border-pink-100">
                                
                                {{-- صورة المنتج --}}
                                <div class="relative shrink-0">
                                    @if(isset($item['image']) && (str_starts_with($item['image'], 'http://') || str_starts_with($item['image'], 'https://')))
                                        <img src="{{ $item['image'] }}" class="w-24 h-24 md:w-28 md:h-28 object-cover rounded-2xl shadow-md group-hover:scale-105 transition-transform duration-300" alt="{{ $item['name'] }}">
                                    @elseif(isset($item['image']) && $item['image'])
                                        <img src="{{ asset('storage/'.$item['image']) }}" class="w-24 h-24 md:w-28 md:h-28 object-cover rounded-2xl shadow-md group-hover:scale-105 transition-transform duration-300" alt="{{ $item['name'] }}">
                                    @else
                                        <img src="https://via.placeholder.com/150?text=No+Image" class="w-24 h-24 md:w-28 md:h-28 object-cover rounded-2xl shadow-md group-hover:scale-105 transition-transform duration-300" alt="{{ $item['name'] }}">
                                    @endif

                                    <span class="absolute -top-2 -right-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs font-black px-2.5 py-1 rounded-xl shadow-lg">
                                        {{ $item['quantity'] }}x
                                    </span>
                                </div>
                                
                                {{-- تفاصيل المنتج --}}
                                <div class="flex-1 text-center sm:text-right">
                                    <h3 class="font-bold text-lg md:text-xl text-gray-800 mb-1 leading-snug">{{ $item['name'] }}</h3>
                                    
                                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-3">
                                        {{-- كود المنتج --}}
                                        <span class="inline-flex items-center text-xs font-semibold bg-gray-200/60 text-gray-600 px-2.5 py-1 rounded-lg">
                                            رمز المنتج: #{{ $item['code'] ?? $item['sku'] ?? $id }}
                                        </span>
                                        {{-- المقاس --}}
                                        @if(isset($item['size']))
                                            <span class="inline-flex items-center text-xs font-bold bg-pink-100/70 text-pink-700 px-2.5 py-1 rounded-lg">
                                                المقاس: {{ $item['size'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-center sm:justify-start gap-3">
                                        <span class="text-xs text-gray-400">سعر القطعة: {{ number_format($item['price'], 2) }} ₺</span>
                                        <span class="text-lg md:text-2xl font-black text-pink-600">{{ number_format($item['price'] * $item['quantity'], 2) }} ₺</span>
                                    </div>
                                </div>

                                {{-- زر الإزالة --}}
                                <div class="flex items-center gap-2">
                                    <a href="{{ url('cart-remove/'.$id) }}" 
                                       title="حذف المنتج"
                                       class="p-3 bg-red-50 text-red-500 hover:text-white hover:bg-red-500 rounded-2xl transition-all duration-300 shadow-sm border border-red-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- الضمانات والمميزات --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 pt-6 border-t border-gray-100 text-center">
                        <div class="p-3 bg-gray-50 rounded-2xl">
                            <span class="block text-xl mb-1">⚡</span>
                            <h4 class="text-xs font-bold text-gray-700">تأكيد سريع</h4>
                            <p class="text-[11px] text-gray-400">متابعة فورية للطلب عبر الواتساب</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-2xl">
                            <span class="block text-xl mb-1">🛡️</span>
                            <h4 class="text-xs font-bold text-gray-700">جودة مضمونة</h4>
                            <p class="text-[11px] text-gray-400">أزياء وأقمشة عالية الجودة</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-2xl">
                            <span class="block text-xl mb-1">🚚</span>
                            <h4 class="text-xs font-bold text-gray-700">شحن لكافة الولايات</h4>
                            <p class="text-[11px] text-gray-400">توصيل سريع وآمن لعنوانك</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-20 bg-gray-50/50 rounded-3xl border-2 border-dashed border-gray-200">
                        <div class="text-7xl mb-4">🛍️</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">سلة المشتريات فارغة</h3>
                        <p class="text-gray-400 text-sm mb-6">يبدو أنك لم تضف أي منتجات إلى سلتك بعد.</p>
                        <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-bold rounded-2xl shadow-lg shadow-pink-200 transition">
                            <span>استكشف المنتجات الآن</span>
                            <span>←</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- 📋 قسم تفاصيل الشحن والطلب --}}
        @if(session('cart') && count(session('cart')) > 0)
        <div class="lg:w-1/3">
            <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8 sticky top-8 border border-pink-50">
                <h3 class="text-2xl font-black text-gray-800 mb-6 flex items-center gap-2">
                    <span class="text-emerald-500 text-2xl">📋</span>
                    تفاصيل الشحن
                </h3>
                
                <form id="whatsappForm" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" id="cust_name" required placeholder="أدخل اسمك الكامل"
                               class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none bg-gray-50/30">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">رقم الهاتف (واتساب) <span class="text-red-500">*</span></label>
                        <input type="tel" id="cust_phone" required placeholder="05xxxxxxx"
                               class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none bg-gray-50/30 text-left" dir="ltr">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">البريد الإلكتروني (اختياري)</label>
                        <input type="email" id="cust_email" placeholder="example@mail.com"
                               class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none bg-gray-50/30 text-left" dir="ltr">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">عنوان الشحن بالتفصيل <span class="text-red-500">*</span></label>
                        <textarea id="cust_address" required rows="3" placeholder="المدينة، الحي، الشارع، رقم البناء والشقة..."
                                  class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none bg-gray-50/30"></textarea>
                    </div>

                    {{-- طريقة الدفع المفضل --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">طريقة الدفع المفضلة</label>
                        <select id="cust_payment" class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none bg-gray-50/30 cursor-pointer">
                            <option value="الدفع عند الاستلام">💵 الدفع عند الاستلام</option>
                            <option value="تحويل بنكي / Havale">🏦 تحويل بنكي (Havale/EFT)</option>
                        </select>
                    </div>

                    {{-- ملاحظات إضافية --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">ملاحظات إضافية (اختياري)</label>
                        <input type="text" id="cust_notes" placeholder="أي ملاحظات بخصوص التوصيل..."
                               class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none bg-gray-50/30">
                    </div>

                    {{-- الملخص المالي --}}
                    <div class="pt-4 border-t mt-6 bg-gradient-to-br from-pink-50/80 to-rose-50/50 p-4 rounded-2xl border border-pink-100">
                        @php
                            $total = collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; });
                        @endphp
                        
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-gray-600 text-xs font-bold">
                                <span>عدد المنتجات المختلفة:</span>
                                <span>{{ count(session('cart')) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-t border-pink-100/80 mt-2">
                                <span class="text-gray-900 font-black text-base">إجمالي الدفع:</span>
                                <span class="text-2xl md:text-3xl font-black text-pink-600" id="final_total_display">{{ number_format($total, 2) }} ₺</span>
                            </div>
                        </div>

                        {{-- زر التثبيت --}}
                        <button type="button" onclick="sendToWhatsApp()"
                                class="w-full mt-4 bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-2xl font-black text-lg shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3 transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                            <span>تثبيت الطلب عبر واتساب</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </button>
                        
                        <p class="text-center text-[11px] text-gray-400 mt-3 font-medium">✨ سيتم توجيهك مباشرة لمحادثة الواتساب لإتمام عملية الشراء</p>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ⚙️ SCRIPT TO HANDLE WHATSAPP ORDER SENDING --}}
<script>
function sendToWhatsApp() {
    const name = document.getElementById('cust_name').value.trim();
    const phone = document.getElementById('cust_phone').value.trim();
    const email = document.getElementById('cust_email').value.trim();
    const address = document.getElementById('cust_address').value.trim();
    const payment = document.getElementById('cust_payment').value;
    const notes = document.getElementById('cust_notes').value.trim();

    if(!name || !phone || !address) {
        alert('يرجى تعبئة الحقول المطلوبة: (الاسم، رقم الهاتف، وعنوان الشحن)');
        return;
    }

    let cartItems = @json(session('cart'));
    let total = {{ $total ?? 0 }};
    
    let message = `*📦 طلب شراء جديد من المتجر* \n`;
    message += `━━━━━━━━━━━━━━━━━━\n\n`;
    
    // بيانات العميل
    message += `*👤 بيانات العميل:*\n`;
    message += `• *الاسم:* ${name}\n`;
    message += `• *الهاتف:* ${phone}\n`;
    if(email) message += `• *البريد:* ${email}\n`;
    message += `• *العنوان:* ${address}\n`;
    message += `• *طريقة الدفع:* ${payment}\n`;
    if(notes) message += `• *ملاحظات:* ${notes}\n`;
    message += `\n`;
    
    // تفاصيل المنتجات والمقاس والكود
    message += `*🛒 المنتجات المطلوبة:*\n`;
    message += `━━━━━━━━━━━━━━━━━━\n`;
    
    Object.entries(cartItems).forEach(([id, item]) => {
        let itemTotal = item.price * item.quantity;
        let itemCode = item.code || item.sku || id;
        
        message += `🔹 *${item.name}*\n`;
        message += `   • *الكود:* #${itemCode}\n`;
        if(item.size) message += `   • *المقاس:* ${item.size}\n`;
        message += `   • *الكمية:* ${item.quantity}\n`;
        message += `   • *السعر:* ${item.price} ₺\n`;
        message += `   • *المجموع:* ${itemTotal.toFixed(2)} ₺\n`;
        message += `------------------\n`;
    });
    
    message += `\n*💰 إجمالي الدفع النهائي: ${total.toFixed(2)} ₺*\n`;
    message += `━━━━━━━━━━━━━━━━━━\n`;
    message += `_شكراً لتسوقكم معنا!_ ✨`;

    // الرقم المحدث
    const whatsappNumber = "905550761000"; 
    const encodedMessage = encodeURIComponent(message);
    window.open(`https://wa.me/${whatsappNumber}?text=${encodedMessage}`, '_blank');
}
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');
    body { font-family: 'Cairo', sans-serif; }
</style>
@endsection
