<?php

namespace App\Filament\Team\Resources\BoardMemberRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoardMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'boardMembers';
    protected static ?string $recordTitleAttribute = 'position';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Person aus Mitgliedschaft')
                ->options(function (RelationManager $livewire) {
                    $membership = $livewire->getOwnerRecord();

                    $today = now()->toDateString();

                    return $membership->users()
                        ->select('users.id', 'users.first_name', 'users.last_name')
                        ->whereDoesntHave('boardMemberships', function ($query) use ($today) {
                            $query->where('starts_at', '<=', $today)
                                ->where(function ($q) use ($today) {
                                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', $today);
                                });
                        })
                        ->orderBy('users.last_name')
                        ->orderBy('users.first_name')
                        ->get()
                        ->pluck('fullName', 'id');
                })
                ->required()
                ->searchable(),

            Forms\Components\TextInput::make('position')
                ->label('Position')
                ->required()
                ->maxLength(255),

            Forms\Components\DatePicker::make('starts_at')
                ->label('Beginn')
                ->format('Y-m-d')
                ->required(),

            Forms\Components\DatePicker::make('ends_at')
                ->label('Ende')
                ->after('starts_at')
                ->format('Y-m-d')
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name')->label('First name'),
                Tables\Columns\TextColumn::make('user.last_name')->label('Last name'),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('starts_at')->date()->label('Beginn'),
                Tables\Columns\TextColumn::make('ends_at')->date()->label('Ende'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('starts_at', 'desc');
    }
}
