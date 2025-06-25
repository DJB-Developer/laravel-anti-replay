<?php

namespace DJBDeveloper\LaravelAntiReplay\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use DJBDeveloper\LaravelAntiReplay\Http\Middleware\AntiReplayMiddleware;

class AntiReplayServiceProvider extends ServiceProvider
{
    /**
     * The base path of the package.
     *
     * @var string
     */
    protected $packageBasePath;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->packageBasePath = dirname(__DIR__, 2) . '/';
    }

    /**
     * Bootstrap any application services.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom($this->packageBasePath . 'routes/web.php');

        $this->loadViewsFrom($this->packageBasePath . 'resources/views', 'anti-replay');

        $router->aliasMiddleware('anti.replay', AntiReplayMiddleware::class);
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->packageBasePath . 'resources/views' => resource_path('views/vendor/anti-replay'),
            ], 'views');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}