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
    $breadcrumbs->push(__l('Post'), route('regulation'));
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

// Dashboard > Profile
Breadcrumbs::register('_personal', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('personal_brief'), route('personal'));
});

Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('Profile'), route('profile'));
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
// Dashboard > day_off
Breadcrumbs::register('day_off', function ($breadcrumbs) {
    $breadcrumbs->parent('personal');
    $breadcrumbs->push(__l('day_off'), route('day_off'));
});
// Admin
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push(__l('admin_page'), route('admin::index'));
});

// Admin / {Resource} / {List|Edit|Create}
$resources = [
    'admins' => 'Trang quản trị',
    'users' => 'Quản lý nhân viên',
    'events' => 'Quản lý sự kiện',
    'posts' => 'Quản lý thông báo',
    'regulations' => 'Nội quy, quy định',
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
    Breadcrumbs::register($resource .'.show', function ($breadcrumbs,  $id) use ($resource) {
        $breadcrumbs->parent($resource);
        $breadcrumbs->push('Chi tiết', route($resource . '.show', $id));
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