<?php

namespace Modules\Artisany\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\AliasLoader;

class ArtisanyServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
	    // Get namespace
	    $nameSpace = $this->app->getNamespace();
	    
	    // Set namespace alias for Controller
	    AliasLoader::getInstance()->alias('AppController', $nameSpace . 'Http\Controllers\Controller');
	
	    // Set namespace alias for Kernel
	    AliasLoader::getInstance()->alias('AppKernel', $nameSpace . 'Http\Kernel');

	    // Set namespace alias for Kernel2
	    AliasLoader::getInstance()->alias('AppKernel2', currentNamespace("..\Http\Kernel"));
	
	    $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        // Config
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('artisany.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'artisany'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/artisany');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');
	
	    // Views
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/artisany';
        }, \Config::get('view.paths')), [$sourcePath]), 'artisany');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/artisany');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'artisany');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'artisany');
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
