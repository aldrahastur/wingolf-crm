<?php

namespace App\Filament\Admin\Resources\MembershipResource\Pages;

use App\Filament\Admin\Resources\MembershipResource;
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
