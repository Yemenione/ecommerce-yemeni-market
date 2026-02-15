<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (class_exists(\App\Settings\GeneralSettings::class)) {
                $settings = app(\App\Settings\GeneralSettings::class);
                \Illuminate\Support\Facades\View::share('settings', $settings);

                // Dynamically set mail from name based on settings
                if ($settings->site_name) {
                    config(['mail.from.name' => $settings->site_name]);
                    config(['app.name' => $settings->site_name]);
                }
                
                // Do NOT override mail.from.address here because Hostinger SMTP requires 
                // the sender address to match the authenticated user (sell@yemenimarket.fr).
                // If we change it to support@yemenimarket.fr, it throws a 553 error.
            }

            \BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch::configureUsing(function (\BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch $switch) {
                $switch
                    ->locales(['en', 'ar', 'fr', 'de', 'es', 'it', 'nl', 'tr']); // also supports a closure
            });
        } catch (\Exception $e) {
            // Settings table might not exist during migration
        }
    }
}
