<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'file-manager', 'middleware' => ['admin'], 'as' => 'unisharp.lfm.'], function () {
    $namespace = '\\UniSharp\\LaravelFilemanager\\Controllers\\';
    // display main layout
    Route::get('/', [
        'uses' => $namespace . 'LfmController@show',
        'as' => 'show',
    ]);
    // display integration error messages
    Route::get('/errors', [
        'uses' => $namespace . 'LfmController@getErrors',
        'as' => 'getErrors',
    ]);
    // upload
    Route::any('/upload', [
        'uses' => $namespace . 'UploadController@upload',
        'as' => 'upload',
    ]);
    // list images & files
    Route::get('/jsonitems', [
        'uses' => $namespace . 'ItemsController@getItems',
        'as' => 'getItems',
    ]);
    Route::get('/move', [
        'uses' => $namespace . 'ItemsController@move',
        'as' => 'move',
    ]);
    Route::get('/domove', [
        'uses' => $namespace . 'ItemsController@domove',
        'as' => 'domove'
    ]);
    // folders
    Route::get('/newfolder', [
        'uses' => $namespace . 'FolderController@getAddfolder',
        'as' => 'getAddfolder',
    ]);
    // list folders
    Route::get('/folders', [
        'uses' => $namespace . 'FolderController@getFolders',
        'as' => 'getFolders',
    ]);
    // crop
    Route::get('/crop', [
        'uses' => $namespace . 'CropController@getCrop',
        'as' => 'getCrop',
    ]);
    Route::get('/cropimage', [
        'uses' => $namespace . 'CropController@getCropimage',
        'as' => 'getCropimage',
    ]);
    Route::get('/cropnewimage', [
        'uses' => $namespace . 'CropController@getNewCropimage',
        'as' => 'getCropimage',
    ]);
    // rename
    Route::get('/rename', [
        'uses' => $namespace . 'RenameController@getRename',
        'as' => 'getRename',
    ]);
    // scale/resize
    Route::get('/resize', [
        'uses' => $namespace . 'ResizeController@getResize',
        'as' => 'getResize',
    ]);
    Route::get('/doresize', [
        'uses' => $namespace . 'ResizeController@performResize',
        'as' => 'performResize',
    ]);
    // download
    Route::get('/download', [
        'uses' => $namespace . 'DownloadController@getDownload',
        'as' => 'getDownload',
    ]);
    // delete
    Route::get('/delete', [
        'uses' => $namespace . 'DeleteController@getDelete',
        'as' => 'getDelete',
    ]);
    Route::get('/demo', $namespace . 'DemoController@index');
});

Route::get('auth/social', 'SocialAuthController@show')->name('social.login');
Route::any('auth/{driver}', 'SocialAuthController@redirectToProvider')->name('social.oauth');
Route::any('auth/{driver}/callback', 'SocialAuthController@handleProviderCallback')->name('social.callback');

Auth::routes();
Route::any('logout', 'Auth\LoginController@logout')->name('logout');

Route::group([
    'middleware' => ['auth'],
], function () {
    Route::any('/', 'HomeController@index')->name('default');
    Route::get('/trang-chu', 'HomeController@index');

    Route::get('/ca-nhan', 'UserController@index')->name('personal');
    Route::get('/thiet-lap-ca-nhan', 'UserController@profile')->name('profile');
    Route::get('/danh-ba', 'UserController@contact')->name('contact');
    Route::get('/doi-mat-khau', 'UserController@changePassword')->name('changePassword');
    Route::get('/thoi-gian-lam-viec', 'UserController@workTime')->name('work_time');
    Route::get('/ngay-nghi', 'UserController@dayOff')->name('day_off');

    Route::get('/su-kien', 'EventController@index')->name('event');
    Route::get('/su-kien/{id}', 'EventController@detail')->where(['id' => '\d+'])->name('event_detail');
    Route::get('/thong-bao', 'PostController@index')->name('post');
    Route::get('/thong-bao/{id}', 'PostController@detail')->where(['id' => '\d+'])->name('post_detail');
    Route::get('/bao-cao', 'ReportController@index')->name('report');
    Route::get('/bao-cao/{id}', 'ReportController@detail')->where(['id' => '\d+'])->name('report_detail');

});