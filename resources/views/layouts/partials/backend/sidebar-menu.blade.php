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
            <i class="fa fa-users"></i> <span>Nhóm</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::projects.index', 'admin::projects.create', 'admin::projects.edit', 'admin::projects.show']) ? 'active': '' }}">
        <a href="{{ route('admin::projects.index') }}">
            <i class="fa fa-anchor"></i> <span>Dự án</span>
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
    <li class="treeview {{ \App\Utils::checkRoute([
    'admin::regulations.index',
    'admin::regulations.create',
    'admin::regulations.edit',
    'admin::rules.index',
    'admin::rules.create',
    'admin::rules.edit',
    ]) ? 'active': '' }}">
        <a href="#">
            <i class="fa fa-podcast"></i>
            <span>Nội quy/Quy định</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ \App\Utils::checkRoute(['admin::regulations.index', 'admin::regulations.create', 'admin::regulations.edit']) ? 'active': '' }}">
                <a href="{{ route('admin::regulations.index') }}">
                    <i class="fa fa-circle"></i> <span>Danh sách</span>
                </a>
            </li>
            <li class="{{ \App\Utils::checkRoute(['admin::rules.index', 'admin::rules.create', 'admin::rules.edit']) ? 'active': '' }}">
                <a href="{{ route('admin::rules.index') }}">
                    <i class="fa fa-circle"></i> <span>Quy định tiền phạt</span>
                </a>
            </li>
        </ul>
    <li class="treeview {{ \App\Utils::checkRoute([
    'admin::day_offs.index',
    'admin::day_offs.create',
    'admin::day_offs.edit',
    'admin::day_offs.user',
    'admin::work_times.index',
    'admin::work_times.create',
    'admin::work_times.import',
    'admin::work_times.edit',
    'admin::over_times.index',
    'admin::over_times.create',
    'admin::over_times.edit',
    'admin::work_time_register.index',
    'admin::work_time_register.create',
    'admin::work_time_register.import',
    'admin::work_time_register.edit',
    'admin::work_time_statistic.index',
    ]) ? 'active': '' }}">
        <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Thời gian làm việc</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin::day_offs.index') }}"><i class="fa fa-circle"></i> Nghỉ phép</a></li>
            <li><a href="{{ route('admin::work_times.index') }}"><i class="fa fa-circle"></i> Thời gian làm việc</a>
            </li>

            <li><a href="{{ route('admin::over_times.index') }}"><i class="fa fa-circle"></i> Làm thêm</a>
            </li>



            <li><a href="{{ route('admin::work_time_register.index') }}"><i class="fa fa-circle"></i> Đăng ký lịch làm
                    việc</a></li>
            <li><a href="{{ route('admin::work_time_statistic.index') }}"><i class="fa fa-circle"></i> Thống kê</a></li>
        </ul>
    </li>
    <li class="treeview {{ \App\Utils::checkRoute([
    'admin::devices.index',
    'admin::devices.create',
    'admin::devices.edit',
    'admin::deviceusers.index',
    'admin::deviceusers.create',
    'admin::deviceusers.edit',
    ]) ? 'active': '' }}">
        <a href="#">
            <i class="fa fa-desktop"></i>
            <span>Quản lý thiết bị</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('admin::devices.index') }}"><i class="fa fa-circle"></i> Quản lý thiết bị</a></li>
            <li><a href="{{ route('admin::deviceusers.index') }}"><i class="fa fa-circle"></i> Cấp thiết bị</a></li>
        </ul>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::meetings.index', 'admin::meetings.create', 'admin::meetings.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::meetings.index') }}">
            <i class="fa fa-bank"></i> <span>Phòng họp</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::punishes.index', 'admin::punishes.create', 'admin::punishes.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::punishes.index') }}">
            <i class="fa fa-money"></i> <span>Danh sách vi phạm</span>
        </a>
    </li>
</ul>
