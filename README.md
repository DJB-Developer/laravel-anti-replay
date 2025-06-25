# Laravel Anti-Replay Middleware

一个简单的 Laravel 防重放攻击中间件，它通过一个用户交互页面进行验证，并与 Vue.js 等前端框架的哈希（#）路由模式兼容。

## 功能

-   防止机器人和简单的重放攻击。
-   在不丢失 URL 哈希片段的情况下重定向用户。
-   可通过用户点击按钮进行验证。
-   视图文件可发布，方便用户自定义样式。

## 安装

通过 Composer 安装:

```bash
composer require djbdeveloper/laravel-anti-replay
```

对于 Laravel 5.5+，服务提供者会自动注册。如果你需要手动注册，请将以下行添加到 `config/app.php` 的 `providers` 数组中:

```php
DJBDeveloper\LaravelAntiReplay\Providers\AntiReplayServiceProvider::class,
```

## 使用方法

这个包注册了一个名为 `anti.replay` 的路由中间件。你可以将其应用于任何需要保护的路由或路由组。

**重要提示**: 此包依赖 Laravel 的 Session 功能。请确保你应用的路由（或路由组）已启用 `web` 中间件。

### 应用于单个路由

这是最常见的用法，例如保护你的单页应用（SPA）入口。

在 `routes/web.php` 中:

```php
Route::get('/', function () {
    return view('your-spa-entry-point');
})->middleware(['web', 'anti.replay']);
```

### 应用于路由组

```php
Route::group(['middleware' => ['web', 'anti.replay']], function () {
    Route::get('/', function () {
        // ...
    });
    Route::get('/dashboard', function () {
        // ...
    });
});
```

## 自定义视图

如果你想修改验证页面的外观，可以发布视图文件：

```bash
php artisan vendor:publish --provider="DJBDeveloper\LaravelAntiReplay\Providers\AntiReplayServiceProvider" --tag="views"
```

这会将 `verification.blade.php` 文件复制到你的 `resources/views/vendor/anti-replay` 目录下，你可以在那里自由编辑它。

## License

The MIT License (MIT).