<?php

namespace App\Filament\Team\Resources\RentalContractResource\Pages;

use App\Filament\Team\Resources\RentalContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentalContracts extends ListRecords
{
    protected static string $resource = RentalContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
