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

define('IS_REMOTE_STAFF', 1);
define('UNACTIVE_STATUS', 0);
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


define('STAFF', -3);
define('BRSE', -2);
define('HEAD_DEPARTMENT_ROLE', -1);
define('HCNS', 0);
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
    0 => 'Lập trình viên',
    1 => 'Kỹ sư cầu nối',
    2 => 'Manager',
    3 => 'Giám đốc',
    4 => 'Chuyên viên',
    5 => 'Comtor',
    6 => 'Tester',
]);

define('SEXS', [
    '' => 'Không xác định',
    1 => 'Nữ',
    0 => 'Nam',
]);

define('WORK_TIME_QUICK_SELECT', [
    1 => 'Full sáng',
    2 => 'Full chiều',
]);

define('WORK_TIME_SELECT', [
    0 => 'Không làm',
    1 => 'Sáng',
    2 => 'Chiều',
    3 => 'Cả ngày',
]);

define('PART_OF_THE_DAY', [
    'mon',
    'tue',
    'wed',
    'thu',
    'fri',
    'sat',
]);
define('PART_OF_THE_DAY_NAME', [
    'mon' => 'Thứ 2',
    'tue' => 'Thứ 3',
    'wed' => 'Thứ 4',
    'thu' => 'Thứ 5',
    'fri' => 'Thứ 6',
    'sat' => 'Thứ 7',
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

define('EVENT_JOIN_STATUS', 1);

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

define('DATE', 'ngày');
//define('MONTH', 'tháng');
define('WEEK', 'tuần');
define('COUNT', ' buổi');
define('ICONS_TYPES_FILES', [
    'jpg' => 'far fa-image',
    'jpeg' => 'far fa-image',
    'gif' => 'far fa-image',
    'tiff' => 'far fa-image',
    'png' => 'far fa-image',
    'psd' => 'far fa-image',
    'pdf' => 'fa fa-file-pdf',
    'doc' => 'fa fa-file-word',
    'docx' => 'fa fa-file-word',
    'zip' => 'fa fa-file-archive',
    'jar' => 'fa fa-file-archive',
    'rar' => 'fa fa-file-archive',
    'xlsx' => 'fa fa-file-excel',
    'xls' => 'fa fa-file-excel',
    'pptx' => 'fa fa-file-powerpoint',
    'mp4' => 'fas fa-file-video',
    'm4v' => 'fas fa-file-video',
    'avi' => 'fas fa-file-video',
    'mov' => 'fas fa-file-video',
    'mp3' => 'fas fa-file-audio',
    'php' => 'far fa-file-code',
    'html' => 'far fa-file-code',
    'css' => 'far fa-file-code',
    'js' => 'far fa-file-code',
    'sql' => 'far fa-file-code',
]);

define('SHARE_DOCUMENT', 2);
define('SHARE_EXPERIENCE', 1);

define('VACATION', [
    2 => 'Nghỉ đám cưới',
    3 => 'Nghỉ đám hiếu',
    4 => 'Nghỉ thai sản',
]);

define('VACATION_FULL', [
    1 => 'Lý do cá nhân',
    2 => 'Nghỉ đám cưới',
    3 => 'Nghỉ đám hiếu',
    4 => 'Nghỉ thai sản',
]);

define('DAILY_REPORT', 0);
define('WEEKLY_REPORT', 1);

define('MONTH', [
    '01' => 'Tháng 1',
    '02' => 'Tháng 2',
    '03' => 'Tháng 3',
    '04' => 'Tháng 4',
    '05' => 'Tháng 5',
    '06' => 'Tháng 6',
    '07' => 'Tháng 7',
    '08' => 'Tháng 8',
    '09' => 'Tháng 9',
    '10' => 'Tháng 10',
    '11' => 'Tháng 11',
    '12' => 'Tháng 12',
]);
define('SHOW_DAY_OFFF', [
    0 => 'Chờ Duyệt',
    1 => 'Đã duyệt',
    2 => 'Không duyệt',
    3 => 'Tất cả đơn'
]);

define('STATUS_DAY_OFF', [
    'abide' => 0,
    'active' => 1,
    'noActive' => 2
]);
define('SEX', [
    'male' => 0,
    'female' => 1
]);
define('WORK_TIME_TYPE', [
    0 => 'Bình thường',
    1 => 'Đi muộn',
    2 => 'Về Sớm',
    4 => 'Overtime',
]);
define('OT_STATUS', [
//    -1 => 'Từ chối',
    0 => 'Chưa duyệt',
    1 => 'Đã duyệt',
    2 => 'Từ chối',
]);

define('WORK_TIME_OT_STATUS', [
    ' Chưa duyệt' => 0,
    'Đã duyệt' => 1
]);

define('PUNISH_SUBMIT', [
    'new' => 0,
    'submitted' => 1
]);

define('PUNISH_SUBMIT_NAME', [
    0 => 'Chưa nộp',
    1 => 'Đã nộp'
]);
define('REPORT_TYPE_WEEKLY', 0);
define('REPORT_TYPE_DAILY', 1);

define('REPORT_TYPES', [
    0 => 'tuần',
    1 => 'ngày',
]);

define('REPORT_SEARCH_TYPE_NAME', [
    0 => 'Cá nhân',
    1 => 'Tất cả công ty',
    2 => 'Xem theo team',
]);
define('REPORT_SEARCH_TYPE', [
    'private' => 0,
    'all' => 1,
    'team' => 2
]);

define('EXPORT_PATHS', [
    'admin/work_times',
    'admin/over_times',
    'admin/approve_permission'
]);
//define('OVER_TIME_EXPORT_PATHS', [
//    'admin/over_times'
//]);

define('LATE_MONEY_CONFIG_FOLDER', 'json_config/');
define('PROJECT_IMAGE_FOLDER', 'projects');
define('LATE_MONEY_CONFIG', 'config/late_time.json');
define('LATE_RULE_ID', 0);

define('ALL_DAY_OFF', 3);
define('DAY_OFF_FREE_DEFAULT', 0);
define('DAY_OFF_FREE_ACTIVE', 1);
define('PAGINATE_DAY_OFF', 20);
define('DAY_OFF_DEFAULT', 0);
define('TOTAL_MONTH', 12);
define('PRE_YEAR', 1);
define('PRE_PRE_YEAR', 2);
define('XLS_TYPE', '.xls');
define('ADD_DAY_OFF_MONTH', 1);
define('STT', 'Stt');
define('ON_TIME', 'Danh sách đi làm đúng giờ');
define('LATE_EARLY', 'Danh sách đi làm muộn/sớm');
define('OT', 'Danh sách OT');
define('LATE_OT', 'Danh sách đi làm muộn + OT');
define('LEAVE', 'Xin nghỉ');
define('USER_NAME', 'Tên thành viên');
define('TIME_STA', 'Thời gian thống kê');
define('ON_TIME_USER', 'Đi làm đúng giờ');
define('LATE_EARLY_USER', 'Đi làm muộn/sớm');
define('OT_USER', 'OT');
define('LATE_OT_USER', 'Đi làm muộn + OT');
define('TOTAL_MONTH_IN_YEAR', 12);
define('OFF_TIME', '00:00:00');
define('SWITCH_TIME', '12:00:00');
define('DAY_OFF_MONTH', [
    'day_off_month_Jan' => 1,
    'day_off_month_Feb' => 2,
    'day_off_month_Mar' => 3,
    'day_off_month_Apr' => 4,
    'day_off_month_May' => 5,
    'day_off_month_Jun' => 6,
    'day_off_month_Jul' => 7,
    'day_off_month_Aug' => 8,
    'day_off_month_Sep' => 9,
    'day_off_month_Oct' => 10,
    'day_off_month_Nov' => 11,
    'day_off_month_Dec' => 12,
]);
define('DEFAULT_VALUE', 0);
define('WORKTIME_COST_OFF', 0);
define('WORKTIME_COST_HAFT', 0.5);
define('WORKTIME_COST_FULL', 1);
define('HAFT_HOUR', '12:00');
define('HAFT_MORNING', '10:00');
define('HAFT_AFTERNOON', '15:30');
define('DEFAULT_INSERT_ROW_EXCEL', 1);
define('SIZE_TEXT_EXCEL_DAY_OFF', 25);
define('NUMBER_COUNT_DAY_OFF', 2);
define('TOTAL_DAY_OFF_IN_MONTH', 2);
define('REMAIN_DAY_OFF_DEFAULT', 1);
define('XLSX_TYPE', '.xlsx');
define('STATISTICAL_DAY_OFF_NAME', 'Thống kê phép năm');
define('DAY_OFF_INCREMENT', 1);
define('NEXT_YEAR', 1);

define('OT_TYPE', [
    1 => 'Dự án',
    2 => 'OT lý do cá nhân',
]);

define('CHECK_TIME_DAY_OFF_START_DATE', '08:00:00');
define('CHECK_TIME_DAY_OFF_HALT_DATE', '12:00:00');
define('CHECK_TIME_DAY_OFF_END_DATE', '18:00:00');
define('CHECK_TIME_DAY_OFF', ['AM', 'PM']);
define('CHECK_TIME_DAY_OFF_USABLE_START', ['00:00:00', '12:00:00']);
define('CHECK_TIME_DAY_OFF_USABLE_END', ['00:00:00', '23:00:00']);
define('CHECK_TIME_DAY_OFF_USABLE', [
    '08:00:00' => '00:00:00',
    '12:00:00' => '12:00:00',
    '18:00:00' => '24:00:00',
]);
define('DAY_OFF_TITLE_DEFAULT', 1);
define('ARRAY_TITLE_DAYOFF_VACATION_MODE', [2, 3, 4]);
define('GROUPS', [
    1 => 'PHP 1',
    2 => 'PHP 2',
    3 => 'Mobile',
    4 => 'Hành chính nhân sự',
]);
define('SPACE', ' ');
define('HALF_MONTH', 15);

define('HOURS_OF_DAY', 24);
define('TOTAL_COUNT_DAY_OFF', 10);
define('DATE_FORMAT_DAY_OFF', 'Y/m/d H:i:s');

define('SUN', 'Sun');
define('SAT', 'Sat');

define('INT_HALT_DATE', 12);
define('ONE_HOURS', 1);
define('JANUARY', 1);
define('DECEMBER', 12);
define('EXCEL_COLUMNS', ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']);
define('EXCEL_COLUMN_LENGTH', 26);

define('REPORT_DRAFT', 0);
define('REPORT_PUBLISH', 0);
define('REPORT_PRIVATE', 1);
define('APPROVE_SUGGESTION', 1);
define('NOT_APPROVE_SUGGESTION', 0);
define('TIME_END_DATE','24:00:00');
define('TIME_FORMAT','H:i:s');






