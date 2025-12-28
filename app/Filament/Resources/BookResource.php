<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(4),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->helperText('Recommended: 150-160 characters')
                            ->maxLength(255)
                            ->rows(2),
                        Forms\Components\TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->helperText('Comma-separated keywords')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->collapsed(),

                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->directory('images/books')
                    ->visibility('public')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '2:3',
                    ]),
                Forms\Components\FileUpload::make('sample_pdf')
                    ->label('Sample PDF (Test Read)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->directory('pdfs/books')
                    ->visibility('public')
                    ->maxSize(10240),
                Forms\Components\TextInput::make('isbn'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(199)
                    ->suffix('SEK')
                    ->helperText('Pris i SEK (utan decimaler)'),
                Forms\Components\DatePicker::make('publication_date'),
                Forms\Components\TextInput::make('pages')
                    ->numeric(),
                Forms\Components\TextInput::make('genre'),
                Forms\Components\Toggle::make('is_published')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'available' => 'Tillgänglig',
                        'soon_to_be_released' => 'Snart tillgänglig',
                        'out_of_stock' => 'Slutsåld',
                    ])
                    ->required()
                    ->default('available')
                    ->helperText('Välj "Snart tillgänglig" för förbeställningar'),
                Forms\Components\Toggle::make('allow_christmas_orders')
                    ->label('Köpbar med jul-inpackning och signering')
                    ->helperText('Aktivera för att tillåta kunder beställa denna bok med julklappsinpackning och dedikation under julperioden')
                    ->default(false),
                Forms\Components\Toggle::make('allow_signed_orders')
                    ->label('Köpbar med signering')
                    ->helperText('Aktivera för att tillåta kunder beställa en signerad bok med personlig dedikation')
                    ->default(false),
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
                Tables\Columns\ImageColumn::make('cover_image'),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->sortable()
                    ->suffix(' SEK'),
                Tables\Columns\TextColumn::make('publication_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pages')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('genre')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'soon_to_be_released' => 'warning',
                        'out_of_stock' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Tillgänglig',
                        'soon_to_be_released' => 'Snart tillgänglig',
                        'out_of_stock' => 'Slutsåld',
                        default => $state,
                    }),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
