<?php

namespace App\Filament\Admin\Resources\SubscriptionsResource\Pages;

use App\Filament\Admin\Resources\SubscriptionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscriptions extends EditRecord
{
    protected static string $resource = SubscriptionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
