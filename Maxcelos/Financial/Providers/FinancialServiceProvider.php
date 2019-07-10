<?php

namespace Maxcelos\Financial\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Maxcelos\Financial\Contracts\Account as AccountContract;
use Maxcelos\Financial\Contracts\Category as CategoryContract;
use Maxcelos\Financial\Entities\Account;
use Maxcelos\Financial\Entities\Category;
use Maxcelos\Financial\Entities\Entry;
use Maxcelos\Financial\Policies\AccountPolicy;
use Maxcelos\Financial\Policies\CategoryPolicy;
use Maxcelos\Financial\Repositories\AccountRepository;
use Maxcelos\Financial\Repositories\CategoryRepository;
use Maxcelos\Foundation\Traits\HasPolicies;

class FinancialServiceProvider extends ServiceProvider
{
    use HasPolicies;

    protected $policies = [
        Account::class => AccountPolicy::class,
        Category::class => CategoryPolicy::class,

    ];

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

        $this->registerPolicies();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(AccountContract::class, AccountRepository::class);
        $this->app->bind(CategoryContract::class, CategoryRepository::class);
        $this->app->bind(Ent::class, CategoryRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('financial.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'financial'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/financial');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/financial';
        }, \Config::get('view.paths')), [$sourcePath]), 'financial');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/financial');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'financial');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'financial');
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
