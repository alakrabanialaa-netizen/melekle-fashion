@extends('layouts.app')

@section('content')

<div class="bg-white text-gray-900 py-24">

    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADER -->
        <div class="text-center mb-20 fade-in">
            <h1 class="text-5xl md:text-6xl font-black mb-4">
                تواصل معنا
            </h1>
            <p class="text-gray-500 max-w-xl mx-auto">
                نحن هنا لمساعدتك في أي وقت — تواصل معنا بسهولة
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16">

            <!-- INFO -->
            <div class="space-y-6">

                <div class="p-6 rounded-2xl border hover:shadow-xl transition fade-in">
                    <h3 class="font-bold text-lg mb-2">📍 العنوان</h3>
                    <p class="text-gray-500">اسطنبول - تركيا</p>
                </div>

                <div class="p-6 rounded-2xl border hover:shadow-xl transition fade-in">
                    <h3 class="font-bold text-lg mb-2">📞 الهاتف</h3>
                    <p class="text-gray-500">+90 555 000 0000</p>
                </div>

                <div class="p-6 rounded-2xl border hover:shadow-xl transition fade-in">
                    <h3 class="font-bold text-lg mb-2">✉️ البريد الإلكتروني</h3>
                    <p class="text-gray-500">info@yourstore.com</p>
                </div>

                <!-- WHATSAPP -->
                <a href="https://wa.me/905550000000" target="_blank"
                   class="block text-center bg-green-500 text-white py-4 rounded-xl font-bold hover:bg-green-600 transition fade-in">
                    💬 تواصل واتساب مباشر
                </a>

            </div>

            <!-- FORM -->
            <div class="fade-in">

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-center">
                        {{ session('success') }}
                    </div>
                @endif

                    @csrf

                    <div>
                        <input type="text" name="name" placeholder="الاسم"
                               class="w-full p-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                               value="{{ old('name') }}">
                        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="email" name="email" placeholder="البريد الإلكتروني"
                               class="w-full p-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition"
                               value="{{ old('email') }}">
                        @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <textarea name="message" rows="5" placeholder="اكتب رسالتك..."
                                  class="w-full p-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-black transition">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <button class="w-full bg-black text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition">
                        إرسال
                    </button>

                </form>

            </div>

        </div>

        <!-- GOOGLE MAP -->
        <div class="mt-20 fade-in">
            <iframe
                src="https://www.google.com/maps?q=Istanbul&output=embed"
                class="w-full h-[400px] rounded-2xl border"
                loading="lazy">
            </iframe>
        </div>

    </div>

</div>

<style>
.fade-in {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s ease;
}

.fade-in.show {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
});

document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});
</script>

@endsection