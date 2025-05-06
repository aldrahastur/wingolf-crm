<?php

namespace App\Filament\Team\Resources\RoomResource\Pages;

use App\Filament\Team\Resources\RoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
