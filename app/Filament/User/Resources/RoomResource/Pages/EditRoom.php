<?php

namespace App\Filament\User\Resources\RoomResource\Pages;

use App\Filament\User\Resources\RoomResource;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
