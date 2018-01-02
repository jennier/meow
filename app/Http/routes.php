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

Route::get('/', function () {
    return view('auth/login');
});

Route::get('home','Ballots\BallotsController@index');

Route::get('dashboard', 'Ballots\BallotsController@index')->name('dashboard');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('logout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

//Ballot routes...
Route::resource('ballots', 'Ballots\BallotsController');
Route::resource('ballots.vote', 'Ballots\BallotVotesController');
Route::post('ballots/{id}/notify', 'Ballots\BallotsController@notify')->name('ballots.notify');
Route::get('ballots/{id}/support', 'Ballots\BallotsController@support')->name('ballots.support');

// Surveys routes
Route::resource('surveys', 'Surveys\SurveysController');
Route::resource('surveys.response', 'Surveys\SurveyResponsesController');
Route::post('surveys/{id}/notify', 'Surveys\SurveysController@notify')->name('surveys.notify');
Route::get('surveys/{id}/responses', 'Surveys\SurveysController@responses')->name('surveys.responses');

// Members routes
Route::get('members/committees', 'UsersController@committees')->name('members.committees');
Route::resource('members', 'UsersController');

// Dashboard...
Route::get('/dashboard', ['as' => 'dashboard','uses' => 'DashboardController@index','middleware' => 'auth']);

// CR Routes
Route::group(['prefix' => 'cr'], function () {
    Route::resource('reports', 'CR\ReportsController');
});

// Entrust Admin routes...
Route::group(['middleware' => ['role:admin']], function(){
	Route::resource('roles', 'Admin\RolesController');
	Route::resource('permissions', 'Admin\PermissionsController');
	Route::get('/role_permission', 'Admin\RolesPermissionsController@index');
	Route::post('/role_permission', 'Admin\RolesPermissionsController@store');
});


/*
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});
*/


Route::resource('ballot_supports', 'BallotSupportsController');