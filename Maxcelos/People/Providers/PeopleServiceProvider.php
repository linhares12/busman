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
        $this->registerConfig();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->make('router')->aliasMiddleware('auth', \Maxcelos\People\Http\Middleware\AuthMiddleware::class);

        $this->app->make('router')->middleware(\Spatie\Cors\Cors::class);

        Relation::morphMap([
            'users' => User::class,
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
