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
    Route::get('/download', ['as' => 'download', 'uses' => 'MasterController@download']);
    //punishes
    Route::post('punishes-submit', ['as' => 'punishes.submit', 'uses' => 'PunishesController@submits']);
    Route::get('punishes/status/{id}', ['as' => 'punishes.status', 'uses' => 'PunishesController@changeSubmitStatus']);
    Route::post('punishes/deletes', ['as' => 'punishes.deletes', 'uses' => 'PunishesController@deletes']);
    Route::resource('punishes', 'PunishesController');

    //rules
    Route::post('rules/deletes', ['as' => 'rules.deletes', 'uses' => 'RulesController@deletes']);
    Route::resource('rules', 'RulesController');

    //DeviceUser
    Route::get('devices/{id}/allocate', ['as' => 'deviceusers.allocate', 'uses' => 'DeviceUserController@allocate']);
    Route::post('deviceusers/deletes', ['as' => 'deviceusers.deletes', 'uses' => 'DeviceUserController@deletes']);
    Route::resource('deviceusers', 'DeviceUserController');

    //ActionDevice
//    Route::resource('ActionDevice', 'ActionDeviceController');

    //Device
    Route::post('devices/deletes', ['as' => 'devices.deletes', 'uses' => 'DeviceController@deletes']);
    Route::resource('devices', 'DeviceController');
    //event_attendance
    Route::resource('event_attendance', 'EventAttendanceController');


    //event_attendance
    Route::resource('event_attendance', 'EventAttendanceController');


    //project
    Route::resource('project', 'ProjectController');

    //OverTime
    Route::post('over_times/deletes', ['as' => 'over_times.deletes', 'uses' => 'OverTimeController@deletes']);
    Route::resource('over_times', 'OverTimeController');

    // Ask Permission
    Route::post('approve_permission/deletes', ['as' => 'approve_permission.deletes', 'uses' => 'ApprovePermissionController@deletes']);
    Route::resource('approve_permission', 'ApprovePermissionController');


    //feedback
    Route::resource('feedback', 'FeedbackController');

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
    // Statistical Day Off Excel
    Route::get('/thong-ke-ngay-nghi', 'DayOffController@statisticalDayOffExcel')->name('statistical-day-off-excel');


    //report
    Route::resource('report', 'ReportController');

    //config
    Route::get('configs', 'ConfigController@index')->name('configs.index');
    Route::post('configs', 'ConfigController@store')->name('configs.store');
    Route::get('configs-dayoff', 'ConfigController@dayoffCreate')->name('configs.dayoff');
    Route::get('configs-dayoff-delete', 'ConfigController@dayoffDelete')->name('configs.delete_dayoff');
    Route::get('configs-dayadd', 'ConfigController@additionalDateCreate')->name('configs.dayadd');
    Route::get('configs-dayadd-delete', 'ConfigController@additionalDateDelete')->name('configs.delete_dayadd');

    //post
    Route::post('posts/deletes', ['as' => 'posts.deletes', 'uses' => 'PostController@deletes']);
    Route::resource('posts', 'PostController');

    //event
    Route::post('events/deletes', ['as' => 'events.deletes', 'uses' => 'EventController@deletes']);
    Route::resource('events', 'EventController');
    Route::get('events/detail/{id}', 'EventController@detailEvent')->name('events.detailEvent');
    Route::get('events/dowload-excel-list-user/{id}', 'EventController@dowloadExcelListUserJoin')->name('events.dowloadExcelListUserJoin');

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

    //register work time
    Route::post('work_time_register/deletes', ['as' => 'work_time_register.deletes', 'uses' => 'WorkRegisterController@deletes']);
    Route::resource('work_time_register', 'WorkRegisterController');

    //statistic work time
    Route::post('work_time_statistic/deletes', ['as' => 'work_time_statistic.deletes', 'uses' => 'StatisticController@deletes']);
    Route::get('work_time_statistic/export', ['as' => 'work_time_statistic.export', 'uses' => 'StatisticController@export']);
    Route::resource('work_time_statistic', 'StatisticController');
    //rooms
    Route::post('meeting_rooms/deletes', ['as' => 'meeting_rooms.deletes', 'uses' => 'MeetingRoomController@deletes']);
    Route::resource('meeting_rooms', 'MeetingRoomController');

    // manager-group
    Route::resource('group', 'GroupController');
    Route::post('group/deletes', ['as' => 'group.deletes', 'uses' => 'GroupController@deletes']);

    // suggestions
    Route::resource('suggestions', 'SuggestionController');
    Route::post('suggestions/deletes', ['as' => 'suggestions.deletes', 'uses' => 'SuggestionController@deletes']);
    Route::get('suggestions/detail/{id}', 'SuggestionController@detailSuggestions')->name('events.suggestions');


});
