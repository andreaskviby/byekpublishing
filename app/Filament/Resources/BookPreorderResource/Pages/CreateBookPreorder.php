<?php

namespace App\Filament\Resources\BookPreorderResource\Pages;

use App\Filament\Resources\BookPreorderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookPreorder extends CreateRecord
{
    protected static string $resource = BookPreorderResource::class;
}
