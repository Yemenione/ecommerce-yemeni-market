<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('dashboard')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                \Filament\SpatieLaravelTranslatablePlugin::make()->defaultLocales(['en', 'ar', 'fr', 'de', 'es', 'it', 'nl', 'tr']),

            ])
            ->brandName(fn () => \App\Models\GeneralSetting::first()?->site_name ?? 'Yemeni Market')
            ->brandLogo(fn () => ($logo = \App\Models\GeneralSetting::first()?->logo) ? asset('storage/' . $logo) : null)
            ->brandLogoHeight('3rem')
            ->colors([
                'primary' => '#0088cc',
            ])
            ->renderHook(
                'panels::sidebar.footer',
                fn (): string => '<div class="px-6 py-4 text-xs text-center text-gray-400 dark:text-gray-500">Powered by <a href="https://www.websmartee.com" target="_blank" class="font-bold hover:text-primary-500">Web SmarTee</a></div>',
            );
    }
}
