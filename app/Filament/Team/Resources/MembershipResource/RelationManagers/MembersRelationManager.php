<?php

namespace App\Filament\Team\Resources\MembershipResource\RelationManagers;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $recordTitleAttribute = 'last_name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('membership_admission_date')
                    ->format('Y-m-d'),
                DatePicker::make('membership_admission_date')
                    ->format('Y-m-d'),
                Toggle::make('fee_required'),
                Toggle::make('voluntary_payer')
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('E-Mail')->searchable(),
                Tables\Columns\TextColumn::make('membership_admission_date')->label('Admission date')
                    ->date('d.m.Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('membership_leave_date')
                    ->date('d.m.Y')
                    ->sortable()
                    ->label('Leave date')->searchable(),
                Tables\Columns\IconColumn::make('fee_required')->label('Gebührenpflichtig')->boolean(),
                Tables\Columns\IconColumn::make('voluntary_payer')->label('Freiwilliger Zahler')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->recordSelectSearchColumns(['first_name', 'last_name', 'email'])
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn () => User::query()->where('team_id', Filament::getTenant()->id))
                    ->recordTitle(fn ($record) => $record->full_name),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
