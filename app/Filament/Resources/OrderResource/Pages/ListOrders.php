<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array // Registering the OrderStats in the ListOrders file to show the widgets in the Filament Order page.
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): array // This function is to show filtering Tabs by the order status.
    {
        return [
            null => Tab::make('All'), // to show all orders.
            'new' => Tab::make()->query(fn ($query) => $query->where('status','new')), // to show the new orders.
            'processing' => Tab::make()->query(fn ($query) => $query->where('status','processing')), // to show the processing orders.
            'shipped' => Tab::make()->query(fn ($query) => $query->where('status','shipped')), // to show the shipped orders.
            'delivered' => Tab::make()->query(fn ($query) => $query->where('status','delivered')), // to show the delivered orders.
            'canceled' => Tab::make()->query(fn ($query) => $query->where('status','canceled')), // to show the canceled orders.
        ];
    }
}
