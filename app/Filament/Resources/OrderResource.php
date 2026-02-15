<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $navigationLabel = null;

    public static function getModelLabel(): string
    {
        return __('Order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Orders');
    }

    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'user.name'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('Customer'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('total_eur')
                    ->label(__('Total'))
                    ->numeric()
                    ->required()
                    ->prefix('€'),
                Forms\Components\Select::make('status')
                    ->label(__('Status'))
                    ->options(\App\Enums\OrderStatus::class)
                    ->required()
                    ->default(\App\Enums\OrderStatus::Pending),
                Forms\Components\TextInput::make('payment_method')
                    ->label(__('Payment Method')),
                Forms\Components\TextInput::make('tracking_number')
                    ->label(__('Tracking Number')),
                Forms\Components\KeyValue::make('shipping_address')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('Order ID'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Customer'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_eur')
                    ->label(__('Total'))
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(\App\Enums\OrderStatus::class),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('print_invoice')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Order $record) => route('orders.invoice', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('email_invoice')
                    ->label(__('Email Invoice'))
                    ->icon('heroicon-o-envelope')
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function (Order $record) {
                        \Illuminate\Support\Facades\Mail::to($record->shipping_address['email'])
                            ->send(new \App\Mail\OrderPlaced($record));
                        
                        \Filament\Notifications\Notification::make()
                            ->title(__('Invoice Sent'))
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
