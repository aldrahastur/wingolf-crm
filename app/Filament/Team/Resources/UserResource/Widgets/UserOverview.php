<?php

namespace App\Filament\Team\Resources\UserResource\Widgets;

use App\Models\Room;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Rooms without rental', Room::without('user')->count()),
        ];
    }
}
