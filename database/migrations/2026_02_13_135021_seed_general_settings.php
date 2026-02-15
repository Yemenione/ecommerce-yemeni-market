<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends SettingsMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Yemen Souq Europe');
        $this->migrator->add('general.tagline', 'Authentic Yemeni Products');
        $this->migrator->add('general.brand_color', '#991b1b'); // Red-800
        $this->migrator->add('general.support_email', 'support@yemensouq.eu');
        $this->migrator->add('general.whatsapp_number', '+33123456789');
        $this->migrator->add('general.currency', 'EUR');
        $this->migrator->add('general.vat_percentage', 20.0);
        $this->migrator->add('general.social_media_links', []);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
