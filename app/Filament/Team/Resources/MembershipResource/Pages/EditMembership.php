<?php

namespace App\Filament\Team\Resources\MembershipResource\Pages;

use App\Filament\Team\Resources\MembershipResource;
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
