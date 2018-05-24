<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api\Users')->group(function (): void {
    Route::get('users', 'UserController@index');
    Route::post('users', 'UserController@store');
    Route::get('users/{user}', 'UserController@show');
});
