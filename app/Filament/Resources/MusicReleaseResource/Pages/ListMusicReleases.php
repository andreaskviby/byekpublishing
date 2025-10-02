<?php

namespace App\Filament\Resources\MusicReleaseResource\Pages;

use App\Filament\Resources\MusicReleaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMusicReleases extends ListRecords
{
    protected static string $resource = MusicReleaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
