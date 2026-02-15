<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->migrator->add('general.top_bar_announcements', [
            [
                'icon' => 'truck',
                'text' => ['en' => 'Free Shipping on orders over €100', 'ar' => 'شحن مجاني للطلبات فوق 100 يورو', 'fr' => 'Livraison gratuite à partir de 100 €']
            ],
            [
                'icon' => 'bolt',
                'text' => ['en' => 'Fast Delivery', 'ar' => 'توصيل سريع', 'fr' => 'Livraison rapide']
            ],
            [
                'icon' => 'shield-check',
                'text' => ['en' => 'Secure Payment Stripe & COD', 'ar' => 'دفع آمن عبر Stripe والدفع عند الاستلام', 'fr' => 'Paiement sécurisé Stripe & COD']
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->migrator->delete('general.top_bar_announcements');
    }
};
