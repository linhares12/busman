<?php

namespace Maxcelos\People\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Maxcelos\People\Entities\Owner;
use Maxcelos\People\Entities\Renter;
use Maxcelos\People\Entities\User;
use Maxcelos\People\Repositories\RenterRepository;
use Maxcelos\People\Repositories\UserRepository;
use Maxcelos\People\Repositories\OwnerRepository;
use Maxcelos\People\Contracts\User as UserContract;
use Maxcelos\People\Contracts\Owner as OwnerContract;
use Maxcelos\People\Contracts\Renter as RenterContract;
use Laravel\Passport\Passport;

class PeopleServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->make('router')->aliasMiddleware('auth', \Maxcelos\People\Http\Middleware\AuthMiddleware::class);

        $this->app->make('router')->middleware(\Spatie\Cors\Cors::class);

        /*Passport::routes(function ($router) {
            $router->forAccessTokens();
            $router->forTransientTokens();
        }, ['prefix' => 'v1/oauth']);*/

        Relation::morphMap([
            'users' => User::class,
            'owners' => Owner::class,
            'renters' => Renter::class,
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        Passport::ignoreMigrations();

        $this->app->bind(
            UserContract::class,
            UserRepository::class
        );

        $this->app->bind(
            OwnerContract::class,
            OwnerRepository::class
        );

        $this->app->bind(
            RenterContract::class,
            RenterRepository::class
        );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('people.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'people'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/people');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/people';
        }, \Config::get('view.paths')), [$sourcePath]), 'people');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/people');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'people');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'people');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
