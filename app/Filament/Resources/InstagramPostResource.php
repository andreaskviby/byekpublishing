<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstagramPostResource\Pages;
use App\Filament\Resources\InstagramPostResource\RelationManagers;
use App\Models\InstagramPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstagramPostResource extends Resource
{
    protected static ?string $model = InstagramPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('instagram_id')
                    ->required(),
                Forms\Components\Textarea::make('caption')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('media_type')
                    ->required(),
                Forms\Components\TextInput::make('media_url')
                    ->required(),
                Forms\Components\TextInput::make('permalink')
                    ->required(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->required(),
                Forms\Components\TextInput::make('like_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('comments_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instagram_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('media_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('media_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permalink')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('like_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListInstagramPosts::route('/'),
            'create' => Pages\CreateInstagramPost::route('/create'),
            'edit' => Pages\EditInstagramPost::route('/{record}/edit'),
        ];
    }
}
