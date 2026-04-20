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


    public function store(Request $request)
{
    // 1. التحقق من البيانات (تأكد أن المسميات تطابق ملف الـ Blade)
    $request->validate([
        'product_name' => 'required|max:255',
        'product_price' => 'required|numeric',
    ]);

    // 2. حفظ البيانات في قاعدة البيانات
    // ملاحظة: تأكد أن أسماء الأعمدة في الجدول هي (name, price, description)
    \App\Models\Product::create([
        'name'        => $request->product_name,
        'price'       => $request->product_price,
        'description' => $request->product_description,
        'category'    => $request->product_category,
        // إذا كان لديك صورة، ستحتاج لمعالجتها هنا أيضاً
    ]);

    // 3. التوجيه لصفحة القائمة مع رسالة نجاح
    return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
}

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge_text' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,webp,gif|max:4096',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20480',
        ]);

        try {
            return DB::transaction(function () use ($request, $validatedData) {
                $product = Product::create([
                    'name' => $validatedData['name'],
                    'price' => $validatedData['price'],
                    'cost_price' => $validatedData['cost_price'],
                    'original_price' => $validatedData['original_price'],
                    'badge_text' => $validatedData['badge_text'],
                    'stock' => $validatedData['stock'],
                    'category' => $validatedData['category'],
                    'description' => $validatedData['description'] ?? null,
                    'slug' => $this->generateSlug($validatedData['name']),
                ]);

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('products', 'public');
                        $product->images()->create(['image' => $path]);
                    }
                }

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

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge_text' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt,webm,avi,wmv|max:40000',
        ]);

        try {
            $product->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'cost_price' => $validatedData['cost_price'],
                'original_price' => $validatedData['original_price'],
                'badge_text' => $validatedData['badge_text'],
                'stock' => $validatedData['stock'],
                'category' => $validatedData['category'],
                'description' => $validatedData['description'] ?? null,
                'slug' => $this->generateSlug($validatedData['name'], $product->id),
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

    public function destroy(Product $product)
    {
        try {
            return DB::transaction(function () use ($product) {
                // 1. حذف الصور من السيرفر ومن قاعدة البيانات
                foreach ($product->images as $img) {
                    if (Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }
                    $img->delete(); // حذف السجل من جدول product_images
                }

                // 2. حذف الفيديو من السيرفر
                if ($product->video && Storage::disk('public')->exists($product->video)) {
                    Storage::disk('public')->delete($product->video);
                }

                // 3. حذف المنتج نهائياً
                $product->delete();

                return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج وكافة ملحقاته بنجاح');
            });
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'خطأ في الحذف: تأكد أن المنتج غير مرتبط بطلبات سابقة.');
        }
    }

    public function show($slug)
    {
        $product = Product::with('images')->where('slug', $slug)->firstOrFail();
        
        $relatedProducts = Product::with('images')
            ->where('category', $product->category) // تم تصحيح category_id إلى category بناءً على الـ store
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.shop.show', compact('product', 'relatedProducts'));
    }

    private function generateSlug(string $name, $ignoreId = null): string
    {
        // دعم الـ Slug للغة العربية والإنجليزية بشكل صحيح
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
