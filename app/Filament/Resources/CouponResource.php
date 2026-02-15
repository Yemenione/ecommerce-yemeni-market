<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $navigationLabel = null;
    protected static ?string $navigationGroup = null;

    public static function getModelLabel(): string
    {
        return __('Coupon');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Coupons');
    }

    public static function getNavigationLabel(): string
    {
        return __('Coupons');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Marketing');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->options([
                        'fixed' => __('Fixed Amount (€)'),
                        'percent' => __('Percentage (%)'),
                    ])
                    ->required()
                    ->default('fixed')
                    ->label(__('Type')),
                Forms\Components\TextInput::make('value')
                    ->numeric()
                    ->required()
                    ->label(__('Value')),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label(__('Expires At')),
                Forms\Components\TextInput::make('usage_limit')
                    ->numeric()
                    ->label(__('Usage Limit')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'fixed',
                        'warning' => 'percent',
                    ]),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('Value')),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label(__('Expires At'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('usage_limit')
                    ->label(__('Limit')),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
