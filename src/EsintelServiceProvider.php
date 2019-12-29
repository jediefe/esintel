<?php
/**
 * This file is part of seat-connector and provides user synchronization between both SeAT and third party platform
 *
 * Copyright (C) 2019  Loïc Leuilliot <loic.leuilliot@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Lawin\Seat\Esintel;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Seat\Services\AbstractSeatPlugin;

/**
 * Class SeatConnectorProvider.
 *
 * @package Warlof\Seat\Connector
 */
class EsintelServiceProvider extends AbstractSeatPlugin
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // $this->addCommands();
        $this->addMigrations();
        $this->addRoutes();
        // $this->addViews();
        // $this->addTranslations();
        // $this->addApiEndpoints();
        // $this->addEvents();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/esintel.config.php', 'seat-connector.config');
        $this->mergeConfigFrom(
            __DIR__ . '/config/package.sidebar.php', 'package.sidebar');
        $this->mergeConfigFrom(
            __DIR__ . '/config/esintel.permissions.php', 'web.permissions');
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @return string
     * @example SeAT Web
     *
     */
    public function getName(): string
    {
        return 'ES Intel';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/jediefe/esintel';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @return string
     * @example web
     *
     */
    public function getPackagistPackageName(): string
    {
        return 'esintel';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @return string
     * @example eveseat
     *
     */
    public function getPackagistVendorName(): string
    {
        return 'lawin';
    }

    /**
     * Return the plugin installed version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return config('esintel.config.version');
    }

    /**
     * Import migrations
     */
    private function addMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }

    /**
     * Register cli commands
     */
    // private function addCommands()
    // {
    //     $this->commands([
    //         DriverUpdateSets::class,
    //         DriverApplyPolicies::class,
    //     ]);
    // }

    /**
     * Register views
     */
    // private function addViews()
    // {
    //     $this->loadViewsFrom(__DIR__ . '/resources/views', 'esintel');
    // }

    /**
     * Import routes
     */
    private function addRoutes()
    {
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/http/routes.php';
        }
    }

    /**
     * Import translations
     */
    // private function addTranslations()
    // {
    //     $this->loadTranslationsFrom(__DIR__ . '/lang', 'seat-connector');
    // }

    /**
     * Import API endpoints
     */
    // private function addApiEndpoints()
    // {
    //     $current_annotations = config('l5-swagger.paths.annotations');
    //     if (! is_array($current_annotations))
    //         $current_annotations = [$current_annotations];

    //     config([
    //         'l5-swagger.paths.annotations' => array_unique(array_merge($current_annotations, [
    //             __DIR__ . '/Http/Resources',
    //             __DIR__ . '/Http/Controllers/Api/V2',
    //         ])),
    //     ]);
    // }

    /**
     * Register events listeners
     */
    private function addEvents()
    {
        Event::listen(EventLogger::class, LoggerListener::class);
    }
}
