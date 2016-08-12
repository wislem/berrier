<?php

namespace Wislem\Berrier;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class BerrierServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load routes if app is not caching routes.
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        // Load Package Middleware
//        $kernel = app('Illuminate\Contracts\Http\Kernel');
//        $kernel->pushMiddleware('Wislem\Berrier\Http\Middleware\MenuMiddleware');
        $this->app['router']->middleware('berrier.auth', 'Wislem\Berrier\Http\Middleware\BerrierAuth');

        // Register Service providers
        $this->app->register('AdamWathan\BootForms\BootFormsServiceProvider');
        $this->app->register('Dimsav\Translatable\TranslatableServiceProvider');
        $this->app->register('Propaganistas\LaravelTranslatableBootForms\TranslatableBootFormsServiceProvider');
        $this->app->register('Wislem\Berrier\Providers\BerrierAuthServiceProvider');
        $this->app->register('Caffeinated\Menus\MenusServiceProvider');
        $this->app->register('Bkwld\Croppa\ServiceProvider');
        $this->app->register('DidierDeMaeyer\MultipleLocales\Providers\MultipleLocalesServiceProvider');

        // Load Aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Widget', 'Wislem\Berrier\Http\Controllers\Modules\Widgets\Facades\Widget');
        $loader->alias('Menu', 'Caffeinated\Menus\Facades\Menu');
        $loader->alias('Croppa', 'Bkwld\Croppa\Facade');
        $loader->alias('BootForm', 'AdamWathan\BootForms\Facades\BootForm');
        $loader->alias('TranslatableBootForm', 'Propaganistas\LaravelTranslatableBootForms\Facades\TranslatableBootForm');


        // Publish stuff
        $this->publishes([
            __DIR__ . '/../database/seeds' => app_path() . '/../database/seeds',
            __DIR__ . '/../database/migrations' => app_path() . '/../database/migrations',
            __DIR__ . '/../public' => public_path() . '/admin_assets',
            __DIR__ . '/../resources/views' => resource_path() . '/views/berrier',
            __DIR__ . '/../resources/lang' => resource_path() . '/lang/berrier',
            __DIR__ . '/../config/berrier.php' => config_path() . '/berrier.php'
        ], 'berrier');

        // Load views
        $this->loadViewsFrom(resource_path() . '/views/berrier', 'berrier');

        // Load translations
        $this->loadTranslationsFrom(resource_path().'/lang/berrier', 'berrier');

        // Run artisan commands
        // \Artisan::call('multiple-locales:install');

        // View Composers
        setlocale(LC_TIME, config('app.locale'));

        $auth = $this->app['auth'];
        view()->composer('berrier::admin.partials.header', function($view) use ($auth){
            $notifications = $auth->user()->notifications(0)->get();
            $view->with(compact('notifications'))
                ->with('notification_quantity', count($notifications))
                ->with('user', $auth->user());
        });

        view()->composer('berrier::admin.partials.left-sidebar', function($view) use ($auth){
            $view->with('user', $auth->user());
        });

        // Load Macros
        require __DIR__.'/Http/macros.php';
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}