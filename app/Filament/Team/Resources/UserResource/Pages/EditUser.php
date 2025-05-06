<?php

namespace App\Filament\Team\Resources\UserResource\Pages;

use App\Filament\Team\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Tapp\FilamentInvite\Actions\InviteAction;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Bearbeiten';

    protected function getHeaderActions(): array
    {
        return [
           InviteAction::make(),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
