<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            
            Stat::make('Total Orders', Order::count())->description('All time'),
            Stat::make('Total Sales', '$' . Order::sum('total_amount')),
            Stat::make('New Users', User::whereDate('created_at', today())->count()),
            Stat::make('Available Products', Product::count()),
       
    ];
    }
}
