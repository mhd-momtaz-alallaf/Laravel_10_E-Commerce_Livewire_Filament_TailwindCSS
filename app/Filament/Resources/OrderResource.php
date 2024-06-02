<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag'; // modify the icon to be 'shopping-bag' icon.

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([ // the first group has columnSpan(2).
                    Section::make('Product Information')->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')  // This will attach the order to a user, 'user' is the name of the relation in the Order model, 'name' is to show only the name of the users to select one of them.
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('payment_method')
                            ->options([
                                'stripe' => 'Stripe', // on the left database field, on the right the text that will show in the form.
                                'cod' => 'Cash on Delivery'
                            ])
                            ->required(),

                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending', // on the left database field, on the right the text that will show in the form.
                                'paid' => 'Paid',
                                'failed' => 'Failed'
                            ])
                            ->default('pending')
                            ->required(),

                        ToggleButtons::make('status')
                            ->options([
                                'new' => 'New', // on the left database field, on the right the text that will show in the form.
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'canceled' => 'Canceled',
                            ])
                            ->colors([
                                'new' => 'info', // on the left database field, on the right the wanted filament colors.
                                'processing' => 'warning',
                                'shipped' => 'success',
                                'delivered' => 'success',
                                'canceled' => 'danger',
                            ])
                            ->icons([
                                'new' => 'heroicon-m-sparkles', // on the left database field, on the right the wanted icons.
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-m-truck',
                                'delivered' => 'heroicon-m-check-badge',
                                'canceled' => 'heroicon-m-x-circle',
                            ])
                            ->inline()
                            ->default('new')
                            ->required(),

                        Select::make('currency')
                            ->options([
                                'usd' => 'USD', // on the left database field, on the right the text that will show in the form.
                                'eur' => 'EUR',
                                'sp' => 'SP'
                            ])
                            ->default('usd')
                            ->required(),

                        Select::make('shipping_method')
                            ->options([
                                'dhl' => 'Dhl', // on the left database field, on the right the text that will show in the form.
                                'fedex' => 'Fedex', 
                                'usps' => 'USPS'
                            ]),

                        Textarea::make('notes')
                            ->columnSpanFull(), // to take the whole screen width.
                    ])->columns(2), // to align each two fields together as 2 columns. 
                ])->columnSpanFull(), // to take the whole screen width.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
