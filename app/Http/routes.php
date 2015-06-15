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
    Route::get('/', 'Admin\DashboardController@index');

    /**
     * Games
     */
    Route::get('/games', 'Admin\GamesController@index');
    Route::get('/games/new', 'Admin\GamesController@create');
    Route::post('/games/new', 'Admin\GamesController@save');
    Route::get('/games/edit/{id}', 'Admin\GamesController@edit');
    Route::post('/games/edit/{id}', 'Admin\GamesController@update');
    Route::get('/games/delete/{id}', 'Admin\GamesController@delete');

    /**
     * Users
     */
    Route::get('/users', 'Admin\UsersController@index');
    Route::get('/users/new', 'Admin\UsersController@create');
    Route::post('/users/new', 'Admin\UsersController@save');
    Route::get('/users/edit/{id}', 'Admin\UsersController@edit');
    Route::post('/users/edit/{id}', 'Admin\UsersController@update');
    Route::get('/users/delete/{id}', 'Admin\UsersController@delete');

    /**
     * Opponents
     */
    Route::get('/opponents', 'Admin\OpponentsController@index');
    Route::get('/opponents/new', 'Admin\OpponentsController@create');
    Route::post('/opponents/new', 'Admin\OpponentsController@save');
    Route::get('/opponents/edit/{id}', 'Admin\OpponentsController@edit');
    Route::post('/opponents/edit/{id}', 'Admin\OpponentsController@update');
    Route::get('/opponents/delete/{id}', 'Admin\OpponentsController@delete');
    Route::get('/opponents/delete-image/{id}', 'Admin\OpponentsController@deleteImage');

    /**
     * Teams
     */
    Route::get('/teams', 'Admin\TeamsController@index');
    Route::get('/teams/new', 'Admin\TeamsController@create');
    Route::post('/teams/new', 'Admin\TeamsController@save');
    Route::get('/teams/edit/{id}', 'Admin\TeamsController@edit');
    Route::post('/teams/edit/{id}', 'Admin\TeamsController@update');
    Route::get('/teams/delete/{id}', 'Admin\TeamsController@delete');
    Route::get('/teams/api/team/{id}', 'Admin\TeamsController@getRoster');

    /**
     * Matches
     */
    Route::get('/matches', 'Admin\MatchesController@index');
    Route::get('/matches/new', 'Admin\MatchesController@create');
    Route::post('/matches/new', 'Admin\MatchesController@save');
    Route::get('/matches/edit/{id}', 'Admin\MatchesController@edit');
    Route::post('/matches/edit/{id}', 'Admin\MatchesController@update');
    Route::get('/matches/delete/{id}', 'Admin\MatchesController@delete');
    Route::get('/matches/api/edit/{id}', 'Admin\MatchesController@getMatchJson');
    Route::get('/matches/api/meta', 'Admin\MatchesController@getMetaJson');
});