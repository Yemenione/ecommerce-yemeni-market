<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class FullCatalogSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        ProductVariant::truncate();
        Product::truncate();
        Category::truncate();
        Coupon::truncate();

        Schema::enableForeignKeyConstraints();

        // 1. Coupons
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10,
                'min_cart_value' => 0,
                'expires_at' => now()->addYear(),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed', // Assuming fixed 0 means something or free shipping is handled elsewhere? 
                // Actually usually 'free_shipping' type or fixed value discount.
                // Let's make it a fixed discount of 5 EUR for now as "Free Shipping" logic usually is complex.
                // Or better, let's stick to percentage/fixed logic supported by model.
                'type' => 'fixed',
                'value' => 5.00,
                'min_cart_value' => 50,
                'expires_at' => now()->addYear(),
            ],
            [
                'code' => 'EID2026',
                'type' => 'percent',
                'value' => 20,
                'min_cart_value' => 100,
                'expires_at' => now()->addMonth(),
            ],
        ];

        foreach ($coupons as $c) {
            Coupon::create($c);
        }

        // 2. Categories
        $categories = [
            [
                'name' => ['en' => 'Yemeni Coffee', 'fr' => 'Café Yéménite', 'ar' => 'البن اليمني'],
                'slug' => 'coffee',
                'description' => ['en' => 'World-renowned organic coffee from the mountains of Yemen.', 'ar' => 'بن عضوي مشهور عالمياً من جبال اليمن.'],
                'image' => 'categories/coffee.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => ['en' => 'Sidr Honey', 'fr' => 'Miel Sidr', 'ar' => 'عسل السدر'],
                'slug' => 'honey',
                'description' => ['en' => 'Pure, medicinal grade honey from the Sidr trees.', 'ar' => 'عسل نقي وعلاجي من أشجار السدر.'],
                'image' => 'categories/honey.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => ['en' => 'Spices & Herbs', 'fr' => 'Épices et Herbes', 'ar' => 'بهارات وأعشاب'],
                'slug' => 'spices',
                'description' => ['en' => 'Aromatic spices and blends from the heart of Sana\'a.', 'ar' => 'بهارات وخلطات عطرية من قلب صنعاء.'],
                'image' => 'categories/spices.jpg',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => ['en' => 'Jambiyas', 'fr' => 'Jambiyas', 'ar' => 'الجنابي'],
                'slug' => 'jambiyas',
                'description' => ['en' => 'Traditional Yemeni daggers, a symbol of heritage.', 'ar' => 'خناجر يمنية تقليدية، رمز للتراث.'],
                'image' => 'categories/jambiya.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => ['en' => 'Jewelry', 'fr' => 'Bijoux', 'ar' => 'مجوهرات'],
                'slug' => 'jewelry',
                'description' => ['en' => 'Handcrafted silver and agate jewelry.', 'ar' => 'مجوهرات مصنوعة يدوياً من الفضة والعقيق.'],
                'image' => 'categories/jewelry.jpg',
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => ['en' => 'Fashion', 'fr' => 'Mode', 'ar' => 'أزياء'],
                'slug' => 'fashion',
                'description' => ['en' => 'Traditional and modern Yemeni clothing.', 'ar' => 'ملابس يمنية تقليدية وعصرية.'],
                'image' => 'categories/fashion.jpg',
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($categories as $catData) {
            $category = Category::create($catData);

            // 3. Products per Category
            switch ($category->slug) {
                case 'coffee':
                    $this->createCoffeeProducts($category);
                    break;
                case 'honey':
                    $this->createHoneyProducts($category);
                    break;
                case 'spices':
                    $this->createSpicesProducts($category);
                    break;
                case 'jambiyas':
                    $this->createJambiyaProducts($category);
                    break;
                case 'jewelry':
                    $this->createJewelryProducts($category);
                    break;
                case 'fashion':
                    $this->createFashionProducts($category);
                    break;
            }
        }
    }

    private function createCoffeeProducts($category)
    {
        $p1 = Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Haraz Premium AA', 'ar' => 'حراز بريميوم AA'],
            'slug' => 'haraz-premium-aa',
            'description' => ['en' => 'Grown at 2200m altitude. Notes of dried fruit and chocolate.', 'ar' => 'مزروع على ارتفاع 2200 متر. إيحاءات الفواكه المجففة والشوكولاتة.'],
            'base_price' => 25.00,
            'sku' => 'COF-HAR-001',
            'stock' => 100,
            'is_active' => true,
            'is_featured' => true,
            'images' => ['products/coffee1.jpg'],
        ]);

        ProductVariant::create(['product_id' => $p1->id, 'size' => '250g', 'sku' => 'COF-HAR-001-250', 'price_modifier' => 0, 'stock' => 50]);
        ProductVariant::create(['product_id' => $p1->id, 'size' => '500g', 'sku' => 'COF-HAR-001-500', 'price_modifier' => 22.00, 'stock' => 30]); // Total 47
        ProductVariant::create(['product_id' => $p1->id, 'size' => '1kg', 'sku' => 'COF-HAR-001-1KG', 'price_modifier' => 65.00, 'stock' => 20]); // Total 90

        $p2 = Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Matari Classic', 'ar' => 'مطري كلاسيك'],
            'description' => ['en' => 'The famous Bani Matar coffee. Citrusy and bright.', 'ar' => 'قهوة بني مطر الشهيرة. حمضية ومشرقة.'],
            'base_price' => 28.00,
            'sku' => 'COF-MAT-001',
            'stock' => 80,
            'is_active' => true,
            'images' => ['products/coffee2.jpg'],
        ]);
        
        ProductVariant::create(['product_id' => $p2->id, 'size' => '250g', 'sku' => 'COF-MAT-250', 'price_modifier' => 0, 'stock' => 40]);
        ProductVariant::create(['product_id' => $p2->id, 'size' => '500g', 'sku' => 'COF-MAT-500', 'price_modifier' => 25.00, 'stock' => 40]);
    }

    private function createHoneyProducts($category)
    {
        $p = Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Royal Sidr Honey', 'ar' => 'عسل السدر الملكي'],
            'description' => ['en' => 'The rarest and most potent honey in the world.', 'ar' => 'أندر وأقوى عسل في العالم.'],
            'base_price' => 80.00,
            'sku' => 'HON-SID-001',
            'stock' => 50,
            'is_active' => true,
            'is_featured' => true,
            'images' => ['products/honey1.jpg'],
        ]);

        ProductVariant::create(['product_id' => $p->id, 'size' => '250g', 'sku' => 'HON-SID-250', 'price_modifier' => 0, 'stock' => 20]);
        ProductVariant::create(['product_id' => $p->id, 'size' => '500g', 'sku' => 'HON-SID-500', 'price_modifier' => 70.00, 'stock' => 20]); // Total 150
        ProductVariant::create(['product_id' => $p->id, 'size' => '1kg', 'sku' => 'HON-SID-1KG', 'price_modifier' => 200.00, 'stock' => 10]); // Total 280
    }

    private function createSpicesProducts($category)
    {
        $p = Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Hawaij (Soup Space)', 'ar' => 'حوايج (بهارات الشوربة)'],
            'description' => ['en' => 'Essential Yemeni spice mix for soups and stews.', 'ar' => 'خليط بهارات يمني أساسي للشوربات واليخنات.'],
            'base_price' => 8.00,
            'sku' => 'SPC-HAW-001',
            'stock' => 200,
            'is_active' => true,
            'images' => ['products/spices1.jpg'],
        ]);
        
        ProductVariant::create(['product_id' => $p->id, 'size' => '100g', 'sku' => 'SPC-HAW-100', 'price_modifier' => 0, 'stock' => 100]);
        ProductVariant::create(['product_id' => $p->id, 'size' => '250g', 'sku' => 'SPC-HAW-250', 'price_modifier' => 10.00, 'stock' => 100]);
    }

    private function createJambiyaProducts($category)
    {
         Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Antique Asib Jambiya', 'ar' => 'جنبية عسيب أثرية'],
            'description' => ['en' => 'Authentic antique blade with a meticulously crafted rhino-horn style handle (synthetic).', 'ar' => 'نصل أثري أصلي مع مقبض مصنوع بدقة.'],
            'base_price' => 450.00,
            'sku' => 'JAM-ANT-001',
            'stock' => 5,
            'is_active' => true,
            'is_featured' => true,
            'images' => ['products/jambiya1.jpg'],
        ]);
    }

    private function createJewelryProducts($category)
    {
        $p = Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Yemeni Agate Ring (Aqeeq)', 'ar' => 'خاتم عقيق يمني'],
            'description' => ['en' => 'Sterling silver ring with a genuine dark red Yemeni Agate stone.', 'ar' => 'خاتم فضة استرليني مع حجر عقيق يمني أحمر غامق أصلي.'],
            'base_price' => 120.00,
            'sku' => 'JWL-RNG-001',
            'stock' => 15,
            'is_active' => true,
            'images' => ['products/ring1.jpg'],
        ]);

        ProductVariant::create(['product_id' => $p->id, 'size' => 'US 8', 'sku' => 'JWL-RNG-8', 'price_modifier' => 0, 'stock' => 5]);
        ProductVariant::create(['product_id' => $p->id, 'size' => 'US 9', 'sku' => 'JWL-RNG-9', 'price_modifier' => 0, 'stock' => 5]);
        ProductVariant::create(['product_id' => $p->id, 'size' => 'US 10', 'sku' => 'JWL-RNG-10', 'price_modifier' => 0, 'stock' => 5]);
    }

    private function createFashionProducts($category)
    {
        $p = Product::create([
            'category_id' => $category->id,
            'name' => ['en' => 'Sanani Dress', 'ar' => 'فستان صنعاني'],
            'description' => ['en' => 'Traditional dress worn by women in Sana\'a, featuring intricate embroidery.', 'ar' => 'فستان تقليدي ترتديه النساء في صنعاء، يتميز بتطريز دقيق.'],
            'base_price' => 150.00,
            'sku' => 'FSH-DRS-001',
            'stock' => 20,
            'is_active' => true,
            'is_featured' => true,
            'images' => ['products/dress1.jpg'],
        ]);

        // Colors and Sizes
        $variants = [
            ['size' => 'S', 'color' => '#FF0000', 'sku_s' => 'S-RED'],
            ['size' => 'M', 'color' => '#FF0000', 'sku_s' => 'M-RED'],
            ['size' => 'L', 'color' => '#FF0000', 'sku_s' => 'L-RED'],
            ['size' => 'S', 'color' => '#008000', 'sku_s' => 'S-GRN'],
            ['size' => 'M', 'color' => '#008000', 'sku_s' => 'M-GRN'],
        ];

        foreach ($variants as $v) {
            ProductVariant::create([
                'product_id' => $p->id,
                'size' => $v['size'],
                'color_code' => $v['color'],
                'sku' => 'FSH-DRS-' . $v['sku_s'],
                'price_modifier' => 0,
                'stock' => 4,
            ]);
        }
    }
}
