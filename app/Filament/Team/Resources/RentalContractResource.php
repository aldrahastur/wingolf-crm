<?php

namespace App\Filament\Team\Resources;

use App\Filament\Team\Resources\RentalContractResource\Pages;
use App\Filament\Team\Resources\RentalContractResource\RelationManagers;
use App\Models\RentalContract;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RentalContractResource extends Resource
{
    protected static ?string $model = RentalContract::class;

    protected static ?string $navigationGroup = 'Property management';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.name'),
                Tables\Columns\TextColumn::make('rental_price')
                    ->money('EUR', locale: 'de_DE'),
                Tables\Columns\TextColumn::make('started_at')
                    ->date('d.m.Y'),
                Tables\Columns\TextColumn::make('ended_at')
                    ->date('d.m.Y'),
                Tables\Columns\TextColumn::make('balanceFloatNum')
                    ->label('Wallet balance')
                    ->money('EUR', locale: 'de_DE')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordUrl( fn (RentalContract $record): string => Pages\ViewRentalContract::getUrl([$record->id]))
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalContracts::route('/'),
            'create' => Pages\CreateRentalContract::route('/create'),
            'view' => Pages\ViewRentalContract::route('/{record}'),
            'edit' => Pages\EditRentalContract::route('/{record}/edit'),
        ];
    }
}
