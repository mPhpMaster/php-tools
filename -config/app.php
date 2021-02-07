<?php

return [

    'timezone' => 'Asia/Riyadh',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'ar',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'ar',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        /*
         * Vendor Service Providers...
         */
        Dingo\Api\Provider\LaravelServiceProvider::class,
        Laratrust\LaratrustServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Nwidart\Modules\LaravelModulesServiceProvider::class,
        Plank\Mediable\MediableServiceProvider::class,

        Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
		'Conf' => \Garf\LaravelConf\LaravelConfServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Language' => Akaunting\Language\Facade::class,
        'Laratrust'   => Laratrust\LaratrustFacade::class,
        'Module' => Nwidart\Modules\Facades\Module::class,
        'SignedUrl' => Spinzar\SignedUrl\Facade::class,
        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'SnappyPDF' => Barryvdh\Snappy\Facades\SnappyPdf::class,
        'SnappyImage' => Barryvdh\Snappy\Facades\SnappyImage::class,
        'Conf' => \Garf\LaravelConf\LaravelConfServiceProvider::class,

    ],

];
