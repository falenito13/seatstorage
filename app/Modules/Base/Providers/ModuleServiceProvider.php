<?php

namespace App\Modules\Base\Providers;

use App\Modules\Base\Models\Test;
use App\Modules\Base\Repositories\Eloquent\TestRepository;
use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     * @throws \Caffeinated\Modules\Exceptions\ModuleNotFoundException
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('base', 'Resources/Lang', 'app'), 'base');
        $this->loadViewsFrom(module_path('base', 'Resources/Views', 'app'), 'base');
        $this->loadMigrationsFrom(module_path('base', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('base', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('base', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind('TestRepository', function(){
            return new TestRepository(new Test());
        });
    }
}
