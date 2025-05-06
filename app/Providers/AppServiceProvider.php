<?php

namespace App\Providers;

use App\Models\Team;
use Filament\Resources\Resource;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Resource::scopeToTenant(false);
        Cashier::useCustomerModel(Team::class);
        Cashier::calculateTaxes(true);
    }
}
