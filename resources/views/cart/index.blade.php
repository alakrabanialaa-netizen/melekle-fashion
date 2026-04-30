@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="flex flex-col lg:flex-row gap-8">
        
        {{-- قسم المنتجات (الجهة اليمنى) --}}
        <div class="lg:w-2/3">
            <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-3">
                    <span class="bg-pink-100 p-3 rounded-2xl text-pink-600">🛒</span>
                    سلة المشتريات
                </h2>

                @if(session('cart') && count(session('cart')) > 0)
                    <div class="space-y-6">
                        @foreach(session('cart') as $id => $item)
                            <div class="group flex flex-col sm:flex-row items-center bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 rounded-3xl p-5 gap-6 border border-transparent hover:border-pink-100">
                                <div class="relative">
                                    <img src="{{ (isset($item['image']) && $item['image']) ? asset('storage/'.$item['image']) : 'https://via.placeholder.com/150' }}"
                                         class="w-28 h-28 object-cover rounded-2xl shadow-md group-hover:scale-105 transition-transform duration-300">
                                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold px-2 py-1 rounded-lg shadow-lg">
                                        {{ $item['quantity'] }}x
                                    </span>
                                </div>
                                
                                <div class="flex-1 text-center sm:text-right">
                                    <h3 class="font-bold text-xl text-gray-800 mb-1">{{ $item['name'] }}</h3>
                                    @if(isset($item['size']))
                                        <p class="text-sm text-gray-400 mb-2">المقاس: <span class="text-pink-500 font-medium">{{ $item['size'] }}</span></p>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-400">سعر الوحدة: {{ number_format($item['price'], 2) }} ₺</span>
                                        <p class="text-2xl font-black text-pink-600">{{ number_format($item['price'] * $item['quantity'], 2) }} ₺</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    {{-- مسار الحذف --}}
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-white text-red-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition-all duration-300 shadow-sm border border-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-24 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <div class="text-8xl mb-6">🛍️</div>
                        <p class="text-gray-400 text-xl font-medium">سلتك فارغة، ابدأ بالتسوق الآن!</p>
                        <a href="/" class="inline-block mt-6 text-pink-600 font-bold hover:underline">العودة للمتجر ←</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- قسم إتمام الطلب --}}
        @if(session('cart') && count(session('cart')) > 0)
        <div class="lg:w-1/3">
            <div class="bg-white rounded-3xl shadow-xl p-8 sticky top-8 border border-pink-50">
                <h3 class="text-2xl font-black text-gray-800 mb-6 flex items-center gap-2">
                    <span class="text-green-500 text-3xl">📋</span>
                    تفاصيل الشحن
                </h3>
                
                <form id="whatsappForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الاسم الكامل</label>
                        <input type="text" id="cust_name" required placeholder="أدخل اسمك"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">رقم الهاتف (واتساب)</label>
                        <input type="tel" id="cust_phone" required placeholder="مثال: 05xxxxxxx"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none text-left" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">البريد الإلكتروني</label>
                        <input type="email" id="cust_email" required placeholder="example@mail.com"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none text-left" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">عنوان الشحن بالتفصيل</label>
                        <textarea id="cust_address" required rows="3" placeholder="المدينة، الحي، الشارع..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all outline-none"></textarea>
                    </div>

                    <div class="pt-6 border-t mt-6 bg-pink-50/50 p-4 rounded-2xl">
                        @php
                            $total = collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; });
                        @endphp
                        
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-gray-500 text-sm font-bold">
                                <span>عدد المنتجات:</span>
                                <span>{{ count(session('cart')) }} منتج</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-t border-pink-100 mt-2">
                                <span class="text-gray-800 font-black text-lg">إجمالي الدفع:</span>
                                <span class="text-3xl font-black text-pink-600" id="final_total_display">{{ number_format($total, 2) }} ₺</span>
                            </div>
                        </div>

                        <button type="button" onclick="sendToWhatsApp()"
                                class="w-full mt-6 bg-green-500 hover:bg-green-600 text-white py-4 rounded-2xl font-black text-xl shadow-lg shadow-green-100 flex items-center justify-center gap-3 transform hover:-translate-y-1 transition-all duration-300">
                            <span>تثبيت الطلب عبر واتساب</span>
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </button>
                        
                        <p class="text-center text-xs text-gray-400 mt-4 font-bold italic">🚀 "سيصلك الطلب بأسرع وقت، شكراً لثقتك بنا!"</p>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function sendToWhatsApp() {
    const name = document.getElementById('cust_name').value;
    const phone = document.getElementById('cust_phone').value;
    const email = document.getElementById('cust_email').value;
    const address = document.getElementById('cust_address').value;

    if(!name || !phone || !email || !address) {
        alert('يرجى تعبئة كافة البيانات المطلوبة لإتمام الطلب');
        return;
    }

    let cartItems = @json(session('cart'));
    let total = {{ $total ?? 0 }};
    
    let message = `*📦 طلب شراء جديد من المتجر* \n`;
    message += `━━━━━━━━━━━━━━━━━━\n\n`;
    
    message += `*👤 بيانات العميل:*\n`;
    message += `• الاسم: ${name}\n`;
    message += `• الهاتف: ${phone}\n`;
    message += `• الإيميل: ${email}\n`;
    message += `• العنوان: ${address}\n\n`;
    
    message += `*🛒 المنتجات المطلوبة:*\n`;
    message += `━━━━━━━━━━━━━━━━━━\n`;
    
    Object.values(cartItems).forEach(item => {
        let itemTotal = item.price * item.quantity;
        message += `✅ *${item.name}*\n`;
        message += `   الكمية: ${item.quantity} | السعر: ${item.price} ₺\n`;
        if(item.size) message += `   المقاس: ${item.size}\n`;
        message += `   المجموع: ${itemTotal.toFixed(2)} ₺\n`;
        message += `------------------\n`;
    });
    
    message += `\n*💰 إجمالي الدفع النهائي: ${total.toFixed(2)} ₺* 💰\n`;
    message += `━━━━━━━━━━━━━━━━━━\n`;
    message += `_شكراً لتسوقكم معنا!_ ✨`;

    const whatsappNumber = "905550651100"; 
    const encodedMessage = encodeURIComponent(message);
    window.open(`https://wa.me/${whatsappNumber}?text=${encodedMessage}`, '_blank');
}
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap');
    body { font-family: 'Cairo', sans-serif; }
</style>
@endsection
