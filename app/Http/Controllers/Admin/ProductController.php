<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // دالة واحدة متكاملة للعرض والبحث والترقيم
    public function index(Request $request)
    {
        $query = Product::with('images');

        // البحث إذا كان موجوداً
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // جلب البيانات مع الترقيم (10 منتجات في الصفحة)
        $products = $query->latest()->paginate(10);
        
        // الحفاظ على بارامترات البحث عند التنقل بين الصفحات
        $products->appends($request->all());

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // فنكشن تحويل الأرقام العربية/الفارسية إلى إنجليزية لضمان الحفظ في قاعدة البيانات
        $convertDigits = function($string) {
            $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $english = range(0, 9);
            $string = str_replace($arabic, $english, $string);
            return str_replace($persian, $english, $string);
        };

        if($request->has('product_price')) {
            $request->merge(['product_price' => $convertDigits($request->product_price)]);
        }
        if($request->has('product_stock')) {
            $request->merge(['product_stock' => $convertDigits($request->product_stock)]);
        }

        $validatedData = $request->validate([
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_stock'       => 'nullable', 
            'product_category'    => 'required|string',
            'product_description' => 'nullable|string',
            'sizes'               => 'nullable|array', // تم الإصلاح هنا
            'ages'                => 'nullable|array',  // تم الإصلاح هنا
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,webp,gif|max:5120',
            'video'               => 'nullable|file|mimes:mp4,mov,ogg,qt|max:30720',
        ]);

        try {
            return DB::transaction(function () use ($request, $validatedData) {
                $product = Product::create([
                    'name'        => $validatedData['product_name'],
                    'price'       => $validatedData['product_price'],
                    'description' => $validatedData['product_description'] ?? null,
                    'category'    => $validatedData['product_category'],
                    'stock'       => (int)($request->product_stock ?? 0),
                    'sizes'       => $request->input('sizes', []), // تم الإصلاح هنا
                    'ages'        => $request->input('ages', []),  // تم الإصلاح هنا
                    'slug'        => $this->generateSlug($validatedData['product_name']),
                ]);

                $cloudName = "doajfaz15";
                $api_key = "251326666311568";
                $api_secret = "BP7sMBs-wWEZKHTP3mAmbZkePfQ";

                // رفع الصور إلى Cloudinary
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $timestamp = time();
                        $signature = sha1("folder=products&timestamp=$timestamp$api_secret");

                        $ch = curl_init("https://api.cloudinary.com/v1_1/$cloudName/image/upload");
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, [
                            "file" => new \CURLFile($image->getRealPath()),
                            "api_key" => $api_key,
                            "timestamp" => $timestamp,
                            "signature" => $signature,
                            "folder" => "products"
                        ]);
                        $result = json_decode(curl_exec($ch), true);
                        curl_close($ch);

                        if (isset($result['secure_url'])) {
                            $product->images()->create(['image' => $result['secure_url']]);
                        }
                    }
                }

                // رفع الفيديو إلى Cloudinary
                if ($request->hasFile('video')) {
                    $timestamp = time();
                    $signature = sha1("folder=products/videos&timestamp=$timestamp$api_secret");

                    $ch = curl_init("https://api.cloudinary.com/v1_1/$cloudName/video/upload");
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, [
                        "file" => new \CURLFile($request->file('video')->getRealPath()),
                        "api_key" => $api_key,
                        "timestamp" => $timestamp,
                        "signature" => $signature,
                        "folder" => "products/videos"
                    ]);
                    $result = json_decode(curl_exec($ch), true);
                    curl_close($ch);

                    if (isset($result['secure_url'])) {
                        $product->update(['video' => $result['secure_url']]);
                    }
                }

                return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ أثناء الحفظ: ' . $e->getMessage());
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
            'sizes' => 'nullable|array', // تم الإصلاح هنا
            'ages' => 'nullable|array',  // تم الإصلاح هنا
        ]);

        try {
            $product->update([
                'name'        => $validatedData['product_name'],
                'price'       => $validatedData['product_price'],
                'category'    => $validatedData['product_category'],
                'description' => $validatedData['product_description'] ?? null,
                'stock'       => (int)($request->product_stock ?? 0),
                'sizes'       => $request->input('sizes', []), // تم الإصلاح هنا
                'ages'        => $request->input('ages', []),  // تم الإصلاح هنا
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
