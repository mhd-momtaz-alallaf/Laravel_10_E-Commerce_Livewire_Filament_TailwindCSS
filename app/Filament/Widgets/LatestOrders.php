<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget // this Widget is to show the latest 5 orders and it will be used in the dashboard.
{
    protected int | string | array $columnSpan = 'full'; // This property allows the table to take the full width of the screen.

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery()) // Getting the Data from the OrderResource.
                ->defaultPaginationPageOption(5) // setting the pagination to 5 records per page.
                ->defaultSort('created_at', 'desc') // sorting by 'created_at' field.   
            ->columns([
                TextColumn::make('id')
                    ->label('Order Id')
                    ->searchable(),

                TextColumn::make('user.name') // getting the name of the user using the 'user' relation in the Order Model.
                    ->searchable(),

                TextColumn::make('grand_total')
                    ->money('USD'),

                TextColumn::make('status')
                    ->badge() // this will make the status showing as badge form.
                    ->color(fn (string $state):string => match($state){
                        'new' => 'info', // on the left database field, on the right the wanted filament colors.
                        'processing'=> 'warning',
                        'shipped'=> 'success',
                        'delivered'=> 'success',
                        'canceled'=> 'danger',
                    })
                    ->icon(fn (string $state):string => match($state){
                        'new' => 'heroicon-m-sparkles', // on the left database field, on the right the wanted icons.
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-badge',
                        'canceled' => 'heroicon-m-x-circle',
                    })
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('payment_status')
                    ->badge() // this will make the payment_status showing as badge form.
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Ordering Date')
                    ->dateTime(),
            ])
            ->actions([
                Action::make('View Order') // Creating a Custom Action to View the detailed Order of the User.
                    ->url(fn (Order $order): string => OrderResource::getUrl('view', ['record' => $order])) // getting the OrderResource 'view' url of the passed $order.
                    ->icon('heroicon-o-eye'), // changing the icon to 'eye'.
            ]);
    }
}
