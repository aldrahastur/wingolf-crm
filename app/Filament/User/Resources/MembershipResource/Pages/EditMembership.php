<?php

namespace App\Filament\User\Resources\MembershipResource\Pages;

use App\Filament\User\Resources\MembershipResource;
use Filament\Resources\Pages\EditRecord;

class EditMembership extends EditRecord
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
