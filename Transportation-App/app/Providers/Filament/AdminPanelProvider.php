<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Enums\ThemeMode;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;
use App\Models\Trip;
use Filament\View\PanelsRenderHook;
use Filament\View\Topbar;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')->renderHook('panels::topbar.start', fn () => view('filament.logo'))->brandName('')
            ->defaultThemeMode(ThemeMode::Dark)
            ->login()
            ->colors([
                'primary' => 'emerald',
                'secondary' => 'slate',
            ])->globalSearch(false)
            ->renderHook('panels::topbar.end', fn() => view('filament.activity-info'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                // \App\Filament\Resources\Trips\Widgets\ActiveTrips::class,
                \App\Filament\Resources\Drivers\Widgets\AvailableDrivers::class,
                \App\Filament\Widgets\AvailableVehicles::class,
                \App\Filament\Widgets\ActiveTripsChart::class,\App\Filament\Widgets\CompletedTrips::class,
            ])
           // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->navigationGroups([
                'Operations',
                'Management',
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
            ]);
    }
}
