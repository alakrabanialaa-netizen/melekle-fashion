{{-- أضف هذا الجزء قبل قسم الأزرار في نموذج إضافة/تعديل المنتج، دون حذف أي حقل موجود --}}
<div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
    <label class="flex cursor-pointer items-center gap-3">
        <input type="hidden" name="is_wholesale" value="0">
        <input type="checkbox" name="is_wholesale" value="1" @checked(old('is_wholesale', $product->is_wholesale ?? false))>
        <span class="font-black text-amber-900">عرض المنتج لتجار الجملة فقط</span>
    </label>
    <p class="mt-2 text-xs text-amber-800">عند التفعيل لن يظهر المنتج للزوار أو العملاء العاديين، ويظهر داخل بوابة التجار بعد إدخال الكود.</p>
</div>
