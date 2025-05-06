<?php

namespace App\Filament\Team\Resources\UserResource\Pages;

use App\Filament\Team\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Tapp\FilamentInvite\Actions\InviteAction;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            InviteAction::make(),
            Actions\EditAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
