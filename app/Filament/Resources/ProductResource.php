<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2'; // modify the icon to be 'squares-2x2' icon.

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ // the form container have total 3 columns.
                Group::make()->schema([ // the first group has columnSpan(2).
                    Section::make('Product Information')->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true) // a livewire method to track the changes of the name field (for slug auto creating), "onBlur: true" it will send the request just after we click outside the name field.
                            ->afterStateUpdated(fn (string $operation, $state , Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null), // if we in the create page then set the filament 'slug' field with "Str::slug($state)", this will make a slug from the given state string.

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated() // to make passing the slug field is possible, because ->disabled() doesn't sends the slug with the product data when creating. 
                            ->unique(Product::class, 'slug', ignoreRecord: true), // (ignoreRecord: true) is for ignore the unique check when Editing.

                        MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products'),
                    ])->columns(2),

                    Section::make('Images')->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([ // the second group has columnSpan(1).
                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('USD'),
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload() // to load all the categories from the database.
                            ->relationship('category', 'name'), // This will attach the product to a category, 'category' is the name of the relation in the Product model, 'name' is to show only the name of the categories to select one of them.

                        Select::make('brand_id')
                            ->required()
                            ->searchable()
                            ->preload() // to load all the brands from the database.
                            ->relationship('brand', 'name'), // This will attach the product to a brand, 'brand' is the name of the relation in the Product model, 'name' is to show only the name of the brands to select one of them.
                    ]),

                    Section::make('Status')->schema([
                        Toggle::make('in_stock')
                            ->required()
                            ->default(true),

                        Toggle::make('is_active')
                            ->required()
                            ->default(true),

                        Toggle::make('is_featured')
                            ->required(),

                        Toggle::make('on_sale')
                            ->required(),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
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
                //
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
