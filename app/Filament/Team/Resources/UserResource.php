<?php

namespace App\Filament\Team\Resources;

use App\Filament\Team\Resources\UserResource\Pages;
use App\Filament\Team\Resources\UserResource\RelationManagers;
use App\Filament\Team\Resources\UserResource\Widgets\UserOverview;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;
use Tapp\FilamentInvite\Tables\InviteAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Association management';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Salutation')
                    ->schema([
                        Forms\Components\TextInput::make('salutation')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('letter_salutation')
                            ->maxLength(255),
                    ])
                    ->columns(3),
                Fieldset::make('Main data')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(3),
                Fieldset::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('birthday'),
                        Forms\Components\DatePicker::make('admission_date'),
                        Forms\Components\DatePicker::make('leaving_date'),
                        Forms\Components\DatePicker::make('death_date'),
                    ])
                    ->columns(4),
                Fieldset::make('Address')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255)->columnSpanFull(),
                        Forms\Components\TextInput::make('zip_code')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255),
                        Country::make('country')
                            ->default('DE'),
                    ])
                    ->columns(3),
                Fieldset::make('Phone')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mobile')
                            ->maxLength(255),
                    ])
                    ->columns(),
                Forms\Components\Checkbox::make('status')
                    ->default(1),
                Forms\Components\Checkbox::make('wingolfit')
                    ->default(1),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('letter_salutation')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Customer Name')
                    ->formatStateUsing(function ($state, User $user) {
                        $name = $user->first_name . ' ' . $user->last_name;
                        $age = Carbon::parse($user->birthday)->age;
                        if (!is_null($user->death_date)) {
                            $age = Carbon::parse($user->death_date)->diff(Carbon::parse($user->death_date))->format('%y');
                        }
                        $death = ($user->death_date) ? '† ' : '';
                        return $name . ' ('. $death . $age. ')';
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('admission_date')
                    ->date('d.m.Y')->sortable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('memberships.name')
                    ->badge()
                    ->separator(','),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('last_name')
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Aktiv')
                    ->hidden()
                    ->nullable()->default(1) ,
                Tables\Filters\TernaryFilter::make('death_date')
                    ->label('Verstorben')
                    ->nullable()->default(0) ,
                Tables\Filters\TernaryFilter::make('leaving_date')
                    ->label('Ausgetreten')
                    ->nullable()->default(0) ,
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('memberships')
                    ->relationship('memberships', 'name'),
            ])

            ->actions([
                InviteAction::make(),
                Tables\Actions\EditAction::make()->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->persistSortInSession()
            ->persistFiltersInSession()
            ->poll('3s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('first_name'),
                Infolists\Components\TextEntry::make('last_name'),
                Infolists\Components\TextEntry::make('email')
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MembershipsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
