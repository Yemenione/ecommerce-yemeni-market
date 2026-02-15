<?php

namespace App\Filament\Pages;

use App\Settings\MailSettings;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageMailSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $settings = MailSettings::class;

    protected static ?string $navigationGroup = 'Paramètres';
    protected static ?string $navigationLabel = 'E-mail (SMTP)';
    protected static ?string $title = 'Paramètres de Messagerie';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Configuration Serveur SMTP')
                    ->description('Configurez vos paramètres d\'envoi d\'e-mails.')
                    ->schema([
                        TextInput::make('mail_host')
                            ->label('Hôte SMTP')
                            ->placeholder('smtp.mailtrap.io')
                            ->required(),
                        TextInput::make('mail_port')
                            ->label('Port SMTP')
                            ->numeric()
                            ->placeholder('2525')
                            ->required(),
                        TextInput::make('mail_username')
                            ->label('Nom d\'utilisateur')
                            ->placeholder('votre-utilisateur'),
                        TextInput::make('mail_password')
                            ->label('Mot de passe')
                            ->password()
                            ->revealable()
                            ->placeholder('votre-mot-de-passe'),
                        Select::make('mail_encryption')
                            ->label('Cryptage')
                            ->options([
                                'tls' => 'TLS',
                                'ssl' => 'SSL',
                                'null' => 'Aucun',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('Identité de l\'Expéditeur')
                    ->schema([
                        TextInput::make('mail_from_address')
                            ->label('Adresse E-mail de l\'expéditeur')
                            ->email()
                            ->required(),
                        TextInput::make('mail_from_name')
                            ->label('Nom de l\'expéditeur')
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
