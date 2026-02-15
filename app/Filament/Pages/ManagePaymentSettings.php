<?php

namespace App\Filament\Pages;

use App\Settings\PaymentSettings;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\SettingsPage;

class ManagePaymentSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static string $settings = PaymentSettings::class;

    protected static ?string $navigationGroup = 'Paramètres';
    protected static ?string $navigationLabel = 'Paiement';
    protected static ?string $title = 'Paramètres de Paiement';



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Méthodes de Paiement')
                    ->schema([
                        Toggle::make('cod_enabled')
                            ->label('Paiement à la livraison')
                            ->helperText('Activer le paiement en espèces à la livraison.'),
                        Toggle::make('stripe_enabled')
                            ->label('Paiement par Carte (Stripe)')
                            ->helperText('Activer le paiement par carte bancaire via Stripe.')
                            ->live(),
                    ]),
                Section::make('Configuration Stripe')
                    ->schema([
                        TextInput::make('stripe_public_key')
                            ->label('Clé Publique (Public Key)')
                            ->password()
                            ->revealable()
                            ->required(fn (Get $get) => $get('stripe_enabled'))
                            ->visible(fn (Get $get) => $get('stripe_enabled')),
                        TextInput::make('stripe_secret_key')
                            ->label('Clé Secrète (Secret Key)')
                            ->password()
                            ->revealable()
                            ->required(fn (Get $get) => $get('stripe_enabled'))
                            ->visible(fn (Get $get) => $get('stripe_enabled')),
                    ])
                    ->visible(fn (Get $get) => $get('stripe_enabled')),
            ]);
    }
}
