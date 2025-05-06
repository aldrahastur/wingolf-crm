<?php

namespace App\Filament\Team\Resources\RoomResource\Pages;

use App\Filament\Team\Resources\RoomResource;
use App\Http\Controllers\RentalContractController;
use App\Models\RentalContract;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addRentalContract')
                ->form([
                    Select::make('user_id')
                        ->label('User')
                        ->options(User::query()->pluck('last_name', 'id'))
                        ->searchable()
                        ->required(),
                    DatePicker::make('started_at'),
                    TextInput::make('rental_price')
                        ->default($this->record->rental_price)
                ])
                ->action(function (array $data, $record): void {
                    (new RentalContractController())->createContract($record, $data);
                })
                ->visible(($this->record->user_id ?? true)),

            Action::make('cancelRentalContract')
                ->form([
                    Select::make('authorId')
                        ->label('Author')
                        ->options(User::query()->pluck('last_name', 'id'))
                        ->required(),
                ])
                ->action(function (array $data, RentalContract $record): void {
                    $record->author()->associate($data['authorId']);
                    $record->save();
                })
                ->visible(($this->record->user_id ?? false))
        ];
    }
}
