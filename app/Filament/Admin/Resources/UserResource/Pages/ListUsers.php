<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Imports\UserImport;
use App\Mail\UserInvitationMail;
use App\Models\UserInvitation;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(UserImporter::class),
            Actions\ExportAction::make()
                ->exporter(UserExporter::class)->formats([
                    ExportFormat::Xlsx,
                    ExportFormat::Csv,
                ]),
            Actions\CreateAction::make(),
            Actions\Action::make('inviteUser')
                ->form([
                    TextInput::make('email')
                        ->email()
                        ->required()
                ])
                ->action(function ($data) {
                    $invitation = UserInvitation::create(['email' => $data['email']]);

                    Mail::to($data['email'])->send(new UserInvitationMail());

                    // @todo Add email sending here

                    Notification::make('invitedSuccess')
                        ->body('User invited successfully!')
                        ->success()->send();
                }),
        ];
    }
}
