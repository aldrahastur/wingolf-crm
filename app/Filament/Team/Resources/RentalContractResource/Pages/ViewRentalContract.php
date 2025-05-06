<?php

namespace App\Filament\Team\Resources\RentalContractResource\Pages;

use App\Filament\Team\Resources\RentalContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRentalContract extends ViewRecord
{
    protected static string $resource = RentalContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
