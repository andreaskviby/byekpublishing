<?php

namespace App\Filament\Resources\MusicReleaseResource\Pages;

use App\Filament\Resources\MusicReleaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMusicRelease extends EditRecord
{
    protected static string $resource = MusicReleaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
