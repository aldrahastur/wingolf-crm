<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\AdminUserRegistration;
use App\Filament\Team\Pages\EditTeamProfile;
use App\Filament\Team\Pages\RegisterTeam;
use App\Filament\Team\Resources\UserResource\Widgets\UserOverview;
use App\Models\Team;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Maartenpaauw\Filament\Cashier\Stripe\BillingProvider;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use Vormkracht10\FilamentMails\FilamentMailsPlugin;

class TeamPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('team')
            ->path('team')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->login()
            ->registration(AdminUserRegistration::class)
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->tenant(Team::class, slugAttribute: 'slug')
            ->tenantProfile(EditTeamProfile::class)
            ->tenantRegistration(RegisterTeam::class)
            ->tenantBillingProvider(new BillingProvider('default'))
            /*->requiresTenantSubscription()*/
            ->discoverResources(in: app_path('Filament/Team/Resources'), for: 'App\\Filament\\Team\\Resources')
            ->discoverPages(in: app_path('Filament/Team/Pages'), for: 'App\\Filament\\Team\\Pages')
            ->navigationGroups([
                NavigationGroup::make()->label('Association management'),
                NavigationGroup::make()->label('Property management'),
                NavigationGroup::make()->label('Finance management'),
            ])
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Team/Widgets'), for: 'App\\Filament\\Team\\Widgets')
            ->widgets([
                UserOverview::class,
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentMailsPlugin::make()
            ])
            ->databaseNotifications();
    }
}
