<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PaymentSettings extends Settings
{
    public bool $cod_enabled;
    public bool $stripe_enabled;
    public ?string $stripe_public_key;
    public ?string $stripe_secret_key;

    public static function group(): string
    {
        return 'payment';
    }
}
