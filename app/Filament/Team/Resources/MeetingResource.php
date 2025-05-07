<?php

namespace App\Filament\Team\Resources;

use App\Filament\Resources\MeetingResource\Pages;
use App\Models\Meeting;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationGroup = 'Association management';
    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'meetings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('team_id')->default(auth()->user()->team_id),
                Fieldset::make('Main data')
                    ->schema([
                        TextInput::make('type')
                            ->required(),
                        Select::make('membership_id')
                            ->relationship('membership', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('visibility')
                            ->required()
                            ->options([
                                1 => 'öffentlich',
                                2 => 'intern'
                            ])
                            ->default(1),
                    ])->columns(3),
                Fieldset::make('Main data')
                    ->schema([
                        RichEditor::make('protocol')
                            ->required()
                            ->columnSpanFull()
                            ->hintAction(
                                fn(Get $get) => Action::make('previewContent')
                                    ->slideOver()
                                    ->infolist([
                                        ViewEntry::make('contentPreview')
                                            ->view('preview-content', [
                                                'content' => $get('protocol') ?? '',
                                            ])
                                    ])
                            ),

                    ])->columnSpanFull(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Meeting $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Meeting $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type'),

                TextColumn::make('team.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visibilty'),

                TextColumn::make('file_path'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Team\Resources\MeetingResource\Pages\ListMeetings::route('/'),
            'create' => \App\Filament\Team\Resources\MeetingResource\Pages\CreateMeeting::route('/create'),
            'edit' => \App\Filament\Team\Resources\MeetingResource\Pages\EditMeeting::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['team']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['team.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->team) {
            $details['Team'] = $record->team->name;
        }

        return $details;
    }
}
