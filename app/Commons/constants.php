<?php

define('ADMIN_GUARD', 'admin');
define('API_GUARD', 'api');

define('INVITE_POTATO', 100);
define('POTATO_EXPRIRE_DEFAULT', 6);
define('DAY_OFF_TOTAL', 12);
define('MAX_SEARCH_RETRY', 10);
define('DEFAULT_PAGE_SIZE', 20);
define('REPORT_PAGE_SIZE', 30);
define('PAGE_LIST', [10, 20, 50, 100]);

define('MESSAGE', 'message');
define('SEARCH', 'search');
define('EMAIL', 'email');
define('ALPHANUM', 'alphanum');

define('DESC', 'desc');
define('ASC', 'asc');

define('TABLE', 'table');
define('CREATED_AT', 'created_at');
define('UPDATED_AT', 'updated_at');
define('DELETED_AT', 'deleted_at');
define('NO_TRANSCRIPT_FOUND', '-1');
define('UTC', 'UTC');

define('DATE_FORMAT', 'Y-m-d');
define('DATE_FORMAT_SLASH', 'Y/m/d');
define('DATE_MONTH_REPORT', 'd/m');
define('DATE_TIME_FORMAT', 'Y-m-d H:i:s');
define('DATE_TIME_FORMAT_SHORT', 'Y-m-d H:i');
define('LANG_JP', 'ja');
define('LANG_EN', 'en');
define('LANG_VN', 'vi');

define('EXPIRE_POTATO_DEFAULT', 6);

define('URL_IMAGE_NO_IMAGE', '/dist/img/no-avatar.png');
define('UPLOAD_PATH', '/uploads');
define('URL_IMAGE_AVATAR', UPLOAD_PATH . '/avatar/');
define('URL_IMAGE_PROJECT', 'adminlte/img/projects_img/');

define('ACTIVE_STATUS', 1);
define('ACTIVE_NOTIFY', 1);

define('MORE_LANG', [
//    'zh',
]);
define('MIN_APPROVE_JOB', 2);

define('REGION_CODE_BY_LANG', [
    'ja' => 'JP',
    'en' => 'US',
    'vi' => 'VN',
]);

define('CONTRACT_TYPES', [
    'staff' => 0,
    'probation' => 1,
    'parttime' => 2,
    'internship' => 3,
]);

define('CONTRACT_TYPES_NAME', [
    0 => 'Chính thức',
    1 => 'Thử việc',
    2 => 'Partime',
    3 => 'Thực tập',
]);

define('HEAD_DEPARTMENT_ROLE', -1);
define('TEAMLEADER_ROLE', 1);
define('MANAGER_ROLE', 2);
define('MASTER_ROLE', 3);

define('JOB_TITLES', [
    -1 => 'Trưởng phòng',
    0 => 'Chuyên viên',
    1 => 'Team leader',
    2 => 'Manager',
    3 => 'Giám đốc',
]);

define('POSITIONS', [
    0 => 'Chuyên viên',
    1 => 'Kỹ sư cầu nối',
    2 => 'Manager',
    3 => 'Giám đốc',
]);

define('SEXS', [
    '' => 'Không xác định',
    1 => 'Nữ',
    0 => 'Nam',
]);

define('WORK_TIME_QUICK_SELECT', [
    0 => 'Full sáng',
    1 => 'Full chiều',
]);

define('WORK_TIME_SELECT', [
    0 => 'Cả ngày',
    1 => 'Sáng',
    2 => 'Chiều',
    3 => 'Không làm'
]);

define('PART_OF_THE_DAY', [
    'mon',
    'tue',
    'wed',
    'thu',
    'fri',
    'sat',
]);

define('STATUS_PROJECT', [
    0 => 'Chưa bắt đầu',
    1 => 'Đang phát triển',
    2 => 'Đã kết thúc',
]);

define('COLOR_STATUS_PROJECT', [
    0 => 'color:blue',
    1 => 'color:orange',
    2 => 'color:green',
]);
define('PROJECT_TYPE', [
    0 => 'ODC',
    1 => 'Trọn gói',
]);


define('STATUS_JOIN_EVENT', [
    0 => 'Không tham gia',
    1 => 'Tham gia',
]);

define('NOT_AUTHENTICATED', 'Tài khoản không hợp lệ');
define('NOT_AUTHORIZED', 'Tài khoản không đủ thẩm quyền');

define('TYPES_DEVICE', [
    0 => 'Case',
    1 => 'Màn hình',
    2 => 'Chuột',
    3 => 'Bàn phím',
    4 => 'Điện thoại',
    5 => 'Máy tính bảng',
    6 => 'Khác'
]);
define('VACATION', [
    1 => 'Lý do cá nhân',
    2 => 'Nghỉ đám cưới',
    3 => 'Nghỉ đám hiếu',
]);


define('DAILY_REPORT', 0);
define('WEEKLY_REPORT', 1);

define('MONTH', [
    1 => 'Tháng 1',
    2 => 'Tháng 2',
    3 => 'Tháng 3',
    4 => 'Tháng 4',
    5 => 'Tháng 5',
    6 => 'Tháng 6',
    7 => 'Tháng 7',
    8 => 'Tháng 8',
    9 => 'Tháng 9',
    10 => 'Tháng 10',
    11 => 'Tháng 11',
    12 => 'Tháng 12',


]);
