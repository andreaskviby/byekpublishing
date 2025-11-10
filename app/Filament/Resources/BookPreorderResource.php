<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookPreorderResource\Pages;
use App\Models\BookPreorder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookPreorderResource extends Resource
{
    protected static ?string $model = BookPreorder::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Bokförbeställningar';

    protected static ?string $modelLabel = 'Bokförbeställning';

    protected static ?string $pluralModelLabel = 'Bokförbeställningar';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bokdetaljer')
                    ->schema([
                        Forms\Components\Select::make('book_id')
                            ->label('Bok')
                            ->relationship('book', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->collapsible(),

                Forms\Components\Section::make('Kunduppgifter')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Namn')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('E-post')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ])->columns(3)->collapsible(),

                Forms\Components\Section::make('Leveransadress')
                    ->schema([
                        Forms\Components\TextInput::make('street_address')
                            ->label('Gatuadress')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('postal_code')
                                    ->label('Postnummer')
                                    ->required()
                                    ->maxLength(20),
                                Forms\Components\TextInput::make('city')
                                    ->label('Ort')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country')
                                    ->label('Land')
                                    ->required()
                                    ->maxLength(255)
                                    ->default('Sverige'),
                            ]),
                    ])->collapsible(),

                Forms\Components\Section::make('Beställningsdetaljer')
                    ->schema([
                        Forms\Components\Textarea::make('dedication_message')
                            ->label('Dedikationstext')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('wants_gift_wrap')
                            ->label('Julklappsinpackning (+45 SEK)')
                            ->default(false),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Totalpris (SEK)')
                            ->required()
                            ->numeric()
                            ->prefix('SEK')
                            ->default(199.00),
                    ])->columns(2)->collapsible(),

                Forms\Components\Section::make('Betalningsinformation')
                    ->schema([
                        Forms\Components\Select::make('payment_status')
                            ->label('Betalningsstatus')
                            ->options([
                                'pending' => 'Väntar på betalning',
                                'paid' => 'Betald',
                                'sent' => 'Skickad',
                                'expired' => 'Utgången',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\DateTimePicker::make('payment_deadline')
                            ->label('Betalningsdeadline')
                            ->required()
                            ->default(now()->addHours(2)),
                    ])->columns(2)->collapsible(),

                Forms\Components\Section::make('Teknisk information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP-adress')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(1)->collapsible()->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Bok')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Namn')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-post')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ort')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('wants_gift_wrap')
                    ->label('Julinslagning')
                    ->boolean()
                    ->trueIcon('heroicon-o-gift')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Pris')
                    ->money('SEK')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'sent' => 'info',
                        'expired' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Väntar',
                        'paid' => 'Betald',
                        'sent' => 'Skickad',
                        'expired' => 'Utgången',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_deadline')
                    ->label('Deadline')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Skapad')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Betalningsstatus')
                    ->options([
                        'pending' => 'Väntar på betalning',
                        'paid' => 'Betald',
                        'sent' => 'Skickad',
                        'expired' => 'Utgången',
                    ]),
                Tables\Filters\SelectFilter::make('book_id')
                    ->label('Bok')
                    ->relationship('book', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('wants_gift_wrap')
                    ->label('Med julinslagning')
                    ->query(fn ($query) => $query->where('wants_gift_wrap', true)),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('Markera som betald')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (BookPreorder $record) => $record->payment_status === 'pending')
                    ->action(function (BookPreorder $record) {
                        $record->update(['payment_status' => 'paid']);

                        Notification::make()
                            ->title('Betalning bekräftad')
                            ->success()
                            ->body("Förbeställning #{$record->id} har markerats som betald och ett bekräftelsemail har skickats till {$record->email}.")
                            ->send();
                    }),
                Tables\Actions\Action::make('mark_as_sent')
                    ->label('Markera som skickad')
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->requiresConfirmation()
                    ->visible(fn (BookPreorder $record) => $record->payment_status === 'paid')
                    ->action(function (BookPreorder $record) {
                        $record->update(['payment_status' => 'sent']);

                        Notification::make()
                            ->title('Markerad som skickad')
                            ->success()
                            ->body("Förbeställning #{$record->id} har markerats som skickad och ett leveransbekräftelsemail har skickats till {$record->email}.")
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('Markera som betalda')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['payment_status' => 'paid']);
                            });

                            Notification::make()
                                ->title('Betalningar bekräftade')
                                ->success()
                                ->body(count($records) . ' förbeställningar har markerats som betalda och bekräftelsemail har skickats.')
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('mark_as_sent')
                        ->label('Markera som skickade')
                        ->icon('heroicon-o-truck')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['payment_status' => 'sent']);
                            });

                            Notification::make()
                                ->title('Markerade som skickade')
                                ->success()
                                ->body(count($records) . ' förbeställningar har markerats som skickade och leveransbekräftelsemail har skickats.')
                                ->send();
                        }),
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
            'index' => Pages\ListBookPreorders::route('/'),
            'create' => Pages\CreateBookPreorder::route('/create'),
            'edit' => Pages\EditBookPreorder::route('/{record}/edit'),
        ];
    }
}
