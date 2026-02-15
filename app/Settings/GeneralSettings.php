<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public ?string $logo;
    public string $tagline;
    public string $brand_color;
    public string $support_email;
    public string $whatsapp_number;
    public string $currency; // EUR
    public float $vat_percentage;
    public array $social_media_links;
    public array $top_bar_announcements;

    public static function group(): string
    {
        return 'general';
    }
}
