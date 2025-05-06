<?php

namespace App\Filament\Team\Resources\MeetingResource\Pages;

use App\Filament\Team\Resources\MeetingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
