<?php

namespace App\Filament\Resources\PurchaseLinkResource\Pages;

use App\Filament\Resources\PurchaseLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseLink extends EditRecord
{
    protected static string $resource = PurchaseLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
