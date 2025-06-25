<?php

namespace DJBDeveloper\LaravelAntiReplay\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use DJBDeveloper\LaravelAntiReplay\Http\Middleware\AntiReplayMiddleware;

class AntiReplayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // 1. 加载路由
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // 2. 加载视图
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'anti-replay');

        // 3. 注册中间件别名，方便用户使用
        $router->aliasMiddleware('anti.replay', AntiReplayMiddleware::class);
        
        // 4. 使视图文件可发布
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../resources/views' => resource_path('views/vendor/anti-replay'),
            ], 'views');
        }
    }
}