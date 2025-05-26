<?php

namespace App\Filament\Team\Resources\MeetingResource\Pages;

use App\Filament\Team\Resources\MeetingResource;
use App\Http\Controllers\Pdf\MeetingProtocolPdfController;
use App\Models\Meeting;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;

use Filament\Resources\Pages\EditRecord;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
            Action::make('Fertigstellen & senden')
                ->action(fn (Meeting $record) => app(MeetingProtocolPdfController::class)->sendProtocol($record))
                ->requiresConfirmation()
        ];
    }
}
