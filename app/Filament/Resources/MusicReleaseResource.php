<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicReleaseResource\Pages;
use App\Filament\Resources\MusicReleaseResource\RelationManagers;
use App\Models\MusicRelease;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MusicReleaseResource extends Resource
{
    protected static ?string $model = MusicRelease::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('artist_name')
                    ->required(),
                Forms\Components\TextInput::make('album_cover'),
                Forms\Components\TextInput::make('release_type')
                    ->required(),
                Forms\Components\DatePicker::make('release_date')
                    ->required(),
                Forms\Components\TextInput::make('spotify_url'),
                Forms\Components\TextInput::make('apple_music_url'),
                Forms\Components\TextInput::make('youtube_music_url'),
                Forms\Components\TextInput::make('distrokid_url'),
                Forms\Components\Toggle::make('is_published')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('artist_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('album_cover')
                    ->searchable(),
                Tables\Columns\TextColumn::make('release_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('release_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('spotify_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apple_music_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('youtube_music_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('distrokid_url')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
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
            'index' => Pages\ListMusicReleases::route('/'),
            'create' => Pages\CreateMusicRelease::route('/create'),
            'edit' => Pages\EditMusicRelease::route('/{record}/edit'),
        ];
    }
}
