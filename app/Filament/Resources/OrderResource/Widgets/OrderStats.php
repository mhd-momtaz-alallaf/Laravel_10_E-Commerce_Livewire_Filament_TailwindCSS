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
            Stat::make('New Orders', Order::query()->where('status','new')->count()), // This Widget is for getting the new orders count and show it as a card in the orders list page.

            Stat::make('Processing Orders', Order::query()->where('status','processing')->count()), // This Widget is for getting the processing orders count and show it as a card in the orders list page.

            Stat::make('Shipped Orders', Order::query()->where('status','shipped')->count()), // This Widget is for getting the shipped orders count and show it as a card in the orders list page.

            Stat::make('Average Price', Number::currency(Order::query()->avg('grand_total'), 'USD')), // This Widget is for getting the average price of all the orders.
        ];
    }
}
