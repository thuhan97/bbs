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

use Illuminate\Support\Facades\Route;

$this->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
$this->post('login', 'Auth\LoginController@login');
$this->any('logout', 'Auth\LoginController@logout')->name('admin.logout');

Route::group([
    'middleware' => ['admin'],
    'as' => 'admin::'
], function () {

    Route::get('/', ['as' => 'index', 'uses' => 'MasterController@index']);

    ##AUTO_INSERT_ROUTE##

		//event_attendance_list
		Route::resource('event_attendance_list', 'EventAttendanceListController');
		

    //project
    Route::resource('project', 'ProjectController');

    //OverTime
    Route::resource('over_times', 'OverTimeController');

    //feedback
    Route::resource('feedback', 'FeedbackController');

    //OverTime
    Route::resource('over_times', 'OverTimeController');

    //WorkTimeDetail
    Route::resource('work_time_details', 'WorkTimeDetailController');

    //WorkTime
    Route::post('work_times/deletes', ['as' => 'work_times.deletes', 'uses' => 'WorkTimeController@deletes']);
    Route::get('work_times/download-template', ['as' => 'work_times.download_template', 'uses' => 'WorkTimeController@downloadTemplate']);
    Route::get('work_times/import', ['as' => 'work_times.import', 'uses' => 'WorkTimeController@import']);
    Route::post('work_times/import', ['as' => 'work_times.importData', 'uses' => 'WorkTimeController@importData']);
    Route::get('work_times/user/{id}', ['as' => 'work_times.user', 'uses' => 'WorkTimeController@byUser'])->where(['id' => '\d+']);
    Route::resource('work_times', 'WorkTimeController');

    //DayOff
    Route::post('day_offs/deletes', ['as' => 'day_offs.deletes', 'uses' => 'DayOffController@deletes']);
    Route::get('day_offs/user/{id}', ['as' => 'day_offs.user', 'uses' => 'DayOffController@byUser'])->where(['id' => '\d+']);
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

    Route::resource('projects', 'ProjectController');
    Route::post('projects/deletes', ['as' => 'projects.deletes', 'uses' => 'ProjectController@deletes']);

    //users
    Route::get('users/import/{setId}', ['as' => 'users.import', 'uses' => 'UserController@import']);
    Route::get('users/download-template', ['as' => 'users.download-template', 'uses' => 'UserController@downloadTemplate']);
    Route::post('users/import', ['uses' => 'UserController@importData']);
    Route::post('users/deletes', ['as' => 'users.deletes', 'uses' => 'UserController@deletes']);
    Route::get('users/reset-password', 'UserController@resetPassword');
    Route::resource('users', 'UserController');

    Route::post('teams/save-member', ['uses' => 'TeamController@saveUserTeam']);
    Route::get('teams/manage-member/{id}', ['uses' => 'TeamController@manageMember']);
    Route::put('teams/{id}', ['uses' => 'TeamController@updateTmp'])->name('teame.update123');
    Route::post('teams/deletes', ['as' => 'teams.deletes', 'uses' => 'TeamController@deletes']);
    Route::resource('teams', 'TeamController');


});