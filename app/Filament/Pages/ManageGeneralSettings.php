<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationLabel = null;
    protected static ?string $title = null;
    protected static ?string $navigationGroup = null;

    public static function getNavigationLabel(): string
    {
        return __('General Settings');
    }

    public function getTitle(): string
    {
        return __('General Settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make(__('Settings'))
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__('General'))
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label(__('Site Name'))
                                    ->required(),
                                Forms\Components\FileUpload::make('logo')
                                    ->label(__('Site Logo'))
                                    ->image()
                                    ->directory('settings')
                                    ->visibility('public')
                                    ->helperText('Upload a premium logo (PNG or SVG recommended).'),
                                Forms\Components\TextInput::make('tagline')
                                    ->label(__('Tagline'))
                                    ->helperText('Appears in the footer and SEO title.'),
                                Forms\Components\ColorPicker::make('brand_color')
                                    ->label(__('Brand Color'))
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('Contact'))
                            ->schema([
                                Forms\Components\TextInput::make('support_email')
                                    ->label(__('Support Email'))
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label(__('WhatsApp Number'))
                                    ->tel(),
                                Forms\Components\Repeater::make('social_media_links')
                                    ->label(__('Social Media Links'))
                                    ->schema([
                                        Forms\Components\Select::make('platform')
                                            ->options([
                                                'facebook' => 'Facebook',
                                                'instagram' => 'Instagram',
                                                'twitter' => 'Twitter',
                                                'tiktok' => 'TikTok',
                                            ])
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('Currency & VAT'))
                            ->schema([
                                Forms\Components\Select::make('currency')
                                    ->options([
                                        'EUR' => 'Euro (EUR)',
                                        'USD' => 'US Dollar (USD)',
                                    ])
                                    ->default('EUR')
                                    ->required(),
                                Forms\Components\TextInput::make('vat_percentage')
                                    ->label(__('VAT Percentage'))
                                    ->numeric()
                                    ->suffix('%')
                                    ->default(20)
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('Email Configuration'))
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('mail_mailer')
                                            ->label('Mailer')
                                            ->options([
                                                'smtp' => 'SMTP',
                                                'log' => 'Log (Testing)',
                                            ])
                                            ->default('log')
                                            ->required(),
                                        Forms\Components\TextInput::make('mail_host')
                                            ->label('SMTP Host')
                                            ->placeholder('smtp.example.com'),
                                        Forms\Components\TextInput::make('mail_port')
                                            ->label('SMTP Port')
                                            ->placeholder('587')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('mail_username')
                                            ->label('SMTP Username'),
                                        Forms\Components\TextInput::make('mail_password')
                                            ->label('SMTP Password')
                                            ->password()
                                            ->revealable(),
                                        Forms\Components\Select::make('mail_encryption')
                                            ->label('Encryption')
                                            ->options([
                                                'tls' => 'TLS',
                                                'ssl' => 'SSL',
                                                'null' => 'None',
                                            ]),
                                        Forms\Components\TextInput::make('mail_from_address')
                                            ->label('From Address')
                                            ->email()
                                            ->placeholder('hello@example.com'),
                                        Forms\Components\TextInput::make('mail_from_name')
                                            ->label('From Name')
                                            ->placeholder('Yemeni Market'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make(__('Top Bar'))
                            ->schema([
                                Forms\Components\Repeater::make('top_bar_announcements')
                                    ->label(__('Announcements'))
                                    ->schema([
                                        Forms\Components\Select::make('icon')
                                            ->options([
                                                'truck' => 'Truck/Shipping',
                                                'bolt' => 'Flash/Fast',
                                                'shield-check' => 'Security/Trust',
                                                'star' => 'Star/Premium',
                                                'tag' => 'Tag/Offer',
                                            ])
                                            ->required(),
                                        Forms\Components\Tabs::make('Announcements Language')
                                            ->tabs([
                                                Forms\Components\Tabs\Tab::make('Arabic')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('text.ar')
                                                            ->label('المحتوى (عربي)')
                                                            ->required(),
                                                    ]),
                                                Forms\Components\Tabs\Tab::make('English')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('text.en')
                                                            ->label('Content (English)')
                                                            ->required(),
                                                    ]),
                                                Forms\Components\Tabs\Tab::make('French')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('text.fr')
                                                            ->label('Contenu (Français)')
                                                            ->required(),
                                                    ]),
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1)
                                    ->default([
                                        [
                                            'icon' => 'truck', 
                                            'text' => [
                                                'ar' => 'شحن مجاني للطلبات فوق 100 يورو',
                                                'en' => 'Free Shipping on orders over €100',
                                                'fr' => 'Livraison gratuite à partir de 100 €'
                                            ]
                                        ],
                                        [
                                            'icon' => 'bolt', 
                                            'text' => [
                                                'ar' => 'توصيل سريع',
                                                'en' => 'Fast Delivery',
                                                'fr' => 'Livraison rapide'
                                            ]
                                        ],
                                    ])
                                    ->helperText('Manage the scrolling messages at the top of the site. Use icons and translations for each language.'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
