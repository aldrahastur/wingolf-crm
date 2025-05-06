<?php

namespace App\Filament\Team\Resources;

use App\Filament\Team\Resources\SepaMandateResource\Pages;
use App\Filament\Team\Resources\SepaMandateResource\RelationManagers;
use App\Models\SepaMandate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SepaMandateResource extends Resource
{
    protected static ?string $model = SepaMandate::class;

    protected static ?string $navigationGroup = 'Finance management';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSepaMandates::route('/'),
            'create' => Pages\CreateSepaMandate::route('/create'),
            'view' => Pages\ViewSepaMandate::route('/{record}'),
            'edit' => Pages\EditSepaMandate::route('/{record}/edit'),
        ];
    }
}
