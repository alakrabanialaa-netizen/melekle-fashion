@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">إضافة عميل / مورد</h2>

    <form method="POST" action="{{ route('admin.clients.store') }}">
        @csrf

        <input name="name" placeholder="الاسم" class="w-full mb-3 border p-2 rounded" required>
        <input name="phone" placeholder="رقم الهاتف" class="w-full mb-3 border p-2 rounded">
        <input name="email" placeholder="الإيميل" class="w-full mb-3 border p-2 rounded">
        <input name="country" placeholder="البلد" class="w-full mb-3 border p-2 rounded">
        <input name="city" placeholder="المحافظة" class="w-full mb-3 border p-2 rounded">
        <textarea name="address" placeholder="العنوان" class="w-full mb-3 border p-2 rounded"></textarea>

        <select name="type" class="w-full mb-4 border p-2 rounded" required>
            <option value="">اختر النوع</option>
            <option value="customer">عميل</option>
            <option value="supplier">مورد</option>
        </select>

        <button class="w-full bg-indigo-600 text-white py-2 rounded font-bold">
            حفظ
        </button>
    </form>

</div>
@endsection
