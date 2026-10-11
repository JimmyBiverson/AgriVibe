<?php

namespace App\Providers;

use App\Models\Setting;
use App\Support\AgriSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AgriSettings::class, fn () => new AgriSettings());
    }

    public function boot(): void
    {
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());

        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
                return true;
            }

            return null;
        });

        Blade::if('settings', fn (string $key, mixed $default = false) => (bool) agri_setting($key, $default));

        View::composer('*', function (ViewInstance $view) {
            $view->with('agriSettings', app(AgriSettings::class));
        });

        $this->bindSettingsHelpers();
    }

    protected function bindSettingsHelpers(): void
    {
        Setting::saved(fn () => app(AgriSettings::class)->forget());
        Setting::deleted(fn () => app(AgriSettings::class)->forget());
    }
}