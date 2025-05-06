<?php

namespace App\Filament\Team\Resources\SepaMandateResource\Pages;

use App\Filament\Team\Resources\SepaMandateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSepaMandate extends ViewRecord
{
    protected static string $resource = SepaMandateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
