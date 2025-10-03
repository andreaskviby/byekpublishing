<?php

namespace App\Filament\Resources\YouTubeVideoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('author_name')
                    ->disabled(),
                Forms\Components\Textarea::make('comment_text')
                    ->disabled()
                    ->rows(3),
                Forms\Components\TextInput::make('like_count')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->disabled(),
                Forms\Components\Toggle::make('is_approved')
                    ->label('Approved (Show on website)')
                    ->helperText('Uncheck to hide this comment from the public website'),
                Forms\Components\Toggle::make('has_ai_reply')
                    ->disabled()
                    ->label('AI Reply Posted'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment_text')
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment_text')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('like_count')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_ai_reply')
                    ->boolean()
                    ->label('AI Reply'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Approved')
                    ->placeholder('All comments')
                    ->trueLabel('Approved only')
                    ->falseLabel('Hidden only'),
                Tables\Filters\TernaryFilter::make('has_ai_reply')
                    ->label('AI Reply')
                    ->placeholder('All comments')
                    ->trueLabel('With AI reply')
                    ->falseLabel('Without AI reply'),
            ])
            ->headerActions([
                // Comments are synced from YouTube, so no create action
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }
}
