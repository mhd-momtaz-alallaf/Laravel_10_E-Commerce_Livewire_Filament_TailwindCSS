<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

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

                    Section::make('Order Items')->schema([ // to associate the order with the orderItems Model
                        Repeater::make('items') //the Repeater is for select multiple products, the 'items' is the relation name in the Order Model.
                            ->relationship() // to trigger the relationship between the order and orderItems.
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')  // This will attach the product to an orderItem, 'product' is the name of the relation in the OrderItem model, 'name' is to show only the name of the products to select one of them.
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->distinct() // to list only the distinct products.
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems() // we can't select the same product if its already selected.
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Set $set) => 
                                        $set('unit_amount', Product::find($state) ?->price ?? 0)) // to set the unit_price automatically after selecting any product, so for the selected product we will find it and get the price or 0. 
                                    ->afterStateUpdated(fn ($state, Set $set) => 
                                        $set('total_amount', Product::find($state) ?->price ?? 0)), // to set the total_price automatically after selecting the quantity of the product, we will set it on two parts, the first part we will set the total_amount for the quantity 1 without any changing, the second part will be handled in the TextInput quantity.

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Set $set, Get $get) => 
                                        $set('total_amount', $state * $get('unit_amount'))), // setting the total_amount automatically after the quantity is changed by multiply the unit_amount with the $state(quantity).

                                TextInput::make('unit_amount')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated() // to make this field able to be inserted in the database after the disabled() method.
                                    ->columnSpan(3),

                                TextInput::make('total_amount')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(3),
                            ])->columns(12),

                            Placeholder::make('grand_total_placeholder') // to show the grand total price of all the OrderItems.
                                ->label('Grand Total')
                                ->content(function (Set $set, Get $get)
                                {
                                    $total = 0;
                                    if(! $repeaters = $get('items')){ // if there is no items in the repeater/s.
                                        return $total; // return total 0.
                                    }
                                    foreach ($repeaters as $key => $repeater){
                                        $total += $get("items.{$key}.total_amount");
                                    }

                                    $set('grand_total', $total); // to set the grand_total field value and save it to the database.
                                    return Number::currency($total,'USD'); // return the total value in 'USD' currency form.
                                }),

                            Hidden::make('grand_total') // this is a hidden field and it will not showing to the users, and to just preparing the 'grand_total' value to change in the 'grand_total_placeholder'.
                                ->default(0),
                    ]),
                ])->columnSpanFull(), // to take the whole screen width.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name') // get the name of the user by the relation name.
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('grand_total') 
                    ->numeric()
                    ->sortable()
                    ->money('USD'),

                TextColumn::make('payment_method') 
                    ->sortable()
                    ->searchable(),

                TextColumn::make('payment_status') 
                    ->sortable()
                    ->searchable(),

                TextColumn::make('currency') 
                    ->sortable()
                    ->searchable(),

                TextColumn::make('shipping_method') 
                    ->sortable()
                    ->searchable(),

                SelectColumn::make('status') // this select is for change the status of the order directly without going to the edit order form.
                    ->options([
                        'new' => 'New', // on the left database field, on the right the text that will show in the table.
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'canceled' => 'Canceled',
                    ])
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // to hide this filed from the table and show it when needed.

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // to hide this filed from the table and show it when needed.
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([ // To combine all the actions in one group.
                    Tables\Actions\ViewAction::make(), // Enable View Action.
                    Tables\Actions\EditAction::make(), // Enable Edit Action.
                    Tables\Actions\DeleteAction::make(), // Enable Delete Action.
                ])
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

    public static function getNavigationBadge(): ?string // This function is for displaying the number of orders on the right of the orders navigation.
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string // This function is for changing color of orders count depending on the number of orders.
    {
        return static::getModel()::count() > 10 ? 'danger' : 'success';
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
