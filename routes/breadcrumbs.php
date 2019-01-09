<?php

// Dashboard
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard::index'));
});

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__l('Home'), route('default'));
});

// Home > Event
Breadcrumbs::register('event', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('Event'), route('event'));
});

// Home > Post
Breadcrumbs::register('post', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('Post'), route('post'));
});

// Home > Report
Breadcrumbs::register('report', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__l('Report'), route('report'));
});

// Dashboard > Profile
Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Thiết lập cá nhân', route('profile'));
});
Breadcrumbs::register('change_password', function ($breadcrumbs) {
    $breadcrumbs->parent('profile');
    $breadcrumbs->push('Đổi mật khẩu', route('changePassword'));
});

// Admin
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push('Trang quản trị', route('admin::index'));
});

// Admin / {Resource} / {List|Edit|Create}
$resources = [
    'admins' => 'Trang quản trị',
    'users' => 'Quản lý nhân viên',
    'events' => 'Quản lý sự kiện',
    'posts' => 'Quản lý thông báo',
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
}

Breadcrumbs::register('admin::questions.import', function ($breadcrumbs, $data) {
    $breadcrumbs->parent('admin::question-sets');
    $breadcrumbs->push('Import questions', route('admin::questions.import', ['id' => $data['id']]));
});

Breadcrumbs::register('admin::question-sets.import', function ($breadcrumbs) {
    $breadcrumbs->parent('admin::question-sets');
    $breadcrumbs->push('Import', route('admin::question-sets.import'));
});