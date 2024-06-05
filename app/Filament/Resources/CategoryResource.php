<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Schema;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag'; // modify the icon to be 'tag' icon.

    protected static ?int $navigationSort = 3; // This property will make the Categories Section is the Third element in the admin navigation menu.

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Grid::make()
                        ->Schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true) // a livewire method to track the changes of the name field (for slug auto creating), "onBlur: true" is for apply the changes on the slug just after we click outside the name field.
                                ->afterStateUpdated(fn (string $operation, $state , Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null), // if we in the create page then set the filament 'slug' field with "Str::slug($state)", this will make a slug from the given state string.

                            TextInput::make('slug')
                                ->required()
                                ->disabled() // disabled because the slug is auto generated field.
                                ->dehydrated()
                                ->maxLength(255)
                                ->unique(Category::class, 'slug', ignoreRecord: true), // (ignoreRecord: true) is for ignore the unique check when Editing.
                        ]),

                    FileUpload::make('image') // to upload the category image, to show the image correctly, use this line "php artisan storage:link", then change the app name with the correct domain name in the .env file.
                        ->image()
                        ->directory('categories'),

                    Toggle::make('is_active') // to make a switch button. 
                        ->required()
                        ->default(true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image'), // to show the image correctly, use this line "php artisan storage:link", then change the app name with the correct domain name in the .env file.

                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // to hide this filed from the table and show it when needed.

                Tables\Columns\TextColumn::make('updated_at')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
