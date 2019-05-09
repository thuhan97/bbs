<?php

// Dashboard
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard::index'));
});

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__l('Home'), route('default'));
});

Breadcrumbs::register('personal', function ($breadcrumbs) {
    $breadcrumbs->push(\Auth::user()->name, route('personal'));
});
Breadcrumbs::register('contact', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('contact'), route('contact'));
});
// Home > Post
Breadcrumbs::register('regulation', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('regulation'), route('regulation'));
});
Breadcrumbs::register('regulation_search', function ($breadcrumbs, $search) {
    $breadcrumbs->parent('regulation');
    $breadcrumbs->push(__l('search_with', ['key' => $search]), route('regulation'));
});
Breadcrumbs::register('regulation_detail', function ($breadcrumbs, $regulation) {
    $breadcrumbs->parent('regulation');
    $breadcrumbs->push($regulation->name, route('regulation_detail', ['id' => $regulation->id]));
});
// Home > Event
Breadcrumbs::register('event', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('Event'), route('event'));
});

Breadcrumbs::register('event_search', function ($breadcrumbs, $search) {
    $breadcrumbs->parent('event');
    $breadcrumbs->push(__l('search_with', ['key' => $search]), route('event'));
});
Breadcrumbs::register('event_detail', function ($breadcrumbs, $event) {
    $breadcrumbs->parent('event');
    $breadcrumbs->push($event->name, route('event_detail', ['id' => $event->id]));
});
// Home > Post
Breadcrumbs::register('post', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('Post'), route('post'));
});
// Home > over_times
Breadcrumbs::register('over_times', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('over_times'), route('over_times'));
});
Breadcrumbs::register('post_search', function ($breadcrumbs, $search) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push(__l('search_with', ['key' => $search]), route('post'));
});
Breadcrumbs::register('post_detail', function ($breadcrumbs, $post) {
    $breadcrumbs->parent('post');
    $breadcrumbs->push($post->name, route('post_detail', ['id' => $post->id]));
});
// Home > Report
Breadcrumbs::register('report', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('Report'), route('report'));
});
Breadcrumbs::register('report_create', function ($breadcrumbs) {
    $breadcrumbs->parent('report');
    $breadcrumbs->push(__l('Report_create'), route('create_report'));
});
//Home > Project
Breadcrumbs::register('project', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('Project'), route('project'));
});
Breadcrumbs::register('project_detail', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('project');
    $breadcrumbs->push($project->name, route('project_detail', ['id' => $project->id]));

});
Breadcrumbs::register('project_create', function ($breadcrumbs) {
    $breadcrumbs->parent('project');
    $breadcrumbs->push(__l('create_project'), route('create_project'));

});
//Home > Meeting Room
Breadcrumbs::register('meetings', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('meetings'), route('meetings'));
});
// Dashboard > Profile
Breadcrumbs::register('_personal', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('personal_brief'), route('personal'));
});

Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('Profile'), route('profile'));
});
Breadcrumbs::register('punish', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('Punish'), route('punish'));
});

Breadcrumbs::register('change_password', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('change_password'), route('changePassword'));
});
// Dashboard > work_time
Breadcrumbs::register('work_time', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('work_time'), route('work_time'));
});
// Dashboard > ask_permission
Breadcrumbs::register('ask_permission', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('ask_permission'), route('ask_permission'));
});
// Dashboard > list_share_document
Breadcrumbs::register('list_share_document', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('list_share_document'), route('list_share_document'));
});
// Dashboard > list_suggestions
Breadcrumbs::register('list_suggestions', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('list_suggestions'), route('list_suggestions'));
});
// Dashboard > share_experience
Breadcrumbs::register('share_experience', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('share_experience'), route('share_experience'));
});
// Dashboard > day_off
Breadcrumbs::register('day_off', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('day_off'), route('day_off'));
});
// Dashboard > day_off_approval
Breadcrumbs::register('day_off_approval', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('day_off_approval'), route('day_off_approval'));
});

// Admin
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push(__l('admin_page'), route('admin::index'));
});

// Dashboard > day_off_approval
Breadcrumbs::register('work_time_statistic', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('day_off_approval'), route('admin::work_time_statistic'));
});


// Admin / {Resource} / {List|Edit|Create}
$resources = [
    'admins' => 'Trang quản trị',
    'configs' => 'Thiết lập hệ thống',
    'users' => 'Quản lý nhân viên',
    'events' => 'Quản lý sự kiện',
    'posts' => 'Quản lý thông báo',
    'regulations' => 'Nội quy, Quy định',
    'teams' => 'Quản lý nhóm',
    'day_offs' => 'Quản lý nghỉ phép',
    'work_times' => 'Quản lý làm việc',
    'over_times' => 'Duyệt OT',
    'approve_permission' => 'Xin phép',
    'work_time_register' => 'Đăng ký thời gian làm việc',
    'projects' => 'Quản lý dự án',
    'devices' => 'Quản lý thiết bị',
    'deviceusers' => 'Quản lý thiết bị',
    'work_time_statistic' => 'Thống kê thời gian làm việc',
    'meetings' => 'Phòng họp',
    'rules' => 'Quy định tiền phạt',
    'punishes' => 'Danh sách tiền phạt',
];
foreach ($resources as $resource => $data) {
    $parent = 'admin';
    $title = $data;
    if (is_array($data)) {
        $title = $data['title'];
        $parent = $data['parent'];
    }
    $resource = 'admin::' . $resource;

    // List
    Breadcrumbs::register($resource, function ($breadcrumbs) use ($resource, $title, $parent) {
        $breadcrumbs->parent($parent);
        $breadcrumbs->push($title, route($resource . '.index'));
    });
    // Create
    Breadcrumbs::register($resource . '.create', function ($breadcrumbs) use ($resource) {
        $breadcrumbs->parent($resource);
        $breadcrumbs->push('Tạo mới', route($resource . '.create'));
    });
    // Edit
    Breadcrumbs::register($resource . '.edit', function ($breadcrumbs, $id) use ($resource) {
        $breadcrumbs->parent($resource);
        $breadcrumbs->push('Sửa', route($resource . '.edit', $id));
    });
    // Detail
    Breadcrumbs::register($resource . '.show', function ($breadcrumbs, $id) use ($resource) {
        $breadcrumbs->parent($resource);
        $breadcrumbs->push('Chi tiết', route($resource . '.show', $id));
    });
    Breadcrumbs::register($resource . '.deletes', function ($breadcrumbs, $id) use ($resource) {
        $breadcrumbs->parent($resource);
        $breadcrumbs->push('Xóa', route($resource . '.deletes', $id));
    });

}

Breadcrumbs::register('admin::day_offs.user', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('admin::day_offs');
    $breadcrumbs->push($user->name, route('admin::day_offs.user', ['id' => $user->id]));
});

Breadcrumbs::register('admin::work_times.import', function ($breadcrumbs) {
    $breadcrumbs->parent('admin::work_times');
    $breadcrumbs->push('Nhập dữ liệu từ máy chấm công', route('admin::work_times.import'));
});
