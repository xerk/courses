<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo 'AED ' . number_format($amount, 2); ?>";
        });

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                'Main',
                'Sales Portal',
                'User Management',
                'Reports'
            ]);
        });
    }
}
