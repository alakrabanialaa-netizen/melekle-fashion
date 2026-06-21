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
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('product_code', 'like', '%' . $request->search . '%');
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
        // دالة تحويل الأرقام العربية/الفارسية إلى إنجليزية لضمان الحفظ في قاعدة البيانات
        $convertDigits = function($string) {
            $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            $english = range(0, 9);
            $string = str_replace($arabic, $english, $string);
            return str_replace($persian, $english, $string);
        };

        if($request->has('price')) {
            $request->merge(['price' => $convertDigits($request->price)]);
        }
        if($request->has('cost_price')) {
            $request->merge(['cost_price' => $convertDigits($request->cost_price)]);
        }
        if($request->has('stock')) {
            $request->merge(['stock' => $convertDigits($request->stock)]);
        }

        // تم تعديل المفاتيح هنا لتطابق الحقول الموحدة الجديدة في الـ Blade
        $validatedData = $request->validate([
            'product_code' => 'required|string|unique:products,product_code',
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'cost_price'   => 'required|numeric|min:0',
            'stock'        => 'nullable', 
            'category'     => 'required|string',
            'color'        => 'nullable|string|max:100',
            'description'  => 'nullable|string',
            'sizes'        => 'nullable|array',
            'ages'         => 'nullable|array', 
            'images'       => 'nullable|array',
            'images.*'     => 'image|mimes:jpeg,png,webp,gif|max:5120',
            'video'        => 'nullable|file|mimes:mp4,mov,ogg,qt|max:30720',
        ]);

        try {
            return DB::transaction(function () use ($request, $validatedData) {
                $product = Product::create([
                    'product_code' => $validatedData['product_code'],
                    'name'         => $validatedData['name'],
                    'price'        => $validatedData['price'],
                    'cost_price'   => $validatedData['cost_price'],
                    'color'        => $validatedData['color'] ?? null,
                    'description'  => $validatedData['description'] ?? null,
                    'category'     => $validatedData['category'],
                    'stock'        => (int)($request->stock ?? 0),
                    'sizes'        => $request->input('sizes', []),
                    'ages'         => $request->input('ages', []), 
                    'slug'         => $this->generateSlug($validatedData['name']),
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
        // دالة تحويل الأرقام العربية للتعديل أيضاً لضمان السلامة
        $convertDigits = function($string) {
            $arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','٩'];
            $english = range(0, 9);
            $string = str_replace($arabic, $english, $string);
            return str_replace($persian, $english, $string);
        };

        if($request->has('price')) { $request->merge(['price' => $convertDigits($request->price)]); }
        if($request->has('cost_price')) { $request->merge(['cost_price' => $convertDigits($request->cost_price)]); }
        if($request->has('stock')) { $request->merge(['stock' => $convertDigits($request->stock)]); }

        // تحديث الفالياديشن ليشمل كافة الحقول المدعومة والمضافة حديثاً للتعديل
        $validatedData = $request->validate([
            'product_code' => 'required|string|unique:products,product_code,' . $product->id,
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'cost_price'   => 'required|numeric|min:0',
            'category'     => 'required|string',
            'description'  => 'nullable|string',
            'stock'        => 'nullable',
            'color'        => 'nullable|string|max:100',
            'sizes'        => 'nullable|array',
            'ages'         => 'nullable|array', 
        ]);

        try {
            $product->update([
                'product_code' => $validatedData['product_code'],
                'name'         => $validatedData['name'],
                'price'        => $validatedData['price'],
                'cost_price'   => $validatedData['cost_price'],
                'category'     => $validatedData['category'],
                'description'  => $validatedData['description'] ?? null,
                'color'        => $validatedData['color'] ?? null,
                'stock'        => (int)($request->stock ?? 0),
                'sizes'        => $request->input('sizes', []),
                'ages'         => $request->input('ages', []), 
                'slug'         => $this->generateSlug($validatedData['name'], $product->id),
            ]);

            return redirect()->route('admin.products.index')->with('success', 'تم تعديل المنتج بنجاح');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ أثناء التعديل: ' . $e->getMessage());
        }
    }

    // تعديل الدالة لاستقبال الـ ID مباشرة لضمان نجاح الحذف من مسار الـ Blade المصحح
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'خطأ في الحذف: ' . $e->getMessage());
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
