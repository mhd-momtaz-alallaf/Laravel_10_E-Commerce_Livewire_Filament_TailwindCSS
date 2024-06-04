<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager // // this OrdersRelationManager class is created by the command "php artisan make:filament-relation-manager UserResource orders id", 'UserResource' is the owner of the relationship, 'orders' is the relation name in the User model, 'id' is a column of the Order model that will be used to identify the orders of the user.
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // the form body is deleted because the orders relation is only for viewing the orders of a specific user, orders creating is available in OrderResource Only.
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Order Id')
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
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(), // the CreateAction is hided because the orders relation is only for viewing the orders of a specific user.
            ])
            ->actions([
                Action::make('View Order') // Creating a Custom Action to View the detailed Order of the User.
                    ->url(fn (Order $order): string => OrderResource::getUrl('view', ['record' => $order])) // getting the OrderResource 'view' url of the passed $order.
                    ->color('info') // changing the color to info.
                    ->icon('heroicon-o-eye'), // changing the icon to 'eye'.

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
