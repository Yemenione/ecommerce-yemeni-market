<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LegalSettings extends Settings
{
    public ?string $terms_of_service;
    public ?string $privacy_policy;
    public ?string $about_us;

    public static function group(): string
    {
        return 'legal';
    }
}
