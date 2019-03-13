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

Route::group([
    'prefix' => 'v1',
//    'middleware' => ['auth'],
], function () {
    Route::get('/events', 'EventController@index')->name('api_events');
    Route::get('/events/calendar', 'EventController@calendar')->name('api_events_calendar');

    Route::post('/deviceusers/get-devices', 'DeviceUserController@getDevices')->name('deviceusers.getDevices');
});
