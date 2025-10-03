<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookReviewResource\Pages;
use App\Models\BookReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookReviewResource extends Resource
{
    protected static ?string $model = BookReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationLabel = 'Book Reviews';
    
    protected static ?string $modelLabel = 'Book Review';
    
    protected static ?string $pluralModelLabel = 'Book Reviews';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Details')
                    ->schema([
                        Forms\Components\Select::make('book_id')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('language_id')
                            ->relationship('language', 'name')
                            ->required(),
                        Forms\Components\Select::make('rating')
                            ->required()
                            ->options([
                                1 => '🤍 1 Butterfly - Not impressed',
                                2 => '🦋🤍 2 Butterflies - It was okay',
                                3 => '🦋🦋🦋 3 Butterflies - Good read',
                                4 => '🦋🦋🦋🦋 4 Butterflies - Really enjoyed it',
                                5 => '🦋🦋🦋🦋🦋 5 Butterflies - Absolutely loved it!',
                            ]),
                        Forms\Components\Textarea::make('review_text')
                            ->label('Review Text')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Reviewer Information')
                    ->schema([
                        Forms\Components\TextInput::make('reviewer_signature')
                            ->label('Reviewer Name/Signature')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('reviewer_email')
                            ->label('Reviewer Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('subscribed_to_newsletter')
                            ->label('Subscribed to Newsletter'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Review Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_verified')
                            ->label('Email Verified')
                            ->disabled()
                            ->helperText('Automatically set when user verifies their email'),
                        Forms\Components\Toggle::make('is_approved')
                            ->label('Admin Approved')
                            ->helperText('Toggle to approve/reject this review for public display'),
                        Forms\Components\DateTimePicker::make('submitted_at')
                            ->label('Submission Date')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('verified_at')
                            ->label('Verification Date')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Technical Information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->rows(2),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Book')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language.flag_emoji')
                    ->label('Lang')
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn($state) => str_repeat('🦋', $state) . str_repeat('🤍', 5 - $state))
                    ->alignment('center'),
                Tables\Columns\TextColumn::make('reviewer_signature')
                    ->label('Reviewer')
                    ->searchable()
                    ->default('Anonymous')
                    ->limit(20),
                Tables\Columns\TextColumn::make('review_text')
                    ->label('Review')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('book')
                    ->relationship('book', 'title'),
                Tables\Filters\SelectFilter::make('language')
                    ->relationship('language', 'name'),
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        1 => '1 Butterfly',
                        2 => '2 Butterflies',
                        3 => '3 Butterflies',
                        4 => '4 Butterflies',
                        5 => '5 Butterflies',
                    ]),
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Email Verified'),
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Admin Approved'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (BookReview $record) => $record->update(['is_approved' => true]))
                    ->requiresConfirmation()
                    ->visible(fn (BookReview $record) => !$record->is_approved),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(fn (BookReview $record) => $record->update(['is_approved' => false]))
                    ->requiresConfirmation()
                    ->visible(fn (BookReview $record) => $record->is_approved),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_approved' => true]))
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_approved' => false]))
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('submitted_at', 'desc');
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
            'index' => Pages\ListBookReviews::route('/'),
            'create' => Pages\CreateBookReview::route('/create'),
            'edit' => Pages\EditBookReview::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_approved', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
