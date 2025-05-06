<?php

namespace App\Filament\Team\Resources\UserResource\Pages;

use App\Exports\UsersExport;
use App\Filament\Imports\UserImporter;
use App\Filament\Team\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(UserImporter::class),
            Action::make('Export')
                ->action(fn () => Excel::download(new UsersExport(
                    $this->table->paginated(false)->getRecords(),
                    $this->tableFilters
                ), 'users.xlsx'))
                ->icon('heroicon-o-arrow-down-on-square'),
            Actions\CreateAction::make(),
        ];
    }
}
