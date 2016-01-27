<?php

use App\Models\Task;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    // Auth
    Route::controllers([
        'auth' => 'Auth\AuthController',
    ]);
    
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', function () {
            return view('welcome');
        });
        Route::get('task.html', 'TaskController@monitoring');
        Route::match(['get', 'post'], 'task-store.html', 'TaskController@store');
    });
});


