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

define('ACTIVE_STATUS', 1);

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


define('JOB_TITLES', [
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
    0 => 'Sáng',
    1 => 'Chiều',
    2 => 'Không làm',
    3 => 'Cả ngày'
]);

define('PART_OF_THE_DAY', [
    'mon',
    'tue',
    'wed',
    'thu',
    'fri',
    'sat',
]);

define('WORK_PATH', [
    0 => [
        'start_at' => '08:00:00',
        'end_at' => '12:00:00'
    ],
    1 => [
        'start_at' => '13:30:00',
        'end_at' => '17:30:00'
    ],
    2 => [
        'start_at' => 0,
        'end_at' => 0
    ],
    3 => [
        'start_at' => '08:00:00',
        'end_at' => '17:30:00'
    ]
]);
