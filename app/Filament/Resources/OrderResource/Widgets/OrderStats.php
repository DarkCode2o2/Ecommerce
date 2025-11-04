<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count())->icon('heroicon-m-sparkles'),
            Stat::make('On Processing', Order::query()->where('status', 'processing')->count())->icon('heroicon-m-arrow-path'),
            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count())->icon('heroicon-m-truck'),
            Stat::make('Average Price', Number::currency(Order::query()->avg('grand_total')))->icon('heroicon-m-banknotes')
        ];
    }
}
