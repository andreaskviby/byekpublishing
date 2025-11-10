<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Events';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (empty($get('slug'))) {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull()
                            ->helperText('This will be used in the URL: byekpublishing.com/[slug]'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('street_address')
                            ->required()
                            ->maxLength(255)
                            ->label('Location Address')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Date & Time')
                    ->schema([
                        Forms\Components\DatePicker::make('event_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('F j, Y')
                            ->label('Event Date'),
                        Forms\Components\TimePicker::make('start_time')
                            ->required()
                            ->native(false)
                            ->label('Start Time'),
                        Forms\Components\TimePicker::make('end_time')
                            ->native(false)
                            ->label('End Time (Optional)'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Hero Banner Customization')
                    ->description('Customize the hero banner appearance and text')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_banner_image')
                            ->label('Hero Banner Image')
                            ->image()
                            ->directory('events/banners')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->columnSpanFull()
                            ->helperText('Optional background image for the hero section'),
                        Forms\Components\FileUpload::make('hero_graphic_image')
                            ->label('Decorative Graphic (e.g., lemons)')
                            ->image()
                            ->directory('events/graphics')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->columnSpanFull()
                            ->helperText('Optional decorative image (appears top-right)'),
                        Forms\Components\TextInput::make('hero_subtitle')
                            ->label('Hero Subtitle')
                            ->maxLength(255)
                            ->placeholder('Nu släpps uppföljaren')
                            ->helperText('Text above the main title'),
                        Forms\Components\TextInput::make('hero_badge_text')
                            ->label('Badge Text')
                            ->maxLength(255)
                            ->placeholder('Välkommen på bokrelease')
                            ->helperText('Text in the yellow badge'),
                        Forms\Components\Textarea::make('hero_call_to_action')
                            ->label('Call to Action Text')
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder('Kom och fira med mig')
                            ->helperText('Main call-to-action message'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('max_attendees')
                            ->required()
                            ->numeric()
                            ->default(100)
                            ->minValue(1)
                            ->maxValue(100)
                            ->label('Maximum Attendees'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Event is Active'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Color Customization')
                    ->description('Customize page and hero text colors')
                    ->schema([
                        Forms\Components\ColorPicker::make('page_color')
                            ->label('Page Background Color')
                            ->helperText('Color for the event detail page background'),
                        Forms\Components\ColorPicker::make('hero_text_color')
                            ->label('Hero Text Color')
                            ->helperText('Color for the hero section text'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('URL Slug'),
                Tables\Columns\TextColumn::make('event_date')
                    ->date('M j, Y')
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Time')
                    ->formatStateUsing(fn ($record) => $record->start_time . ($record->end_time ? ' - ' . $record->end_time : '')),
                Tables\Columns\TextColumn::make('street_address')
                    ->searchable()
                    ->limit(30)
                    ->label('Location'),
                Tables\Columns\TextColumn::make('rsvps_count')
                    ->counts('rsvps')
                    ->label('RSVPs')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('max_attendees')
                    ->numeric()
                    ->label('Capacity')
                    ->formatStateUsing(function ($record) {
                        $total = $record->rsvps->sum('number_of_guests');
                        return "{$total}/{$record->max_attendees}";
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Events')
                    ->placeholder('All events')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\RsvpsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
