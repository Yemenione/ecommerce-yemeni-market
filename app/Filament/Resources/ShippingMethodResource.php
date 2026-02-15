<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingMethodResource\Pages;
use App\Models\ShippingMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShippingMethodResource extends Resource
{
    protected static ?string $model = ShippingMethod::class;

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getModelLabel(): string
    {
        return __('Shipping Method');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Shipping Methods');
    }

    public static function getNavigationLabel(): string
    {
        return __('Shipping');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Forms\Components\Select::make('zone')
                    ->label(__('Zone'))
                    ->options([
                        'france' => __('France'),
                        'germany' => __('Germany'),
                        'europe' => __('Rest of Europe'),
                        'world' => __('World'),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->label(__('Price'))
                    ->required()
                    ->prefix('€'),
                Forms\Components\TextInput::make('min_order_amount')
                    ->label(__('Free Shipping Above'))
                    ->numeric()
                    ->prefix('€'),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('Active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('zone')
                    ->label(__('Zone'))
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('min_order_amount')
                    ->label(__('Free Above'))
                    ->money('EUR'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListShippingMethods::route('/'),
            'create' => Pages\CreateShippingMethod::route('/create'),
            'edit' => Pages\EditShippingMethod::route('/{record}/edit'),
        ];
    }
}
