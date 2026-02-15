<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class DefaultBannersSeeder extends Seeder
{
    public function run()
    {
        // 1. Authentic Treasures Banner
        Banner::updateOrCreate(
            ['headline->en' => 'Authentic Treasures from Yemen'],
            [
                'image' => 'categories/honey.png', // Found in storage/app/public/categories/honey.png
                'pre_title' => ['en' => 'Collection Exclusive', 'fr' => 'Collection Exclusive', 'ar' => 'مجموعة حصرية'],
                'headline' => ['en' => 'Authentic Treasures from Yemen', 'fr' => 'Trésors Authentiques du Yémen', 'ar' => 'كنوز أصيلة من اليمن'],
                'subheadline' => ['en' => "Experience the world's finest Sidr honey.", 'fr' => "Découvrez le miel de Sidr le plus pur au monde.", 'ar' => "جرب أجود أنواع عسل السدر في العالم."],
                'cta_text' => ['en' => 'Shop Now', 'fr' => 'Acheter Maintenant', 'ar' => 'تسوق الآن'],
                'cta_url' => route('shop'),
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // 2. Harazi Heritage Banner
        Banner::updateOrCreate(
            ['headline->en' => 'Ancient Harazi Heritage'],
            [
                'image' => 'categories/coffee.png', // Found in storage/app/public/categories/coffee.png
                'pre_title' => ['en' => 'Collection Exclusive', 'fr' => 'Collection Exclusive', 'ar' => 'مجموعة حصرية'],
                'headline' => ['en' => 'Ancient Harazi Heritage', 'fr' => 'Héritage Ancien de Harazi', 'ar' => 'تراث حرازي قديم'],
                'subheadline' => ['en' => "Discover the original Mocha coffee ritual.", 'fr' => "Découvrez le rituel original du café Mocha.", 'ar' => "اكتشف الطقوس الأصلية لقهوة موكا."],
                'cta_text' => ['en' => 'Shop Now', 'fr' => 'Acheter Maintenant', 'ar' => 'تسوق الآن'],
                'cta_url' => route('shop'),
                'video_url' => '#', // Placeholder for video
                'is_active' => true,
                'sort_order' => 2,
            ]
        );
    }
}
