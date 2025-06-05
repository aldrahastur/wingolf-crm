<?php

namespace App\Filament\Team\Resources\MeetingResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';
    protected static ?string $title = 'Teilnehmer';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Teilnehmer')
                    ->options(function () {
                        // Hier können Sie die Anzeige der Benutzer anpassen
                        return User::all()
                            ->pluck('last_name', 'id')
                            ->map(function ($lastName, $id) {
                                $user = User::find($id);
                                return $user->last_name . ', ' . $user->first_name;
                            });
                    })
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'confirmed' => 'Bestätigt',
                        'pending' => 'Ausstehend',
                        'declined' => 'Abgelehnt',
                    ])
                    ->default('confirmed')
                    ->required(),

                TextInput::make('comment')
                    ->label('Kommentar')
                    ->placeholder('Optionaler Kommentar'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.last_name')
            ->columns([
                TextColumn::make('user.last_name')
                    ->label('Nachname')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.first_name')
                    ->label('Vorname')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        'declined' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'confirmed' => 'Bestätigt',
                        'pending' => 'Ausstehend',
                        'declined' => 'Abgelehnt',
                        default => $state,
                    }),

                TextColumn::make('comment')
                    ->label('Kommentar')
                    ->limit(30)
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Teilnehmer hinzufügen'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
