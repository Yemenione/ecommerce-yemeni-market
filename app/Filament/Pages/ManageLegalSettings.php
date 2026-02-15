<?php

namespace App\Filament\Pages;

use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Settings\LegalSettings;
use Filament\Forms;
use Filament\Pages\SettingsPage;

class ManageLegalSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static string $settings = LegalSettings::class;

    protected static ?string $navigationGroup = 'Paramètres';
    protected static ?string $navigationLabel = 'Légal';
    protected static ?string $title = 'Contenu Légal';

    protected static string $view = 'filament.pages.manage-legal-settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Tabs::make('Mentions Légales')
                    ->tabs([
                        Components\Tabs\Tab::make('Conditions Générales')
                            ->schema([
                                Components\RichEditor::make('terms_of_service')
                                    ->label('Conditions Générales de Vente (CGV)')
                                    ->columnSpanFull(),
                            ]),
                        Components\Tabs\Tab::make('Politique de Confidentialité')
                            ->schema([
                                Components\RichEditor::make('privacy_policy')
                                    ->label('Politique de Confidentialité')
                                    ->columnSpanFull(),
                            ]),
                        Components\Tabs\Tab::make('À Propos')
                            ->schema([
                                Components\RichEditor::make('about_us')
                                    ->label('À Propos de Nous')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
