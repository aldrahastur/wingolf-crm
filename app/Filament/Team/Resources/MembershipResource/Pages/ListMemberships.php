<?php

namespace App\Filament\Team\Resources\MembershipResource\Pages;

use App\Filament\Team\Resources\MembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemberships extends ListRecords
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
