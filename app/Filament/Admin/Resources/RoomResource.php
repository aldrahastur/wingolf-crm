<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationGroup = 'Property management';

    protected static ?string $navigationIcon = 'heroicon-m-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([/**
            Forms\Components\TextInput::make('id'),
            Forms\Components\TextInput::make('house_number'),
            Forms\Components\TextInput::make('floor'),
            Forms\Components\TextInput::make('room_number'),
            Forms\Components\TextInput::make('name')->label('Name'),
            Forms\Components\TextInput::make('description')->label('Description'),
            Forms\Components\TextInput::make('price')->numeric(),
            Forms\Components\TextInput::make('security_deposit')->numeric(),
            Forms\Components\TextInput::make('room_size')->numeric(),
             **/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('house_number')->searchable(),
                Tables\Columns\TextColumn::make('floor')->searchable(),
                Tables\Columns\TextColumn::make('room_number')->searchable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),

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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
