<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
// use Illuminate\Support\Facades\Auth;
// use App\User;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('preferences', function ($key) {
            $key = str_replace("'", "", $key);
            return '<?php echo @$appPreferences['. $key .']; ?>';
        });

        Blade::directive('active', function ($expression) {
            return "<?php echo (request()->url() == {$expression} || request()->is({$expression})) ? 'active' : null; ?>";
        });
    
    
        // testing ui directive roles
        // Blade::if('hasrole', function($expression){
        //     if(Auth::user()){
        //         if(Auth::user()->hasAnyRole($expression)){
        //             return true;
        //         }
        //     }
        //     return false;
        // });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
