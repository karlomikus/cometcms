<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

/**
 * TODO: Change this terrible route shorthand to something more readable
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/**
 * Basic routes
 */
Route::get('/matches', 'MatchesController@index');
Route::get('/match/{id}', 'MatchesController@show');

/**
 * Admin routes
 */
Entrust::routeNeedsRole('admin*', 'admin', Redirect::to('/'));

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function()
{
    /**
     * Users
     */
    Route::get('/users', 'Admin\UsersController@index');

    /**
     * Matches
     */
    Route::get('/matches', 'Admin\MatchesController@index');
    Route::get('/matches/new', 'Admin\MatchesController@create');
    Route::post('/matches/new', 'Admin\MatchesController@save');
    Route::get('/matches/edit/{id}', 'Admin\MatchesController@edit');
    Route::get('/matches/form', 'Admin\MatchesController@formData');
});