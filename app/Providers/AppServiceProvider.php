<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('hashid', function ($expression) {
            return "<?php echo \Vinkla\Hashids\Facades\Hashids::encode($expression); ?>";
        });

        // If you need a decode directive
        Blade::directive('dehashid', function ($expression) {
            return "<?php echo \Vinkla\Hashids\Facades\Hashids::decode($expression)[0]; ?>";
        });
    }

}
