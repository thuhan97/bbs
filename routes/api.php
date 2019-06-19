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
    'as' => 'api::',
//    'middleware' => ['auth'],
], function () {
    Route::post('/login', 'AuthController@login')->name('login');

    Route::group([
        'middleware' => ['jwt.auth'],
    ], function () {
        Route::get('/users', 'UserController@index')->name('users');
        Route::get('/users/{id}', 'UserController@detail')->name('users_detail');

        Route::get('/punishes', 'PunishController@index')->name('punishes');

        Route::get('/events', 'EventController@index')->name('events');
        Route::get('/events/{id}', 'EventController@detail')->name('events_detail');

        Route::get('/posts', 'PostController@index')->name('posts');
        Route::get('/posts/{id}', 'PostController@detail')->name('posts_detail');

        Route::get('/reports', 'ReportController@index')->name('reports');
        Route::get('/reports/{id}', 'ReportController@detail')->name('reports_detail');

        Route::get('/projects', 'ProjectController@index')->name('projects');
        Route::get('/projects/{id}', 'ProjectController@detail')->name('projects_detail');
    });
});
