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

        // Route::as('categories.')
        //     ->group(function () {
        //         Route::get('categories', [CategoriesController::class, 'index'])
        //             ->name('index');
        //         Route::get('categories/create', [CategoriesController::class, 'create'])
        //             ->name('create');
        //         Route::get('categories/{id}', [CategoriesController::class, 'show'])
        //             ->name('show');
        //         Route::post('categories', [CategoriesController::class, 'store'])
        //             ->name('store');
        //         Route::get('categories/{id}/edit', [CategoriesController::class, 'edit'])
        //             ->name('edit');
        //         Route::put('categories/{id}', [CategoriesController::class, 'update'])
        //             ->name('update');
        //         Route::delete('categories/{id}', [CategoriesController::class, 'd estroy'])
        //             ->name('destroy');
        //     });

    Route::get('profile/',function(){
        return 'secret profile';
    })->middleware('password.confirm');

});


