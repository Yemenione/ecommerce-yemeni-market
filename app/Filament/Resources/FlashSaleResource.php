<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlashSaleResource\Pages;
use App\Models\FlashSale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FlashSaleResource extends Resource
{
    protected static ?string $model = FlashSale::class;

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getModelLabel(): string
    {
        return __('Flash Sale');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Flash Sales');
    }

    public static function getNavigationLabel(): string
    {
        return __('Flash Sales');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Marketing');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label(__('Product'))
                    ->relationship('product', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('discount_percentage')
                    ->label(__('Discount Percentage'))
                    ->numeric()
                    ->required()
                    ->suffix('%')
                    ->maxValue(100),
                Forms\Components\DateTimePicker::make('start_time')
                    ->label(__('Start Time'))
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time')
                    ->label(__('End Time'))
                    ->required()
                    ->after('start_time'),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('Active'))
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label(__('Product'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label(__('Discount'))
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label(__('Start Time'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label(__('End Time'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListFlashSales::route('/'),
            'create' => Pages\CreateFlashSale::route('/create'),
            'edit' => Pages\EditFlashSale::route('/{record}/edit'),
        ];
    }
}
