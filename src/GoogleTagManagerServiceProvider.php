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
            __DIR__.'/../config/google-tag-manager.php' => config_path('google-tag-manager.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../views', config('google-tag-manager.viewKey'));

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/google-tag-manager')
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
        $this->mergeConfigFrom(__DIR__.'./../config/google-tag-manager.php', 'google-tag-manager');

        $this->app->bind(GoogleTagManager::class, fn () => GoogleTagManager::create(
            config('google-tag-manager.id'), config('google-tag-manager.enabled')
        ));

        if (File::exists($macros = config('google-tag-manager.mixins'))) {
            File::requireOnce($macros);
        }
    }
}
