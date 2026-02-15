<?php

namespace Database\Seeders;

use App\Models\MarketingTemplate;
use Illuminate\Database\Seeder;

class MarketingTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Welcome to Yemeni Market (Premium)',
                'subject' => 'Discover the Essence of Arabia 🇾🇪✨',
                'type' => 'newsletter',
                'content' => '
<div style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #1a1a1a; padding: 40px 20px; text-align: center;">
        <h1 style="color: #D4AF37; margin: 0; font-size: 28px; letter-spacing: 2px;">YEMENI MARKET</h1>
        <p style="color: #888888; font-size: 12px; text-transform: uppercase; letter-spacing: 4px; margin-top: 10px;">Authentic & Luxury</p>
    </div>
    
    <div style="padding: 40px 30px; color: #333333; line-height: 1.8;">
        <h2 style="color: #1a1a1a; font-size: 24px; margin-bottom: 20px;">Welcome to a World of Heritage</h2>
        
        <p>Dear Valued Member,</p>
        
        <p>We are honored to welcome you to <strong>Yemeni Market</strong>, your gateway to the finest treasures of Yemen.</p>
        
        <p>From the sun-drenched terraced hills of Haraz where our premium coffee grows, to the ancient souqs of Sana\'a where artisans craft silver masterpieces, every product we offer tells a story of tradition, resilience, and unparalleled quality.</p>
        
        <div style="margin: 30px 0; border-left: 4px solid #D4AF37; padding-left: 20px; font-style: italic; color: #555;">
            "Quality is never an accident. It is always the result of high intention, sincere effort, intelligent direction and skillful execution."
        </div>
        
        <p>As a subscriber, you now have exclusive access to:</p>
        <ul style="list-style-type: none; padding: 0;">
            <li style="padding: 10px 0; border-bottom: 1px solid #eee;">✨ Early access to limited-edition collections</li>
            <li style="padding: 10px 0; border-bottom: 1px solid #eee;">🍯 Premium Sidr Honey harvests</li>
            <li style="padding: 10px 0; border-bottom: 1px solid #eee;">☕ Rare blends of Yemeni Coffee</li>
        </ul>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="' . url('/') . '" style="background-color: #D4AF37; color: #1a1a1a; padding: 15px 30px; text-decoration: none; border-radius: 4px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; display: inline-block;">Start Exploring</a>
        </div>
    </div>
    
    <div style="background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #888888; border-top: 1px solid #eeeeee;">
        <p>&copy; ' . date('Y') . ' Yemeni Market. All rights reserved.</p>
        <p>Luxury from the heart of Arabia.</p>
    </div>
</div>
                ',
            ],
            [
                'name' => 'Exclusive Eid Offer',
                'subject' => '🌙 An Exclusive Gift for You this Eid',
                'type' => 'promotional',
                'content' => '
<div style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #0f172a; padding: 40px 20px; text-align: center; background-image: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <h1 style="color: #D4AF37; margin: 0; font-size: 28px; letter-spacing: 2px;">EID MUBARAK</h1>
        <p style="color: #cbd5e1; font-size: 14px; margin-top: 10px;">Celebration of Tradition</p>
    </div>
    
    <div style="padding: 40px 30px; color: #333333; line-height: 1.8;">
        <h2 style="color: #1a1a1a; font-size: 22px; margin-bottom: 20px; text-align: center;">Elevate Your Celebration</h2>
        
        <p>Celebrate this Eid with the timeless elegance of Yemeni craftsmanship. Whether it is the aroma of our <strong>Royal Bakhoor</strong> or the taste of our <strong>Premium Honey</strong>, make this occasion unforgettable.</p>
        
        <div style="background-color: #fffbeb; border: 1px solid #fcd34d; border-radius: 8px; padding: 20px; margin: 30px 0; text-align: center;">
            <p style="margin: 0; color: #92400e; font-size: 14px; text-transform: uppercase; font-weight: bold;">Use Code</p>
            <div style="font-size: 32px; font-weight: bold; color: #b45309; margin: 10px 0; letter-spacing: 2px;">EID2026</div>
            <p style="margin: 0; color: #92400e;">For 20% OFF your entire order</p>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="' . url('/shop') . '" style="background-color: #1a1a1a; color: #D4AF37; padding: 15px 30px; text-decoration: none; border-radius: 4px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; display: inline-block;">Shop The Collection</a>
        </div>
    </div>
    
    <div style="background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #888888; border-top: 1px solid #eeeeee;">
        <p>Offer valid until the end of the month.</p>
        <p>&copy; ' . date('Y') . ' Yemeni Market.</p>
    </div>
</div>
                ',
            ],
            [
                'name' => 'New Arrival: Haraz Coffee',
                'subject' => '☕ The Coffee of Kings has Arrived',
                'type' => 'update',
                'content' => '
<div style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #3e2723; padding: 40px 20px; text-align: center;">
        <h1 style="color: #D4AF37; margin: 0; font-size: 28px; letter-spacing: 2px;">HARAZ ORIGINS</h1>
        <p style="color: #a1887f; font-size: 12px; text-transform: uppercase; letter-spacing: 4px; margin-top: 10px;">Single Origin • Sun Dried</p>
    </div>
    
    <div style="padding: 40px 30px; color: #333333; line-height: 1.8;">
        <h2 style="color: #3e2723; font-size: 24px; margin-bottom: 20px;">Taste the History</h2>
        
        <p>We are thrilled to announce the arrival of our latest batch of <strong>Haraz AA</strong> coffee cherries. Grown at altitudes above 2000 meters, this coffee is known for its complex profile of dried fruit, chocolate, and spices.</p>
        
        <p>This is not just coffee; it is a legacy cultivated by generations of farmers in the misty mountains of Yemen.</p>
        
        <div style="margin: 30px 0;">
            <img src="' . asset('images/coffee-beans.jpg') . '" alt="Haraz Coffee" style="width: 100%; border-radius: 4px;">
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="' . url('/category/coffee') . '" style="background-color: #3e2723; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 4px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; display: inline-block;">Order Now</a>
        </div>
    </div>
    
    <div style="background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #888888; border-top: 1px solid #eeeeee;">
        <p>&copy; ' . date('Y') . ' Yemeni Market.</p>
    </div>
</div>
                ',
            ],
        ];

        foreach ($templates as $template) {
            MarketingTemplate::create($template);
        }
    }
}
