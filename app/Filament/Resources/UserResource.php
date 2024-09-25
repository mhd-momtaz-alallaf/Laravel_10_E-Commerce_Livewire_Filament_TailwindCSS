<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1; // This property will make the Users Section is the first element in the admin navigation menu.

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name') // making the name field.
                    ->required(),

                Forms\Components\TextInput::make('email') // making the email field.
                    ->label('Email Address')
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->required(),

                Forms\Components\DatePicker::make('email_verified_at') // making the email_verified_at field.
                    ->label('Email Verified At')
                    ->default(now()),

                Forms\Components\TextInput::make('password') // making the password field.
                    ->password()
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord), // to make this field required only in create user page.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name') // the name field.
                    ->searchable(),

                Tables\Columns\TextColumn::make('email') // the email field.
                    ->searchable(),

                Tables\Columns\TextColumn::make('email_verified_at') // the email_verified_at field.
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at') // the created_at field.
                    ->dateTime()
                    ->sortable(),
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
            OrdersRelationManager::class, // Registering the OrdersRelationManager in the UserResource, this will show the Orders section below the User Form.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array // this function will enable the global search of users by multiple attributes (name, email) from the dashboard.
    {
        return ['name', 'email'];
    }
}
