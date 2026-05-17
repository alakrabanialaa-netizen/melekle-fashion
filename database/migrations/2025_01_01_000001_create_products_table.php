public function up(): void
    {
        Schema::create('products', function (Blueprint $box) {
            $box->id();
            $box->string('product_name');
            $box->string('product_slug');
            $box->string('slug')->nullable(); // 🌟 أضف هذا السطر هنا فوراً لحل المشكلة نهائياً
            $box->string('product_code')->nullable();
            $box->string('product_qty')->nullable();
            $box->string('product_tags')->nullable();
            $box->string('product_size')->nullable();
            $box->string('product_color')->nullable();
            $box->string('selling_price');
            $box->string('discount_price')->nullable();
            $box->text('short_descp')->nullable();
            $box->text('long_descp')->nullable();
            $box->string('product_thambnail')->nullable();
            $box->integer('hot_deals')->nullable();
            $box->integer('featured')->nullable();
            $box->integer('special_offer')->nullable();
            $box->integer('special_deals')->nullable();
            $box->integer('status')->default(1);
            $box->timestamps();
        });
    }
