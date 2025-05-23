<?php

namespace App\Filament\Admin\Resources\SubscriptionsResource\Pages;

use App\Filament\Admin\Resources\SubscriptionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
