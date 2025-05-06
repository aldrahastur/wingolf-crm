<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    protected Collection $orders;

    public static function modifyQuery(Builder $query): Builder
    {

      /*  dd($query->with);*/


        return $query->with(['memberships']);
    }


    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('salutation'),
            ExportColumn::make('title'),
            ExportColumn::make('first_name'),
            ExportColumn::make('last_name'),
            ExportColumn::make('email'),
            ExportColumn::make('email_verified_at'),
            ExportColumn::make('team.name'),
            ExportColumn::make('status'),
            ExportColumn::make('wingolfit'),
            ExportColumn::make('phone'),
            ExportColumn::make('mobile'),
            ExportColumn::make('address'),
            ExportColumn::make('zip_code'),
            ExportColumn::make('city'),
            ExportColumn::make('country'),
            ExportColumn::make('admission_date'),
            ExportColumn::make('leaving_date'),
            ExportColumn::make('birthday'),
            ExportColumn::make('death_date'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('memberships')->counts('memberships')->label('Membership Count'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
