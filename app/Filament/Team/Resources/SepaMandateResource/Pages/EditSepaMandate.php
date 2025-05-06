<?php

namespace App\Filament\Team\Resources\SepaMandateResource\Pages;

use App\Filament\Team\Resources\SepaMandateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSepaMandate extends EditRecord
{
    protected static string $resource = SepaMandateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
