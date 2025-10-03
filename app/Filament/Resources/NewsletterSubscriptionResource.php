<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriptionResource\Pages;
use App\Models\NewsletterSubscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsletterSubscriptionResource extends Resource
{
    protected static ?string $model = NewsletterSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static ?string $navigationLabel = 'Newsletter Subscribers';
    
    protected static ?string $modelLabel = 'Newsletter Subscription';
    
    protected static ?string $pluralModelLabel = 'Newsletter Subscriptions';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subscriber Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('source')
                            ->required()
                            ->options([
                                'website' => 'Direct Website Signup',
                                'book_review' => 'Book Review Form',
                                'contact' => 'Contact Form',
                                'manual' => 'Manual Addition',
                            ])
                            ->default('website'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Verification Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_verified')
                            ->label('Email Verified')
                            ->helperText('Toggle to manually verify/unverify this subscription'),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\BadgeColumn::make('source')
                    ->colors([
                        'primary' => 'website',
                        'success' => 'book_review',
                        'warning' => 'contact',
                        'secondary' => 'manual',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'website' => 'Website',
                        'book_review' => 'Book Review',
                        'contact' => 'Contact Form',
                        'manual' => 'Manual',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subscribed')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Verified')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('Not verified'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'website' => 'Website',
                        'book_review' => 'Book Review',
                        'contact' => 'Contact Form',
                        'manual' => 'Manual',
                    ]),
                Tables\Filters\TernaryFilter::make('is_verified')
                    ->label('Email Verified'),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (NewsletterSubscription $record) {
                        $record->markAsVerified();
                    })
                    ->requiresConfirmation()
                    ->visible(fn (NewsletterSubscription $record) => !$record->is_verified),
                Tables\Actions\Action::make('unverify')
                    ->label('Unverify')
                    ->icon('heroicon-o-x-mark')
                    ->color('warning')
                    ->action(fn (NewsletterSubscription $record) => $record->update([
                        'is_verified' => false,
                        'verified_at' => null
                    ]))
                    ->requiresConfirmation()
                    ->visible(fn (NewsletterSubscription $record) => $record->is_verified),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify')
                        ->label('Verify Selected')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->markAsVerified();
                            });
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Email List')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function ($records) {
                            $emails = $records->pluck('email')->join(', ');
                            // You could implement CSV export here
                            session()->flash('success', 'Email list copied to clipboard: ' . $emails);
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListNewsletterSubscriptions::route('/'),
            'create' => Pages\CreateNewsletterSubscription::route('/create'),
            'edit' => Pages\EditNewsletterSubscription::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_verified', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
