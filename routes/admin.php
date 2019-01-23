<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$this->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
$this->post('login', 'Auth\LoginController@login');
$this->any('logout', 'Auth\LoginController@logout')->name('admin.logout');

Route::group([
    'middleware' => ['admin'],
    'as' => 'admin::'
], function () {

    Route::get('/', ['as' => 'index', 'uses' => 'MasterController@index']);

    ##AUTO_INSERT_ROUTE##

    //OverTime
    Route::resource('over_times', 'OverTimeController');


    //WorkTimeDetail
    Route::resource('work_time_details', 'WorkTimeDetailController');


    //WorkTime
    Route::resource('work_times', 'WorkTimeController');


    //DayOff
    Route::resource('day_offs', 'DayOffController');

    //report
    Route::resource('report', 'ReportController');

    //config
    Route::get('configs', 'ConfigController@index')->name('configs.index');
    Route::post('configs', 'ConfigController@store')->name('configs.store');

    //post
    Route::post('posts/deletes', ['as' => 'posts.deletes', 'uses' => 'PostController@deletes']);
    Route::resource('posts', 'PostController');

    //event
    Route::post('events/deletes', ['as' => 'events.deletes', 'uses' => 'EventController@deletes']);
    Route::resource('events', 'EventController');

    //regulation
    Route::post('regulations/deletes', ['as' => 'regulations.deletes', 'uses' => 'RegulationController@deletes']);
    Route::resource('regulations', 'RegulationController');

    //admin
    Route::resource('admins', 'AdminController');

    //users
    Route::get('users/import/{setId}', ['as' => 'users.import', 'uses' => 'UserController@import']);
    Route::get('users/download-template', ['as' => 'users.download-template', 'uses' => 'UserController@downloadTemplate']);
    Route::post('users/import', ['uses' => 'UserController@importData']);
    Route::post('users/deletes', ['as' => 'users.deletes', 'uses' => 'UserController@deletes']);
    Route::post('teams/deletes', ['as' => 'teams.deletes', 'uses' => 'TeamController@deletes']);
    Route::get('teams/manage-member/{id}', [ 'uses' => 'TeamController@manageMember']);
    Route::resource('users', 'UserController');
    Route::resource('teams', 'TeamController');

});