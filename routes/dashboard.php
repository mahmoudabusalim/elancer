<?php


use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;



Route::group(
    [
        'prefix' => '/dashboard',
        'middleware'=> 'auth',
    ],


    function () {

        Route::resource(
            'categories',
            CategoriesController::class
        );

    Route::get('profile/',function(){
        return 'secret profile';
    })->middleware('password.confirm');

});


