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
    /**
     * عرض المنتجات في لوحة التحكم (Admin)
     */
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

    /**
     * عرض صفحة إضافة منتج جديد
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * حفظ المنتج الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات (بناءً على مسميات الحقول في ملف الـ Blade الخاص بك)
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'nullable|integer|min:0',
            'product_category' => 'required|string',
            'product_description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,webp,gif|max:4096',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20480',
        ]);

        try {
            return DB::transaction(function () use ($request, $validatedData) {
                // 2. إنشاء المنتج (ربط حقول الفورم بأعمدة قاعدة البيانات)
                $product = Product::create([
                    'name'        => $validatedData['product_name'],
                    'price'       => $validatedData['product_price'],
                    'description' => $validatedData['product_description'] ?? null,
                    'category'    => $validatedData['product_category'],
                    'stock'       => $validatedData['product_stock'] ?? 0,
                    'slug'        => $this->generateSlug($validatedData['product_name']),
                ]);

                // 3. معالجة الصور إذا وجدت
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('products', 'public');
                        $product->images()->create(['image' => $path]);
                    }
                }

                // 4. معالجة الفيديو إذا وجد
                if ($request->hasFile('video')) {
                    $videoPath = $request->file('video')->store('products/videos', 'public');
                    $product->update(['video' => $videoPath]);
                }

                return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء إضافة المنتج: ' . $e->getMessage());
        }
    }

    /**
     * عرض صفحة تعديل المنتج
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * تحديث بيانات المنتج
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_category' => 'required|string',
            'product_description' => 'nullable|string',
            'product_stock' => 'nullable|integer|min:0',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt,webm,avi,wmv|max:40000',
        ]);

        try {
            $product->update([
                'name'        => $validatedData['product_name'],
                'price'       => $validatedData['product_price'],
                'category'    => $validatedData['product_category'],
                'description' => $validatedData['product_description'] ?? null,
                'stock'       => $validatedData['product_stock'] ?? 0,
                'slug'        => $this->generateSlug($validatedData['product_name'], $product->id),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create(['image' => $path]);
                }
            }

            if ($request->hasFile('video')) {
                if ($product->video) {
                    Storage::disk('public')->delete($product->video);
                }
                $videoPath = $request->file('video')->store('products/videos', 'public');
                $product->update(['video' => $videoPath]);
            }

            return redirect()->route('admin.products.index')->with('success', 'تم تعديل المنتج بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء التعديل: ' . $e->getMessage());
        }
    }

    /**
     * حذف المنتج
     */
    public function destroy(Product $product)
    {
        try {
            return DB::transaction(function () use ($product) {
                foreach ($product->images as $img) {
                    if (Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                    $img->delete();
                }

                if ($product->video && Storage::disk('public')->exists($product->video)) {
                    Storage::disk('public')->delete($product->video);
                }

                $product->delete();
                return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح');
            });
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'خطأ في الحذف: ' . $e->getMessage());
        }
    }

    /**
     * عرض المنتج في الموقع (Frontend)
     */
    public function show($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();
        
        $relatedProducts = Product::with('images')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }

    /**
     * توليد الـ Slug بشكل فريد
     */
    private function generateSlug(string $name, $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: str_replace(' ', '-', $name);
        $slug = $baseSlug;
        $counter = 1;
        
        while (true) {
            $query = Product::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            
            if (!$query->exists()) {
                return $slug;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
    }
}
