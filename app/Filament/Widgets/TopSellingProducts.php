<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Product;

class TopSellingProducts extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()->where('is_featured', true) // approximating top selling as featured for now
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product'),
                Tables\Columns\TextColumn::make('price_eur')
                    ->money('eur')
                    ->label('Price'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock'),
            ]);
    }
}
