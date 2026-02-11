<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Sales', '€' . number_format(Order::where('status', '!=', 'cancelled')->sum('total_eur'), 2)),
            Stat::make('New Orders', Order::where('status', 'pending')->count()),
            Stat::make('Processing Orders', Order::where('status', 'processing')->count()),
        ];
    }
}
