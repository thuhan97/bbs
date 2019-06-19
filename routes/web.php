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

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::any('logout', 'Auth\LoginController@logout')->name('logout');

Route::group([
    'middleware' => ['auth', 'activity'],
], function () {
    Route::any('/', 'HomeController@index')->name('default');
    Route::get('/trang-chu', 'HomeController@index');

    Route::get('/ca-nhan', 'UserController@index')->name('personal');
    Route::get('/thiet-lap-ca-nhan', 'UserController@profile')->name('profile');
    Route::post('/thiet-lap-ca-nhan', 'UserController@saveProfile')->name('save_profile');
    Route::get('/danh-ba', 'UserController@contact')->name('contact');
    Route::get('/doi-mat-khau', 'UserController@changePassword')->name('changePassword');
    Route::post('/doi-mat-khau', 'UserController@updatePassword')->name('update_password');
    Route::get('/thoi-gian-lam-viec', 'UserController@workTime')->name('work_time');
    Route::get('/thoi-gian-lam-viec-api', 'UserController@workTimeAPI')->name('work_time_api');
//    Route::post('/ngay-nghi/create-calendar', 'UserController@dayOffCreateCalendar')->name('day_off_create_calendar');
    Route::post('/thoi-gian-lam-viec/xin-phep', 'UserController@workTimeAskPermission')->name('work_time.ask_permission');
//    Route::post('/thoi-gian-lam-viec/xin-phep-ot', 'UserController@workTimeAskPermissionOT')->name('work_time.ask_permission_ot');
    Route::post('/thoi-gian-lam-viec/xin-phep-ve-som', 'UserController@workTimeAskPermissionEarly')->name('work_time.ask_permission_early');
    Route::get('/thoi-gian-lam-viec/xin-di-muon', 'UserController@workTimeDetailAskPermission')->name('work_time.detail_ask_permission');
    Route::get('/thoi-gian-lam-viec/du-an', 'UserController@workTimeGetProject')->name('work_time.get_project');
    Route::get('/ngay-nghi', 'UserController@dayOff')->name('day_off')->middleware('delete.cache');
    Route::get('xin-phep', 'UserController@askPermission')->name('ask_permission');
    Route::get('xin-phep/early', 'UserController@askPermissionEarly')->name('ask_permission.early');
    Route::get('xin-phep/ot', 'UserController@askPermissionModal')->name('ask_permission.modal');
    Route::get('xin-phep/create', 'UserController@askPermissionCreate')->name('ask_permission.create');
    Route::get('xin-phep/chi-tiet-don', 'UserController@approveDetail')->name('ask_permission.approveDetail')->middleware('can:manager');
    Route::post('xin-phep/phe-duyet', 'UserController@approvePermission')->name('ask_permission.approvePermission')->middleware('can:manager');
    Route::post('phe-duyet-xin-phep', 'UserController@approved')->name('approved')->middleware('can:manager');
    Route::post('phe-duyet-xin-phep-ot', 'UserController@approvedOT')->name('approvedOT')->middleware('can:manager');
    /* Route::post('/ngay-nghi/create-api', 'UserController@dayOffCreate_API')->name('day_off_createAPI');*/
    Route::get('/ngay-nghi/list-approval-api', 'UserController@dayOffListApprovalAPI')->name('day_off_listApprovalAPI');
    Route::get('/phe-duyet-ngay-nghi', 'UserController@dayOffApprove')->name('day_off_approval');
    Route::post('/phe-duyet-ngay-nghi/approve-api', 'UserController@dayOffApprove_AcceptAPI')->name('day_off_approval_approveAPI');
    Route::post('/phe-duyet-ngay-nghi/one/{id}', 'UserController@dayOffApprove_get')->name('day_off_approval_one');
    Route::get('/ngay-nghi/{status?}', 'UserController@dayOff')->name('day_off');
    Route::get('/phe-duyet-ngay-nghi/', 'UserController@dayOffApprove')->name('day_off_approval');

    Route::get('/hien-thi-ngay-nghi/{status}', 'UserController@dayOffShow')->name('day_off_show');
    Route::get('/tim-kiem-ngay-nghi/', 'UserController@dayOffSearch')->name('day_off_search');
    Route::get('/chi-tiet-ngay-nghi/{id?}/{check?}', 'UserController@dayOffDetail')->name('day_off_detail');
    Route::post('/chinh-sua-ngay-nghi/{id?}', 'UserController@editDayOffDetail')->name('edit_day_off_detail');
    Route::post('/xoa-don-xin-nghi/', 'UserController@deleteOrCloseDayOff')->name('delete_day_off');

    Route::get('/tien-phat', 'PunishesController@index')->name('punish');
    Route::get('/noi-quy-quy-dinh', 'RegulationController@index')->name('regulation');
    Route::get('/noi-quy-quy-dinh/{id}', 'RegulationController@detail')->where(['id' => '\d+'])->name('regulation_detail');
    Route::get('/tai-noi-quy-quy-dinh/{id}', 'RegulationController@download')->where(['id' => '\d+'])->name('regulation_download');
    Route::get('/su-kien', 'EventController@index')->name('event');
    Route::get('/events', 'EventController@getCalendar')->name('getCalendar');
    Route::get('/lich-su-kien', 'EventController@calendar')->name('event_calendar');
    Route::get('/su-kien/{id}', 'EventController@detail')->where(['id' => '\d+'])->name('event_detail');
    Route::post('/dang-ky-su-kien', 'EventAttendanceController@joinEvent')->name('join_event');
    Route::get('/dang-ky-nhanh-su-kien/{id}', 'EventAttendanceController@quickJoinEvent')->name('quick_join_event');
    Route::get('/thong-bao', 'PostController@index')->name('post');
    Route::get('/thong-bao/{id}', 'PostController@detail')->where(['id' => '\d+'])->name('post_detail');
    Route::get('/bao-cao', 'ReportController@index')->name('report');
    Route::get('/tao-bao-cao', 'ReportController@create')->name('create_report');
    Route::get('/report', 'ReportController@getReport')->name('getReport');
    Route::post('/tao-bao-cao', 'ReportController@saveReport')->name('save_report');
    Route::get('/xoa-bao-cao/{id}', 'ReportController@deleteReport')->name('deleteReport');
    Route::post('/reply-bao-cao', 'ReportController@replyReport')->name('reply_report');
    Route::get('/bao-cao/{id}', 'ReportController@detail')->where(['id' => '\d+'])->name('report_detail');
    Route::get('/du-an', 'ProjectController@index')->name('project');
    Route::get('/tao-du-an', 'ProjectController@create')->name('create_project');
    Route::post('/tao-du-an', 'ProjectController@store')->name('store_project')->middleware('can:team-leader');
    Route::get('/du-an/{id}', 'ProjectController@detail')->where(['id' => '\d+'])->name('project_detail');
    Route::get('/sua-du-an/{id}', 'ProjectController@edit')->where(['id' => '\d+'])->name('project_edit');
    Route::post('/sua-du-an/{id}', 'ProjectController@update')->where(['id' => '\d+'])->name('project_update');
    Route::get('/project-name-unique/{id?}/{name?}', 'ProjectController@checkNameUnique')->where(['id' => '\d+'])->name('project_unique');

    Route::get('/chia-se-tai-lieu', 'ShareController@listShareDocument')->name('list_share_document');
    Route::get('/chia-se-tai-lieu', 'ShareController@listShareDocument')->name('list_share_document');
    Route::get('/chia-se-kinh-nghiem', 'ShareController@shareExperience')->name('share_experience');
    Route::get('/download_file_share/{url}', 'ShareController@downloadFileShare');
    Route::post('/add_document', 'ShareController@addDocument')->name('add_document');
    Route::post('/add_experience', 'ShareController@addExperience')->name('add_experience');
    Route::get('/deleted_experience/{id}', 'ShareController@deletedExperience')->name('deleted_experience');
    Route::get('/edit_experience/{id}', 'ShareController@editExperience')->name('edit_experience');
    Route::post('/save_edit_experience', 'ShareController@saveEditExperience')->name('save_edit_experience');
    Route::post('/add_comment', 'ShareController@addComment')->name('add_comment');
    Route::get('/kinh-nghiem-lam-viec/{id}', 'ShareController@viewExperience')->name('view_experience');

    Route::post('/add_suggestions', 'SuggestionController@addSuggestions')->name('add_suggestions');
    Route::get('/de-xuat-gop-y', 'SuggestionController@listSuggestions')->name('list_suggestions')->middleware('can:team-leader');
    Route::get('/chi-tiet-de-xuat-gop-y/{id}', 'SuggestionController@detailSuggestions')->name('detail_suggestions')->middleware('can:team-leader');
    Route::post('/approve_suggestion/', 'SuggestionController@approveSuggestion')->name('approve_suggestion')->middleware('can:manager');

    // create day off
    Route::post('/ngay-nghi/create-calendar', 'UserController@dayOffCreateCalendar')->name('day_off_create_calendar');
    Route::post('/ngay-nghi/create-calendar', 'UserController@dayOffCreateCalendar1')->name('day_off_create_calendar1');
    Route::post('/ngay-nghi/create-day-off', 'UserController@dayOffCreate')->name('day_off_create');
    Route::post('/ngay-nghi/create-day-off-vacation', 'UserController@dayOffCreatevacationVacation')->name('day_off_create_vacation');
    Route::get('/kiem-tra-ngay-phep-con-lai', 'UserController@checkUsable')->name('check-usable-day-offf');

    Route::post('/save-token', 'NotificationController@saveToken')->name('notification_save_token');
    Route::post('/enable-notification', 'NotificationController@enableNotification')->name('notification_enable_push');
    Route::post('/notification/mark-read', 'NotificationController@markRead')->name('notification_mark_read');

    Route::post('/ngay-nghi/create', 'UserController@dayOffCreate')->name('day_off_create');

    Route::get('/lich-hop', 'MeetingController@calendar')->name('meetings');
    Route::get('/get_calendar-booking', 'MeetingController@getCalendar')->name('getCalendarMeeting');
    Route::post('/them-phong-hop', 'MeetingController@booking')->name('bookings');
    Route::post('/sua-phong-hop/{id}', 'MeetingController@update')->name('update_booking');
    Route::get('/get-booking', 'MeetingController@getMeeting')->name('get_booking');
    Route::get('/delete-booking', 'MeetingController@deleteMeeting')->name('delete_booking');

    //device
    Route::get('/de-xuat-thiet-bi', 'DeviceController@index')->name('device_index');
    //device->create
    Route::post('/gui-de-xuat-thiet-bi', 'DeviceController@create')->name('device_create');
    //device->delete
    Route::post('/xoa-de-xuat-thiet-bi', 'DeviceController@delete')->name('device_delete');
    //device->edit
    Route::get('/chinh-sua-de-xuat-thiet-bi/{id?}', 'DeviceController@edit')->name('device_edit');
    //device->approval
    Route::post('/phe-duyet-de-xuat-thiet-bi/{id?}', 'DeviceController@approval')->name('device_approval');

});

Route::group([
    'prefix' => 'file-manager', 'as' => 'unisharp.lfm.',
//    'middleware' => ['auth'],

], function () {
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

