@extends('admin.layouts.app')

@section('page-title', 'أكواد تجار الجملة')
@section('content')
<div dir="rtl" class="mx-auto max-w-6xl space-y-6 py-8">
    @if(session('status')) <div class="rounded-xl bg-emerald-50 p-4 font-bold text-emerald-700">{{ session('status') }}</div> @endif
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-zinc-100"><h1 class="mb-5 text-2xl font-black">إنشاء كود خاص لزبون</h1><form method="POST" action="{{ route('admin.wholesale.codes.store') }}" class="grid gap-4 md:grid-cols-4">@csrf<input name="customer_name" required placeholder="اسم التاجر" class="rounded-xl border p-3"><input name="code" required minlength="6" placeholder="الكود السري" dir="ltr" class="rounded-xl border p-3"><input type="datetime-local" name="expires_at" class="rounded-xl border p-3"><button class="rounded-xl bg-zinc-950 px-4 py-3 font-bold text-white">إنشاء الكود</button></form></div>
    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm"><table class="w-full text-right"><thead class="bg-zinc-50"><tr><th class="p-4">التاجر</th><th class="p-4">تلميح الكود</th><th class="p-4">الصلاحية</th><th class="p-4">آخر استخدام</th><th class="p-4">الإجراء</th></tr></thead><tbody>@foreach($codes as $code)<tr class="border-t"><td class="p-4 font-bold">{{ $code->customer_name }}</td><td class="p-4 font-mono">{{ $code->code_hint }}</td><td class="p-4">{{ $code->expires_at?->format('Y-m-d H:i') ?? 'بدون انتهاء' }}</td><td class="p-4">{{ $code->last_used_at?->diffForHumans() ?? 'لم يستخدم' }}</td><td class="p-4"><form method="POST" action="{{ route('admin.wholesale.codes.toggle', $code) }}">@csrf @method('PATCH')<button class="font-bold {{ $code->is_active ? 'text-red-600' : 'text-emerald-600' }}">{{ $code->is_active ? 'تعطيل' : 'تفعيل' }}</button></form></td></tr>@endforeach</tbody></table></div>
    {{ $codes->links() }}
</div>
@endsection
