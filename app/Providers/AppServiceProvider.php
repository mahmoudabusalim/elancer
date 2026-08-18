<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
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
        if(App::environment("production")){
            Config::set('app.debug',false);

        }

        Validator::extend('filter',function($attribute,$value){
            if($value == 'god'){
                return false;
            }
            return true;
        },'invalid Word');

        Paginator::useBootstrapFive();
    }
}
