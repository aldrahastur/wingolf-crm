<?php

namespace App\Filament\Team\Resources;


use App\Filament\Team\Resources\MembershipResource\Pages;
use App\Filament\Team\Resources\MembershipResource\RelationManagers\BoardMembersRelationManager;
use App\Filament\Team\Resources\MembershipResource\RelationManagers\MembersRelationManager;
use App\Models\Membership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationGroup = 'Association management';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('member_fee')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('settlement_period')
                    ->label('Settlement_period')
                    ->numeric()
                    ->hint('in months'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('member_fee')->money('EUR'),
                TextColumn::make('settlement_period')->searchable(),
                TextColumn::make('balance'),
                TextColumn::make('users_count')->counts('users')
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
            BoardMembersRelationManager::class,
        ];
    }
}
