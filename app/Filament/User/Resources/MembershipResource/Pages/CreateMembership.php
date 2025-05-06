<?php

namespace App\Filament\User\Resources\MembershipResource\Pages;

use App\Filament\User\Resources\MembershipResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMembership extends CreateRecord
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
