<?php

namespace App\Filament\Resources\BookPreorderResource\Pages;

use App\Filament\Resources\BookPreorderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookPreorder extends EditRecord
{
    protected static string $resource = BookPreorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
