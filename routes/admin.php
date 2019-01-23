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

    //config
    Route::post('config/deletes', ['as' => 'config.deletes', 'uses' => 'ConfigController@deletes']);
    Route::resource('config', 'ConfigController');

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