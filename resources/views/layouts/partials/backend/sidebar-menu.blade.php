<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li class="{{ \App\Utils::checkRoute(['dashboard::index', 'admin::index']) ? 'active': '' }}">
        <a href="/admin">
            <i class="fa fa-dashboard"></i> <span>Trang quản trị</span>
        </a>
    </li>
    <li class="{{ \App\Utils::checkRoute(['admin::users.index', 'admin::users.create', 'admin::users.edit']) ? 'active': '' }}">
        <a href="{{ route('admin::users.index') }}">
            <i class="fa fa-user"></i> <span>Nhân viên</span>
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
    {{--<li class="treeview {{ \App\Utils::checkRoute(['admin::phrases.index', 'admin::keywords.create']) ? 'active': '' }}">--}}
        {{--<a href="#"><i class="fa fa-cog"></i> <span>Configuration</span>--}}
            {{--<span class="pull-right-container">--}}
                {{--<i class="fa fa-angle-left pull-right"></i>--}}
              {{--</span>--}}
        {{--</a>--}}
        {{--<ul class="treeview-menu">--}}
            {{--<li><a href="#">System configuration</a></li>--}}
            {{--<li><a href="{{ route('admin::phrases.index') }}">Phrases</a></li>--}}
            {{--<li><a href="{{ route('admin::keywords.index') }}">Suggest keywords</a></li>--}}
        {{--</ul>--}}
    {{--</li>--}}
    {{--@endif--}}
</ul>
