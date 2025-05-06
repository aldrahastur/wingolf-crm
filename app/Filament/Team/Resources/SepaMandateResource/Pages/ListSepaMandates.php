<?php

namespace App\Filament\Team\Resources\SepaMandateResource\Pages;

use App\Filament\Team\Resources\SepaMandateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSepaMandates extends ListRecords
{
    protected static string $resource = SepaMandateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
