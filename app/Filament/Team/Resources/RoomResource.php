<?php

namespace App\Filament\Team\Resources;

use App\Filament\Team\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationGroup = 'Property management';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-m-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('team_id')->default(auth()->user()->team_id),
                Fieldset::make('Technical')->schema([
                    Forms\Components\TextInput::make('house_number'),
                    Forms\Components\TextInput::make('floor'),
                    Forms\Components\TextInput::make('room_number'),
                    ])->columns(3),
                Fieldset::make('Name')->schema([
                    Forms\Components\TextInput::make('name')->label('Name'),
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'last_name')
                        ->searchable(),
                ])->columns(2),
                Fieldset::make('Finance')->schema([
                    Forms\Components\TextInput::make('price')->numeric(),
                    Forms\Components\TextInput::make('security_deposit')->numeric(),
                    Forms\Components\TextInput::make('room_size')->numeric(),
                ])->columns(3),
                Fieldset::make('Description')->schema([
                    Forms\Components\MarkdownEditor::make('description')->label('Description'),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable()
                    ->searchable(),
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
            ])
            ->defaultSort('updated_at', 'desc');
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
