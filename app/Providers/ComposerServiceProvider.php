<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
//            $preferences = Cache::rememberForever("{$this->app->getLocale()}.preferences", function () {
//                return Preference::all()->pluck('value', 'key');
//            });

            $view->with([
                'auth' => auth()->user(),
                'bodyClasses' => $this->bodyClasses(),
//                'appPreferences' => $preferences,
            ]);
        });

        view()->composer('dashboard.*', function ($view) {
            $view->with([
                'isRTL' => localization()->getCurrentLocaleDirection() == 'rtl',
                'align' => localization()->getCurrentLocaleDirection() == 'rtl' ? 'right' : 'left',
            ]);
        });
    }

    /**
     * Display the classes for the body element.
     *
     * @param  array $classes One or more classes to add to the class list.
     *
     * @return string
     */
    protected function bodyClasses($classes = null)
    {
        if ( ! is_array($classes)) {
            $classes = [];
        }

        $classes[] = auth()->check() ? 'logged-in' : 'guest';
        $classes[] = str_replace('.', '-', Route::currentRouteName());
        $classes[] = localization()->getCurrentLocaleDirection();

        return implode(' ', $classes);
    }
}
