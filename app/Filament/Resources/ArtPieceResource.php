<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtPieceResource\Pages;
use App\Filament\Resources\ArtPieceResource\RelationManagers;
use App\Models\ArtPiece;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtPieceResource extends Resource
{
    protected static ?string $model = ArtPiece::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(4),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('art')
                    ->visibility('public')
                    ->imageEditor(),
                Forms\Components\TextInput::make('medium'),
                Forms\Components\TextInput::make('dimensions'),
                Forms\Components\TextInput::make('year')
                    ->numeric(),
                Forms\Components\Toggle::make('is_available')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('currency')
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_path'),
                Tables\Columns\TextColumn::make('medium')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dimensions')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
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
            'index' => Pages\ListArtPieces::route('/'),
            'create' => Pages\CreateArtPiece::route('/create'),
            'edit' => Pages\EditArtPiece::route('/{record}/edit'),
        ];
    }
}
