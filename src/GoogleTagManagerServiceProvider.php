<?php

namespace Mpietrucha\GoogleTagManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;

class GoogleTagManagerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/googletagmanager.php' => config_path('googletagmanager.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../views', config('googletagmanager.viewKey'));

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/googletagmanager')
        ], 'views');

        Blade::directive('googleTagManagerHead', function (string $expression) {
            return "<?php echo app('" . Renderer::class . "')->render('head')->with($expression); ?>";
        });

        Blade::directive('googleTagManagerBody', function (string $expression) {
            return "<?php echo app('" . Renderer::class . "')->render('body')->with($expression) ?>";
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'./../config/googletagmanager.php', 'googletagmanager');

        $this->app->bind(GoogleTagManager::class, fn () => GoogleTagManager::create(
            config('googletagmanager.id'), config('googletagmanager.enabled')
        ));

        if (File::exists($macros = config('googletagmanager.mixins'))) {
            File::requireOnce($macros);
        }
    }
}
