<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li class="{{ \App\Utils::checkRoute(['dashboard::index', 'admin::index']) ? 'active': '' }}">
        <a href="/admin">
            <i class="fa fa-dashboard"></i> <span>Trang quản trị</span>
        </a>
    </li>

    <li class="{{ \App\Utils::checkRoute(['admin::configs.index']) ? 'active': '' }}">
        <a href="{{ route('admin::configs.index') }}">
            <i class="fa fa-cog"></i> <span>Thiết lập hệ thống</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::users.index', 'admin::users.create', 'admin::users.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::users.index') }}">
            <i class="fa fa-user"></i> <span>Nhân viên</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::teams.index', 'admin::teams.create', 'admin::teams.edit', 'admin::teams.show']) ? 'active': '' }}">
        <a href="{{ route('admin::teams.index') }}">
            <i class="fa fa-user"></i> <span>Nhóm</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::projects.index', 'admin::projects.create', 'admin::projects.edit', 'admin::projects.show']) ? 'active': '' }}">
        <a href="{{ route('admin::projects.index') }}">
            <i class="fa fa-user"></i> <span>Dự án</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::events.index', 'admin::events.create', 'admin::events.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::events.index') }}">
            <i class="fa fa-calendar"></i> <span>Sự kiện</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::posts.index', 'admin::posts.create', 'admin::posts.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::posts.index') }}">
            <i class="fa fa-share-alt"></i> <span>Thông báo</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::regulations.index', 'admin::regulations.create', 'admin::regulations.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::regulations.index') }}">
            <i class="fa fa-podcast"></i> <span>Nội quy/Quy Định</span>
        </a>
    </li>
    <li class="treeview {{ \App\Utils::checkRoute([
    'admin::day_offs.index',
    'admin::day_offs.create',
    'admin::day_offs.edit',
    'admin::day_offs.user',
    'admin::work_times.index',
    'admin::work_times.create',
    'admin::work_times.import',
    'admin::work_times.edit',
    ]) ? 'active': '' }}">
        <a href="#"><i class="fa fa-calendar"></i> <span>Thời gian làm việc</span>
            <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin::day_offs.index') }}"><i class="fa fa-circle"></i> Nghỉ phép</a></li>
            <li><a href="{{ route('admin::work_times.index') }}"><i class="fa fa-circle"></i> Thời gian làm việc</a>
            </li>
            <li><a href="{{ route('admin::over_times.index') }}"><i class="fa fa-circle"></i> Làm thêm</a></li>
        </ul>
    </li>
</ul>
