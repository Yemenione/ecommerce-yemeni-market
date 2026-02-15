<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->migrator->add('payment.cod_enabled', true);
        $this->migrator->add('payment.stripe_enabled', false);
        $this->migrator->add('payment.stripe_public_key', null);
        $this->migrator->add('payment.stripe_secret_key', null);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
