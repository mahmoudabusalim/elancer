<?php

use App\Http\Controllers\Client\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'=>'client',
    'as'=>'client.',
    'middleware'=>'auth',
],function(){
    Route::resource('projects',ProjectsController::class);
});





// OR USE


// Route::resource('projects',ProjectsController::class)->names([

//     'index'=>'client.projects.index',
//     'create'=>'client.projects.create',
//     'store'=>'clint.projects.store',
//     'show'=>'clint.projects.show',
//     'edit'=>'clint.projects.edit',
//     'update'=>'clint.projects.update',
//     'distroy'=>'clint.projects.distroy',
// ]);
