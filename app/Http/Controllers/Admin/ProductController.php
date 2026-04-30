<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $products = $query->latest()->paginate(10);
        $products->appends($request->all());
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // 1. تعديل التحقق ليكون أكثر مرونة مع الأرقام والملفات
        $validatedData = $request->validate([
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_stock'       => 'nullable', // جعلناه مرناً
            'product_category'    => 'required|string',
            'product_description' => 'nullable|string',
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,webp,gif|max:5120', // زيادة الحجم لـ 5 ميجا
            'video'               => 'nullable|file|mimes:mp4,mov,ogg,qt|max:30720', // زيادة الحجم لـ 30 ميجا
        ]);

        try {
            return DB::transaction(function () use ($request, $validatedData) {
                // 2. إنشاء المنتج
                $product = Product::create([
                    'name'        => $validatedData['product_name'],
                    'price'       => $validatedData['product_price'],
                    'description' => $validatedData['product_description'] ?? null,
                    'category'    => $validatedData['product_category'],
                    'stock'       => (int)($validatedData['product_stock'] ?? 0),
                    'slug'        => $this->generateSlug($validatedData['product_name']),
                ]);

                // 3. معالجة الصور
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('products', 'public');
                        $product->images()->create(['image' => $path]);
                    }
                }

                // 4. معالجة الفيديو (تصحيح الخطأ هنا)
                if ($request->hasFile('video')) {
                    // قمت بتغيير $image إلى $request->file('video') لأن $image غير معرف هنا
                    $videoPath = $request->file('video')->store('products/videos', 'public'); 
                    $product->update(['video' => $videoPath]);
                }

                return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
            });

        } catch (\Exception $e) {
            // إضافة withInput لإبقاء البيانات في الحقول عند حدوث خطأ
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|string',
            'product_description' => 'nullable|string',
            'product_stock' => 'nullable',
        ]);

        try {
            $product->update([
                'name'        => $validatedData['product_name'],
                'price'       => $validatedData['product_price'],
                'category'    => $validatedData['product_category'],
                'description' => $validatedData['product_description'] ?? null,
                'stock'       => (int)($validatedData['product_stock'] ?? 0),
                'slug'        => $this->generateSlug($validatedData['product_name'], $product->id),
            ]);

            return redirect()->route('admin.products.index')->with('success', 'تم تعديل المنتج بنجاح');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ أثناء التعديل: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'خطأ في الحذف');
        }
    }

    private function generateSlug(string $name, $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: str_replace(' ', '-', $name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        return $slug;
    }
}
