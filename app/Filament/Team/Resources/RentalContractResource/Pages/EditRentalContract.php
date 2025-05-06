<?php

namespace App\Filament\Team\Resources\RentalContractResource\Pages;

use App\Filament\Team\Resources\RentalContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalContract extends EditRecord
{
    protected static string $resource = RentalContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
