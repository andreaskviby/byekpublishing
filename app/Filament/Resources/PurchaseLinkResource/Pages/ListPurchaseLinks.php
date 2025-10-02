<?php

namespace App\Filament\Resources\PurchaseLinkResource\Pages;

use App\Filament\Resources\PurchaseLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseLinks extends ListRecords
{
    protected static string $resource = PurchaseLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
