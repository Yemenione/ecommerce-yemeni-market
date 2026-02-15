<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketingTemplateResource\Pages;
use App\Filament\Resources\MarketingTemplateResource\RelationManagers;
use App\Models\MarketingTemplate;
use App\Models\NewsletterSubscriber;
use App\Jobs\SendNewsletterJob;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class MarketingTemplateResource extends Resource
{
    protected static ?string $model = MarketingTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('Marketing');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Template Details'))->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('Name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subject')
                        ->label(__('Subject'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->options([
                            'newsletter' => __('Newsletter'),
                            'promotional' => __('Promotional'),
                            'update' => __('Update'),
                        ])
                        ->required()
                        ->default('newsletter'),
                    Forms\Components\RichEditor::make('content')
                        ->label(__('Content'))
                        ->required()
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->colors([
                        'primary' => 'newsletter',
                        'warning' => 'promotional',
                        'success' => 'update',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('send_test')
                    ->label(__('Send Test'))
                    ->icon('heroicon-o-beaker')
                    ->form([
                        Forms\Components\TextInput::make('test_email')
                            ->email()
                            ->required()
                            ->default(auth()->check() ? auth()->user()->email : ''),
                    ])
                    ->action(function (MarketingTemplate $record, array $data) {
                        Mail::send([], [], function ($message) use ($record, $data) {
                            $message->to($data['test_email'])
                                ->subject('[TEST] ' . $record->subject)
                                ->html($record->content);
                        });
                        
                        Notification::make()
                            ->title(__('Test Email Sent'))
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('send_campaign')
                    ->label(__('Send Campaign'))
                    ->icon('heroicon-o-paper-airplane')
                    ->requiresConfirmation()
                    ->modalHeading(__('Send Newsletter Campaign'))
                    ->modalDescription(__('Are you sure you want to send this newsletter to ALL active subscribers? This action cannot be undone.'))
                    ->action(function (MarketingTemplate $record) {
                        $subscribers = NewsletterSubscriber::where('is_active', true)->get();
                        
                        foreach ($subscribers as $subscriber) {
                            SendNewsletterJob::dispatch($subscriber, $record);
                        }
                        
                        Notification::make()
                            ->title(__('Campaign Started'))
                            ->body(__('Emails are being sent in the background to :count subscribers.', ['count' => $subscribers->count()]))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketingTemplates::route('/'),
            'create' => Pages\CreateMarketingTemplate::route('/create'),
            'edit' => Pages\EditMarketingTemplate::route('/{record}/edit'),
        ];
    }
}
