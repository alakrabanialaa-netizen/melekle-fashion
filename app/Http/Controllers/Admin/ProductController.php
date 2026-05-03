<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    /**
     * عرض المنتجات
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
     * صفحة الإضافة
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * حفظ المنتج - نسخة مصلحة وشاملة مع Cloudinary
     */
    public function store(Request $request)
    {
        // 1. وظيفة داخلية لتحويل الأرقام العربية/الفارسية إلى إنجليزية
        $convertDigits = function($string) {
            $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $english = range(0, 9);
            $string = str_replace($arabic, $english, $string);
            return str_replace($persian, $english, $string);
        };

        // 2. معالجة الأرقام قبل التحقق (Validation)
        if($request->has('product_price')) {
            $request->merge(['product_price' => $convertDigits($request->product_price)]);
        }
        if($request->has('product_stock')) {
            $request->merge(['product_stock' => $convertDigits($request->product_stock)]);
        }

        // 3. التحقق من البيانات
        $validatedData = $request->validate([
            'product_name'        => 'required|string|max:255',
            'product_price'       => 'required|numeric|min:0',
            'product_stock'       => 'nullable', 
            'product_category'    => 'required|string',
            'product_description' => 'nullable|string',
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,webp,gif|max:5120',
            'video'               => 'nullable|file|mimes:mp4,mov,ogg,qt|max:30720',
        ]);

        try {
            return DB::transaction(function () use ($request, $validatedData) {
                // 4. إنشاء المنتج
                $product = Product::create([
                    'name'        => $validatedData['product_name'],
                    'price'       => $validatedData['product_price'],
                    'description' => $validatedData['product_description'] ?? null,
                    'category'    => $validatedData['product_category'],
                    'stock'       => (int)($request->product_stock ?? 0),
                    'slug'        => $this->generateSlug($validatedData['product_name']),
                ]);

              // معالجة الصور - رفع مباشر بدون مكتبات معقدة
if ($request->hasFile('images')) {
    foreach ($request->file('images') as $image) {
        $file = $image->getRealPath();
        
        // البيانات التي ظهرت في لقطات الشاشة الخاصة بك
        $cloudName = "doajfaz15";
        $api_key = "251326666311568";
        $api_secret = "BP7sMBs-wWEZKHTP3mAmbZkePfQ";
        $timestamp = time();
        
        // بناء التوقيع الأمني يدوياً
        $params = [
            "folder" => "products",
            "timestamp" => $timestamp
        ];
        ksort($params);
        $signString = http_build_query($params) . $api_secret;
        $signString = str_replace(['&', '='] , ['' , ''] , $signString); // تنظيف الرابط للتوقيع
        $signature = sha1($signString);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/$cloudName/image/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "file" => new \CURLFile($file),
            "api_key" => $api_key,
            "timestamp" => $timestamp,
            "signature" => $signature,
            "folder" => "products"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (isset($result['secure_url'])) {
            $product->images()->create(['image' => $result['secure_url']]);
        }
    }
}

                // 6. معالجة الفيديو - الرفع إلى Cloudinary
                if ($request->hasFile('video')) {
                    $videoUrl = $request->file('video')->storeOnCloudinary('products/videos')->getSecurePath(); 
                    $product->update(['video' => $videoUrl]);
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
        ]);

        try {
            $product->update([
                'name'        => $validatedData['product_name'],
                'price'       => $validatedData['product_price'],
                'category'    => $validatedData['product_category'],
                'description' => $validatedData['product_description'] ?? null,
                'stock'       => (int)($request->product_stock ?? 0),
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
